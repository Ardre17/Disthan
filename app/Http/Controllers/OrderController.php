<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderDetail;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{

    public function pedidos()
{
    $orders = \App\Models\Order::where('estado', '!=', 'COMPLETO')
        ->latest()
        ->get();

    return view('orders.pedidos', compact('orders'));
}

    public function cerrar(Order $order)
{
    // 🔥 SOLO cerrar si es encomienda
    if ($order->tipo_orden == 'ENCOMIENDA') {
        $order->estado = 'COMPLETO';
    } else {
        // comportamiento normal
        $order->estado = 'COMPLETO';
    }

    $order->save();

    return redirect('/pedidos')->with('success', 'Orden cerrada correctamente');
}

    public function destroy(Order $order)
{
    // eliminar detalles primero (si no tienes cascade)
    $order->details()->delete();

    $order->delete();

    return redirect()->route('orders.index')
        ->with('success', 'Orden eliminada correctamente');
}

    public function eliminarDeBulto(\App\Models\BultoDetalle $detalle)
{
    $bulto = $detalle->bulto;
    $product = $detalle->product;

    $cantidad = $detalle->cantidad;

    // 🔥 recalcular peso
    $pesoProducto = ($product->peso * $cantidad) / 1000;
    $pesoExtra = 0.5;
    $pesoTotal = $pesoProducto + $pesoExtra;

    // 🔥 restar peso
    $bulto->peso_total -= $pesoTotal;

    if ($bulto->peso_total < 0) {
        $bulto->peso_total = 0;
    }

    $bulto->save();

    // 🔥 eliminar registro
    $detalle->delete();

    return back()->with('success', '🗑 Producto eliminado del bulto');
}
    public function crearBulto(Order $order)
{
    $count = $order->bultos()->count() + 1;

    $order->bultos()->create([
        'nombre' => 'Bulto '.$count
    ]);

    return back();
}

public function agregarABulto(Request $request, \App\Models\Bulto $bulto)
{
    $product = \App\Models\Product::find($request->product_id);

    $cantidad = (int) $request->cantidad;

    // 🔥 VALIDACIÓN: NO EXCEDER LO SOLICITADO
    $totalEnBultos = $bulto->order->bultos
        ->flatMap->detalles
        ->where('product_id', $product->id)
        ->sum('cantidad');

    $detalleOrden = $bulto->order->details
        ->where('product_id', $product->id)
        ->first();

    $max = $detalleOrden->cantidad_solicitada;

    if (($totalEnBultos + $cantidad) > $max) {
        return back()->with('error', '❌ Excede lo solicitado');
    }

    // 🔥 PESO
    $pesoProducto = ($product->peso * $cantidad) / 1000;
    $pesoExtra = 0.5;
    $pesoTotal = $pesoProducto + $pesoExtra;

    // 🔥 GUARDAR
    $bulto->detalles()->create([
        'product_id' => $product->id,
        'cantidad' => $cantidad
    ]);

    $bulto->peso_total += $pesoTotal;
    $bulto->save();

    return back()->with('success', '✅ Producto agregado al bulto');
}
    public function dashboard()
{
    $data = Order::selectRaw('client_id, COUNT(*) as total')
        ->whereMonth('fecha_pedido', now()->month)
        ->groupBy('client_id')
        ->with('client')
        ->get();

    return view('dashboard', compact('data'));
}

public function historial(Request $request)
{
    $query = Order::with(['client', 'details'])
        ->where('estado', 'COMPLETO');

    // ── Filtro por fecha ──────────────────────────────────────────────
    if ($request->filled('fecha_inicio')) {
        $query->whereDate('fecha_pedido', '>=', $request->fecha_inicio);
    }
    if ($request->filled('fecha_fin')) {
        $query->whereDate('fecha_pedido', '<=', $request->fecha_fin);
    }

    // ── Filtro por cliente o número de orden ──────────────────────────
    if ($request->filled('cliente')) {
        $busqueda = $request->cliente;
        $query->where(function ($q) use ($busqueda) {
            $q->where('numero_orden', 'like', '%' . $busqueda . '%')
              ->orWhereHas('client', fn($c) =>
                  $c->where('razon_social', 'like', '%' . $busqueda . '%')
              );
        });
    }

    // ── Filtro por tipo de orden ──────────────────────────────────────
    if ($request->filled('tipo_orden')) {
        $query->where('tipo_orden', $request->tipo_orden);
    }

    // ── Ordenamiento ──────────────────────────────────────────────────
    match ($request->get('orden', 'fecha_desc')) {
        'fecha_asc'  => $query->orderBy('fecha_pedido', 'asc'),
        'total_desc' => $query->orderBy('total', 'desc'),
        'total_asc'  => $query->orderBy('total', 'asc'),
        default      => $query->orderBy('fecha_pedido', 'desc'),
    };

    $orders = $query->paginate(20)->withQueryString();

    // ── Datos para el gráfico de facturación mensual (últimos 6 meses) ─
    $chartQuery = Order::where('estado', 'COMPLETO');

    if ($request->filled('tipo_orden')) {
        $chartQuery->where('tipo_orden', $request->tipo_orden);
    }

    $datosGrafico = $chartQuery
    ->selectRaw("TO_CHAR(fecha_pedido, 'YYYY-MM') as mes, SUM(total) as monto, COUNT(*) as cant")
    ->whereDate('fecha_pedido', '>=', now()->subMonths(5)->startOfMonth())
    ->groupByRaw("TO_CHAR(fecha_pedido, 'YYYY-MM')")
    ->orderBy('mes')
    ->get();

    // Rellenar los 6 meses aunque no tengan datos
    $meses   = [];
    $montos  = [];
    $cantOrd = [];

    for ($i = 5; $i >= 0; $i--) {
        $fecha = now()->subMonths($i);
        $key   = $fecha->format('Y-m');

        $fila = $datosGrafico->firstWhere('mes', $key);

        $meses[]   = ucfirst($fecha->locale('es')->isoFormat('MMM YY'));
        $montos[]  = $fila ? (float) $fila->monto : 0;
        $cantOrd[] = $fila ? (int)   $fila->cant  : 0;
    }

    return view('orders.historial', compact(
        'orders',
        'meses',
        'montos',
        'cantOrd'
    ));
}

    public function operario(Order $order)
{
    $order->load('details.product');

    return view('orders.operario', compact('order'));
}
   public function pdf(Order $order)
{
    $order->load(['client','details.product']);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'orders.pdf',
        compact('order')
    );

    return $pdf->stream(
        $order->numero_orden.'.pdf'
    );
}
public function pdfEncomienda(Order $order)
{
    $order->load([
        'client',
        'details.product',
        'bultos.detalles.product'
    ]);

    $pdf = Pdf::loadView(
        'orders.pdf_encomienda',
        compact('order')
    );

    $pdf->setPaper('A4', 'portrait');

    return $pdf->stream(
        'Encomienda_'.$order->numero_orden.'.pdf'
    );
}

    public function addProduct(
    Request $request,
    Order $order
)
{
    $product = Product::findOrFail(
        $request->product_id
    );

    OrderDetail::create([

        'order_id' => $order->id,

        'product_id' => $product->id,

        'cantidad_solicitada' =>
            $request->cantidad_solicitada,

        'cantidad_despachada' => 0,

        'precio_unitario' =>
            $request->precio_unitario,

        'subtotal' => 0,

        'estado_item' =>
            'INCOMPLETO'
    ]);

    return back()->with(
        'success',
        'Producto agregado'
    );
}

    public function index(Request $request)
{
    $query = Order::with('client')
    ->where('estado', '!=', 'COMPLETO');

    if ($request->filled('fecha_inicio')) {

        $query->whereDate(
            'fecha_pedido',
            '>=',
            $request->fecha_inicio
        );
    }

    if ($request->filled('fecha_fin')) {

        $query->whereDate(
            'fecha_pedido',
            '<=',
            $request->fecha_fin
        );
    }

    if ($request->filled('estado')) {

        $query->where(
            'estado',
            $request->estado
        );
    }

    $orders = $query
        ->latest()
        ->paginate(20);

    return view(
        'orders.index',
        compact('orders')
    );
}

    public function create()
    {
        $clients = Client::where('activo', true)
            ->orderBy('razon_social')
            ->get();

        return view(
            'orders.create',
            compact('clients')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'tipo_orden' => 'required',
            'fecha_pedido' => 'required'
        ]);

        $lastOrder = Order::max('id') + 1;

        $order = Order::create([

            'numero_orden' => 'ORD-'.str_pad(
                $lastOrder,
                6,
                '0',
                STR_PAD_LEFT
            ),

            'client_id' => $request->client_id,

            'tipo_orden' => $request->tipo_orden,

            'fecha_pedido' => $request->fecha_pedido,

            'fecha_entrega' => $request->fecha_entrega,

            'estado' => 'INCOMPLETO',

            'observaciones' => $request->observaciones,

            'subtotal' => 0,
            'igv' => 0,
            'total' => 0
        ]);

        return redirect()
            ->route('orders.edit', $order)
            ->with(
                'success',
                'Orden creada correctamente'
            );
    }

    public function show(Order $order)
    {
        //
    }

    public function edit(Order $order)
{
    $order->load(['client','details.product','bultos.detalles.product']);

    // 🔥 ESTO FALTABA
    $products = \App\Models\Product::where('activo', true)
        ->orderBy('nombre')
        ->get();

    $tipo = strtoupper(trim($order->tipo_orden));

    if ($tipo == 'SUPERMERCADO') {
        return view('orders.edit', compact('order','products'));
    }

    if ($tipo == 'LOCAL') {
        return view('orders.edit_local', compact('order','products'));
    }

    if ($tipo == 'ENCOMIENDA') {
        return view('orders.edit_encomienda', compact('order','products'));
    }

    if ($tipo == 'EXPORTACION') {
        return view('orders.edit_exportacion', compact('order','products'));
    }
    return view('orders.edit', compact('order','products'));
}

public function updateDetail(Request $request, OrderDetail $detail)
{
    $cantidadSolicitada = (float) $request->input('cantidad_solicitada');
    $cantidadDespachada = (float) $request->input('cantidad_despachada');
    $precio = (float) $request->input('precio_unitario');

    $subtotal = $cantidadDespachada * $precio;

    // 🔥 ESTADO DEL ITEM
    if ($cantidadDespachada <= 0) {
        $estado = 'INCOMPLETO';
    } elseif ($cantidadDespachada < $cantidadSolicitada) {
        $estado = 'PARCIAL';
    } else {
        $estado = 'COMPLETO';
    }

    // 🔥 CONTROL DE STOCK
    $producto = $detail->product;

    $cantidadAntes = $detail->cantidad_despachada ?? 0;
    $cantidadNueva = $cantidadDespachada;

    $diferencia = $cantidadNueva - $cantidadAntes;

    if ($diferencia > 0) {

        if ($producto->stock <= 0) {
            return back()->with('error', '❌ Sin stock disponible. Crear orden de producción');
        }

        if ($producto->stock < $diferencia) {
            return back()->with('error', 
                '⚠️ Stock insuficiente. Disponible: ' . $producto->stock . 
                ' | Faltante: ' . ($diferencia - $producto->stock)
            );
        }

        $producto->stock -= $diferencia;
        $producto->save();
    }

    // 🔥 SI DISMINUYE → DEVOLVER STOCK
    if ($diferencia < 0) {
        $producto->stock += abs($diferencia);
        $producto->save();
    }

    // 🔥 ACTUALIZAR DETALLE
    $detail->update([
        'cantidad_solicitada' => $cantidadSolicitada,
        'cantidad_despachada' => $cantidadDespachada,
        'precio_unitario' => $precio,

        'paleta' => $request->input('paleta'),
        'fecha_vencimiento' => $request->input('fecha_vencimiento'),
        'nivel' => $request->input('nivel'),
        'ubicacion' => $request->input('ubicacion'),

        'estado_item' => $estado,
        'subtotal' => $subtotal,
    ]);

    // 🔄 ACTUALIZAR ORDEN
    $order = $detail->order;

    // 🔥 TOTALES CORRECTOS
    $order->subtotal = $order->details()->sum('subtotal');
    $order->igv = round($order->subtotal * 0.18, 2);
    $order->total = $order->subtotal + $order->igv;

    $items = $order->details;

    // 🔥 ESTADO DINÁMICO REAL (CORREGIDO)
    if ($order->tipo_orden != 'ENCOMIENDA') {

        $totalSolicitado = $items->sum('cantidad_solicitada');
        $totalDespachado = $items->sum('cantidad_despachada');

        if ($totalDespachado <= 0) {
            $order->estado = 'INCOMPLETO';
        } elseif ($totalDespachado >= $totalSolicitado) {
            $order->estado = 'COMPLETO';
        } else {
            $order->estado = 'PARCIAL';
        }
    }

    $order->save();

    // 🔥 RESPUESTA
    if ($request->expectsJson()) {
        return response()->json([
            'success' => true,
            'estado' => $estado
        ]);
    }

    return back()->with('success', 'Detalle actualizado correctamente');
}

    public function destroyDetail(OrderDetail $detail)
{
    $order = $detail->order;

    // eliminar item
    $detail->delete();

    // recalcular totales
    $order->subtotal = $order->details()->sum('subtotal');
    $order->igv = round($order->subtotal * 0.18, 2);
    $order->total = $order->subtotal + $order->igv;

    // recalcular estado de la orden
    $items = $order->details;

    if ($items->isEmpty()) {
        $order->estado = 'INCOMPLETO';
    } elseif ($items->every(fn ($i) => $i->estado_item === 'COMPLETO')) {
        $order->estado = 'COMPLETO';
    } elseif ($items->contains(fn ($i) => $i->estado_item === 'PARCIAL')) {
        $order->estado = 'PARCIAL';
    } else {
        $order->estado = 'INCOMPLETO';
    }

    $order->save();

    return back()->with('success', 'Producto eliminado de la orden');
}

    public function importCsv(
    Request $request,
    Order $order
)
{
    $request->validate([
        'archivo' => 'required|file|mimes:csv,txt'
    ]);

    $file = fopen(
        $request->file('archivo')->getRealPath(),
        'r'
    );

    $fila = 0;

    while (($data = fgetcsv($file, 1000, ',')) !== false) {

        $fila++;

        if ($fila == 1) {
            continue;
        }

        $sku = trim($data[0]);
        $cantidad = (float)$data[1];
        $precio = (float)$data[2];

        $product = Product::where(
            'sku',
            $sku
        )->first();

        if (!$product) {
            continue;
        }

        OrderDetail::create([

            'order_id' => $order->id,

            'product_id' => $product->id,

            'cantidad_solicitada' => $cantidad,

            'cantidad_despachada' => 0,

            'precio_unitario' => $precio,

            'subtotal' =>
                $cantidad * $precio,

            'estado_item' =>
                'INCOMPLETO',
        ]);
    }

    fclose($file);

    $order->subtotal =
        $order->details()->sum('subtotal');

    $order->igv =
        round($order->subtotal * 0.18, 2);

    $order->total =
        $order->subtotal +
        $order->igv;

    $order->save();

    return back()->with(
        'success',
        'Pedido importado correctamente'
    );
}

}