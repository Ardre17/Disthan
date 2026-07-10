<?php
namespace App\Http\Controllers;

use App\Models\JoselitoItem;
use App\Models\JoselitoMovement;
use Illuminate\Http\Request;

class JoselitoController extends Controller
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
        // Solo ítems con stock > 0 en la vista principal
        $items = JoselitoItem::conStock()
                    ->orderByDesc('fecha_llegada')
                    ->get();

        // Historial global — últimos 60 movimientos
        $movimientos = JoselitoMovement::with('item')
                        ->orderByDesc('created_at')
                        ->take(60)
                        ->get();

        // KPIs
        $totalCajas    = $items->sum('cantidad_actual');
        $totalItems    = $items->count();
        $poco          = $items->filter(fn($i) => $i->estado === 'POCO')->count();

        // Provincias activas
        $provincias = $items->pluck('origen')->unique()->values();

        return view('joselito.index', compact(
            'items','movimientos','totalCajas','totalItems','poco','provincias'
        ));
    }

    public function create()
    {
        return view('joselito.create', [
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

        $item = JoselitoItem::create([
            'nombre'        => $request->nombre,
            'proveedor'     => $request->proveedor,
            'origen'        => $request->origen,
            'fecha_llegada' => $request->fecha_llegada,
            'cantidad_actual'=> floatval($request->cantidad),
            'observaciones' => $request->observaciones,
            'activo'        => true,
        ]);

        JoselitoMovement::create([
            'joselito_item_id' => $item->id,
            'tipo'             => 'ENTRADA',
            'cantidad'         => floatval($request->cantidad),
            'motivo'           => 'Llegada de provincia',
            'destino'          => null,
            'saldo_post'       => floatval($request->cantidad),
        ]);

        return redirect()->route('joselito.index')
                         ->with('success', 'Mercadería registrada correctamente.');
    }

    public function show(JoselitoItem $joselito)
    {
        $movements = $joselito->movements()->paginate(20);
        return view('joselito.show', compact('joselito','movements'));
    }

    public function movimiento(Request $request, JoselitoItem $joselito)
    {
        $request->validate([
            'tipo'     => 'required|in:ENTRADA,SALIDA',
            'cantidad' => 'required|numeric|min:0.01',
            'motivo'   => 'required|string|max:255',
            'destino'  => 'nullable|string|max:255',
        ]);

        $cantidad = floatval($request->cantidad);

        if ($request->tipo === 'SALIDA' && $cantidad > $joselito->cantidad_actual) {
            return back()->withErrors([
                'cantidad' => 'Cantidad insuficiente. Disponible: '.$joselito->cantidad_actual.' cajas'
            ]);
        }

        $nuevoSaldo = $request->tipo === 'ENTRADA'
            ? $joselito->cantidad_actual + $cantidad
            : $joselito->cantidad_actual - $cantidad;

        JoselitoMovement::create([
            'joselito_item_id' => $joselito->id,
            'tipo'             => $request->tipo,
            'cantidad'         => $cantidad,
            'motivo'           => $request->motivo,
            'destino'          => $request->destino,
            'saldo_post'       => $nuevoSaldo,
        ]);

        $joselito->cantidad_actual = $nuevoSaldo;
        $joselito->save();

        return back()->with('success',
            ($request->tipo === 'ENTRADA' ? '+' : '−').
            $cantidad.' cajas registradas.'
        );
    }
}