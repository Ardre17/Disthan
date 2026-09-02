<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderValidation;
use App\Models\OrderValidationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderValidationController extends Controller
{
    public function datos(Order $order)
{
    $order->load([
        'client',
        'details.product',
    ]);

    return response()->json([
        'success' => true,
        'order' => $order,
    ]);
}

    public function index()
{
    // =========================================================
    // PEDIDOS QUE NUNCA HAN SIDO VALIDADOS
    // =========================================================
    $pendientes = Order::with('client')
        ->whereDoesntHave('validations')
        ->latest('fecha_pedido')
        ->get();


    // =========================================================
    // HISTORIAL DE VALIDACIONES
    // =========================================================
    $historial = OrderValidation::with([
        'order.client',
        'usuario',
        'details.orderDetail.product',
    ])
        ->latest('fecha_validacion')
        ->get();


    return view('orders.validation.index', compact(
        'pendientes',
        'historial'
    ));
}

    /**
     * Buscar un pedido por factura o guía.
     */
    public function buscar(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:100',
        ]);

        $codigo = trim($request->codigo);

        $order = Order::with([
            'client',
            'details.product',
        ])
        ->where(function ($query) use ($codigo) {
            $query->where('factura_asociada', $codigo)
                  ->orWhere('guia_asociada', $codigo);
        })
        ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró ningún pedido con esa factura o guía.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'order' => $order,
        ]);
    }

    /**
     * Registrar una validación completa del pedido.
     */
    public function guardar(Request $request, Order $order)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.order_detail_id' => 'required|integer',
            'items.*.estado' => 'required|in:COMPLETO,PARCIAL,NO_ENVIADO',
            'items.*.cantidad_validada' => 'nullable|numeric|min:0',
            'items.*.codigo_escaneado' => 'nullable|string|max:100',
            'items.*.observaciones' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $order) {

            /*
             * Determinar el estado general del pedido.
             */
            $estados = collect($request->items)
                ->pluck('estado');

            if ($estados->every(fn ($estado) => $estado === 'COMPLETO')) {
                $estadoGeneral = 'COMPLETO';
            } elseif ($estados->every(fn ($estado) => $estado === 'NO_ENVIADO')) {
                $estadoGeneral = 'NO_ENVIADO';
            } else {
                $estadoGeneral = 'PARCIAL';
            }

            /*
             * Crear una nueva sesión de validación.
             *
             * Nunca modificamos las validaciones anteriores.
             */
            $validation = OrderValidation::create([
                'order_id' => $order->id,
                'usuario_id' => auth()->id(),
                'estado' => $estadoGeneral,
                'observaciones' => $request->observaciones,
                'fecha_validacion' => now(),
            ]);

            /*
             * Registrar cada producto validado.
             */
            foreach ($request->items as $item) {

                $detail = OrderDetail::where('id', $item['order_detail_id'])
                    ->where('order_id', $order->id)
                    ->firstOrFail();

                $cantidadValidada = $item['cantidad_validada'] ?? 0;

                $validation->details()->create([
                    'order_detail_id' => $detail->id,
                    'estado' => $item['estado'],
                    'cantidad_solicitada' => $detail->cantidad_solicitada,
                    'cantidad_validada' => $cantidadValidada,
                    'codigo_escaneado' => $item['codigo_escaneado'] ?? null,
                    'observaciones' => $item['observaciones'] ?? null,
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Validación guardada correctamente.',
        ]);
    }

    /**
     * Buscar un producto por código de barras.
     *
     * Busca tanto el código unitario como el código de caja.
     */
    public function buscarProducto(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:100',
        ]);

        $codigo = trim($request->codigo);

        $product = \App\Models\Product::where('barcode', $codigo)
            ->orWhere('box_barcode', $codigo)
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'product' => $product,
        ]);
    }

    /**
     * Obtener el historial de validaciones de un pedido.
     */
    public function historial(Order $order)
    {
        $validations = $order->validations()
            ->with([
                'usuario',
                'details.orderDetail.product',
            ])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'validations' => $validations,
        ]);
    }
}