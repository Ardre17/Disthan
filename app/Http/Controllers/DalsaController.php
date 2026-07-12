<?php
namespace App\Http\Controllers;

use App\Models\DalsaItem;
use App\Models\DalsaMovement;
use Illuminate\Http\Request;

class DalsaController extends Controller
{
    const CIUDADES = [
        'Arequipa','Cusco','Trujillo','Chiclayo','Piura',
        'Iquitos','Huancayo','Puno','Tacna','Cajamarca',
        'Ayacucho','Ica','Chimbote','Lima','Otro'
    ];

    const MOTIVOS_ENTRADA = [
        'Llegada de provincia',
        'Reingreso de mercadería',
        'Ajuste de inventario',
        'Otro',
    ];

    const MOTIVOS_SALIDA = [
        'Traslado al almacén central',
        'Entrega a cliente',
        'Traslado a otro destino',
        'Devolución a proveedor',
        'Merma',
        'Ajuste de inventario',
        'Otro',
    ];

    public function index(Request $request)
    {
        $items = DalsaItem::conStock()
                    ->orderByDesc('fecha_llegada')
                    ->get();

        $movimientos = DalsaMovement::with('item')
                        ->orderByDesc('created_at')
                        ->take(60)
                        ->get();

        $totalCajas  = $items->sum('cantidad_actual');
        $totalItems  = $items->count();
        $poco        = $items->filter(fn($i) => $i->estado === 'POCO')->count();
        $provincias  = $items->pluck('origen')->unique()->values();

        return view('dalsa.index', compact(
            'items','movimientos','totalCajas','totalItems','poco','provincias'
        ));
    }

    public function create()
    {
        return view('dalsa.create', [
            'ciudades' => self::CIUDADES,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'proveedor'     => 'required|string|max:255',
            'origen'        => 'required|string|max:100',
            'fecha_llegada' => 'required|date',
            'cantidad'      => 'required|numeric|min:0.01',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $item = DalsaItem::create([
            'nombre'         => $request->nombre,
            'proveedor'      => $request->proveedor,
            'origen'         => $request->origen,
            'fecha_llegada'  => $request->fecha_llegada,
            'cantidad_actual'=> floatval($request->cantidad),
            'observaciones'  => $request->observaciones,
            'activo'         => true,
        ]);

        DalsaMovement::create([
            'dalsa_item_id' => $item->id,
            'tipo'          => 'ENTRADA',
            'cantidad'      => floatval($request->cantidad),
            'motivo'        => 'Llegada de provincia',
            'destino'       => null,
            'saldo_post'    => floatval($request->cantidad),
        ]);

        return redirect()->route('dalsa.index')
                         ->with('success', 'Mercadería registrada correctamente en Dalsa.');
    }

    public function show(DalsaItem $dalsa)
    {
        $movements = $dalsa->movements()->paginate(20);
        return view('dalsa.show', compact('dalsa','movements'));
    }

    public function movimiento(Request $request, DalsaItem $dalsa)
    {
        $request->validate([
            'tipo'     => 'required|in:ENTRADA,SALIDA',
            'cantidad' => 'required|numeric|min:0.01',
            'motivo'   => 'required|string|max:255',
            'destino'  => 'nullable|string|max:255',
        ]);

        $cantidad = floatval($request->cantidad);

        if ($request->tipo === 'SALIDA' && $cantidad > $dalsa->cantidad_actual) {
            return back()->withErrors([
                'cantidad' => 'Cantidad insuficiente. Disponible: '.$dalsa->cantidad_actual.' cajas'
            ]);
        }

        $nuevoSaldo = $request->tipo === 'ENTRADA'
            ? $dalsa->cantidad_actual + $cantidad
            : $dalsa->cantidad_actual - $cantidad;

        DalsaMovement::create([
            'dalsa_item_id' => $dalsa->id,
            'tipo'          => $request->tipo,
            'cantidad'      => $cantidad,
            'motivo'        => $request->motivo,
            'destino'       => $request->destino,
            'saldo_post'    => $nuevoSaldo,
        ]);

        $dalsa->cantidad_actual = $nuevoSaldo;
        $dalsa->save();

        return back()->with('success',
            ($request->tipo === 'ENTRADA' ? '+' : '−').
            $cantidad.' cajas registradas.'
        );
    }
}