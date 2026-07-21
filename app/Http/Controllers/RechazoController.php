<?php
namespace App\Http\Controllers;

use App\Models\Rechazo;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class RechazoController extends Controller
{
    const MOTIVOS = [
        'Producto dañado',
        'Fecha de vencimiento próxima',
        'Fecha de vencimiento vencida',
        'Error de pedido',
        'Exceso de cantidad',
        'Cliente no disponible',
        'Producto incorrecto',
        'Otro',
    ];

    public function index(Request $request)
    {
        // Historial global de rechazos
        $query = Rechazo::with(['order.client','detail.product'])
                    ->orderByDesc('fecha_rechazo');

        if ($request->filled('search')) {
            $query->whereHas('order', function($q) use ($request) {
                $q->where('numero_orden','like','%'.$request->search.'%')
                  ->orWhereHas('client', function($q2) use ($request) {
                      $q2->where('razon_social','like','%'.$request->search.'%');
                  });
            });
        }

        if ($request->filled('motivo')) {
            $query->where('motivo', $request->motivo);
        }

        $rechazos   = $query->paginate(30);
        $totalItems = Rechazo::count();
        $motivos    = self::MOTIVOS;

        return view('rechazos.index', compact('rechazos','totalItems','motivos'));
    }

    public function create()
    {
        $motivos = self::MOTIVOS;
        return view('rechazos.create', compact('motivos'));
    }

    // AJAX: buscar orden por número
    public function buscarOrden(Request $request)
    {
        $q = $request->get('q','');

        $orders = Order::with('client')
            ->where('numero_orden','like','%'.$q.'%')
            ->orWhereHas('client', function($query) use ($q) {
                $query->where('razon_social','like','%'.$q.'%');
            })
            ->whereIn('estado',['COMPLETO','PARCIAL'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get()
            ->map(fn($o) => [
                'id'           => $o->id,
                'numero_orden' => $o->numero_orden,
                'cliente'      => $o->client->razon_social ?? '—',
                'estado'       => $o->estado,
            ]);

        return response()->json($orders);
    }

    // AJAX: cargar productos de una orden
    public function productosOrden(Order $order)
    {
        $detalles = $order->details()
            ->with('product')
            ->where('cantidad_despachada', '>', 0)
            ->get()
            ->map(fn($d) => [
                'id'                  => $d->id,
                'producto'            => $d->product->nombre,
                'sku'                 => $d->product->sku ?? '—',
                'cantidad_solicitada' => $d->cantidad_solicitada,
                'cantidad_despachada' => $d->cantidad_despachada,
                'rechazado_previo'    => $d->rechazos()->sum('cantidad_rechazada'),
                'disponible'          => $d->cantidad_despachada - $d->rechazos()->sum('cantidad_rechazada'),
            ]);

        return response()->json([
            'orden'    => [
                'numero' => $order->numero_orden,
                'cliente'=> $order->client->razon_social ?? '—',
                'estado' => $order->estado,
                'fecha'  => $order->fecha_pedido,
            ],
            'detalles' => $detalles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id'           => 'required|exists:orders,id',
            'order_detail_id'    => 'required|exists:order_details,id',
            'cantidad_rechazada' => 'required|numeric|min:0.01',
            'motivo'             => 'required|string',
            'observaciones'      => 'nullable|string|max:500',
            'fecha_rechazo'      => 'required|date',
        ]);

        $detail = OrderDetail::findOrFail($request->order_detail_id);

        // Validar que no rechace más de lo despachado
        $yaRechazado   = $detail->rechazos()->sum('cantidad_rechazada');
        $disponible    = $detail->cantidad_despachada - $yaRechazado;

        if ($request->cantidad_rechazada > $disponible) {
            return back()->withErrors([
                'cantidad_rechazada' =>
                    "Solo puedes rechazar {$disponible} unidades de este producto."
            ])->withInput();
        }

        // 1. Registrar el rechazo
        Rechazo::create([
            'order_id'           => $request->order_id,
            'order_detail_id'    => $request->order_detail_id,
            'cantidad_rechazada' => $request->cantidad_rechazada,
            'motivo'             => $request->motivo,
            'observaciones'      => $request->observaciones,
            'fecha_rechazo'      => $request->fecha_rechazo,
        ]);

        // 2. Descontar de cantidad_despachada en el detalle
        $detail->cantidad_despachada -= $request->cantidad_rechazada;
        $detail->subtotal = $detail->cantidad_despachada * $detail->precio_unitario;

        // Recalcular estado del ítem
        if ($detail->cantidad_despachada <= 0) {
            $detail->estado_item = 'INCOMPLETO';
        } elseif ($detail->cantidad_despachada < $detail->cantidad_solicitada) {
            $detail->estado_item = 'PARCIAL';
        } else {
            $detail->estado_item = 'COMPLETO';
        }
        $detail->save();

        // 3. Devolver al stock del producto
        $product = $detail->product;
        $product->stock += $request->cantidad_rechazada;
        $product->save();

        // 4. Recalcular estado de la orden
        $order  = $detail->order;
        $items  = $order->details;
        if ($items->every(fn($i) => $i->estado_item === 'COMPLETO')) {
            $order->estado = 'COMPLETO';
        } elseif ($items->contains(fn($i) => $i->cantidad_despachada > 0)) {
            $order->estado = 'PARCIAL';
        } else {
            $order->estado = 'INCOMPLETO';
        }
        $order->subtotal = $items->sum('subtotal');
        $order->igv      = round($order->subtotal * 0.18, 2);
        $order->total    = $order->subtotal + $order->igv;
        $order->save();

        return redirect()->route('rechazos.index')
                         ->with('success',
                             "Rechazo registrado. {$request->cantidad_rechazada} unidades de «{$product->nombre}» devueltas al stock."
                         );
    }
}