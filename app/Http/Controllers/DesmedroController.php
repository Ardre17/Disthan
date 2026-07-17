<?php

namespace App\Http\Controllers;

use App\Models\Desmedro;
use App\Models\DesmedroDetalle;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DesmedroController extends Controller
{
    /**
     * Lista de desmedros + borrador en construcción del usuario (si existe).
     */
    public function index()
    {
        $desmedros = Desmedro::withCount('detalles')
            ->with('usuario')
            ->where('estado', 'registrado')
            ->latest('registrado_at')
            ->paginate(15);

        // Si el usuario dejó una caja a medio armar, la recuperamos
        $borrador = Desmedro::with('detalles.producto')
            ->where('estado', 'borrador')
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        // ---- KPIs ----
        $registrados = Desmedro::where('estado', 'registrado');
        $totalCajas = (clone $registrados)->count();
        $totalUnidades = (float) DesmedroDetalle::whereHas('desmedro', fn ($q) => $q->where('estado', 'registrado'))->sum('cantidad');

        $inicioMes = now()->startOfMonth();
        $cajasEsteMes = (clone $registrados)->where('registrado_at', '>=', $inicioMes)->count();
        $unidadesEsteMes = (float) DesmedroDetalle::whereHas('desmedro', fn ($q) => $q->where('estado', 'registrado')->where('registrado_at', '>=', $inicioMes))->sum('cantidad');

        $promedioPorCaja = $totalCajas > 0 ? $totalUnidades / $totalCajas : 0;

        $kpis = [
            'total_cajas'       => $totalCajas,
            'total_unidades'    => $totalUnidades,
            'cajas_este_mes'    => $cajasEsteMes,
            'unidades_este_mes' => $unidadesEsteMes,
            'promedio_caja'     => $promedioPorCaja,
        ];

        // ---- Tendencia: últimos 6 meses (cajas registradas por mes) ----
        $tendencia = collect(range(5, 0))->map(function ($i) {
            $mes = now()->subMonths($i);
            $cantidad = Desmedro::where('estado', 'registrado')
                ->whereYear('registrado_at', $mes->year)
                ->whereMonth('registrado_at', $mes->month)
                ->count();
            return [
                'label'    => ucfirst($mes->translatedFormat('M')),
                'cantidad' => $cantidad,
            ];
        });

        // ---- Top 5 productos con más unidades desmedradas ----
        $topProductos = DesmedroDetalle::query()
            ->whereHas('desmedro', fn ($q) => $q->where('estado', 'registrado'))
            ->selectRaw('producto_id, SUM(cantidad) as total')
            ->groupBy('producto_id')
            ->orderByDesc('total')
            ->with('producto:id,nombre,sku')
            ->limit(5)
            ->get();

        return view('desmedros.index', compact('desmedros', 'borrador', 'kpis', 'tendencia', 'topProductos'));
    }

    /**
     * Typeahead de productos para el buscador en tiempo real.
     */
    public function buscarProducto(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        if (mb_strlen($q) < 2) {
            return response()->json([]);
        }

        $productos = Product::query()
            ->where('activo', true)
            ->where(function ($query) use ($q) {
                $query->where('sku', 'like', "%{$q}%")
                      ->orWhere('barcode', 'like', "%{$q}%")
                      ->orWhere('nombre', 'like', "%{$q}%");
            })
            ->limit(10)
            ->get(['id', 'sku', 'nombre', 'marca', 'stock']);

        return response()->json($productos);
    }

    /**
     * Agrega un producto a la caja en construcción (la crea si no existe aún).
     */
    public function agregarDetalle(Request $request)
    {
        $data = $request->validate([
            'desmedro_id' => ['nullable', 'exists:desmedros,id'],
            'producto_id' => ['required', 'exists:products,id'],
            'cantidad'    => ['required', 'numeric', 'min:0.01'],
            'motivo'      => ['nullable', 'string', 'max:255'],
        ]);

        return DB::transaction(function () use ($data) {
            $desmedro = $data['desmedro_id']
                ? Desmedro::where('estado', 'borrador')->lockForUpdate()->findOrFail($data['desmedro_id'])
                : null;

            if (! $desmedro) {
                $desmedro = Desmedro::create([
                    'codigo'  => Desmedro::generarCodigo(),
                    'user_id' => Auth::id(),
                    'motivo'  => $data['motivo'] ?? null,
                    'estado'  => 'borrador',
                ]);
            }

            $producto = Product::findOrFail($data['producto_id']);

            $detalle = $desmedro->detalles()->create([
                'producto_id'  => $producto->id,
                'cantidad'     => $data['cantidad'],
                'stock_antes'  => $producto->stock,
            ]);

            return response()->json([
                'desmedro' => $desmedro->only('id', 'codigo'),
                'detalle'  => $detalle->load('producto'),
                'total'    => $desmedro->detalles()->sum('cantidad'),
            ]);
        });
    }

    /**
     * Quita un producto de la caja en construcción.
     */
    public function quitarDetalle(DesmedroDetalle $detalle)
    {
        abort_unless($detalle->desmedro->estado === 'borrador', 422, 'La caja ya fue registrada.');
        abort_unless($detalle->desmedro->user_id === Auth::id(), 403);

        $desmedroId = $detalle->desmedro_id;
        $detalle->delete();

        return response()->json([
            'ok'    => true,
            'total' => DesmedroDetalle::where('desmedro_id', $desmedroId)->sum('cantidad'),
        ]);
    }

    /**
     * Cierra la caja: descuenta stock de cada producto dentro de una transacción.
     */
    public function registrar(Desmedro $desmedro)
    {
        abort_unless($desmedro->estado === 'borrador', 422, 'Esta caja ya fue registrada.');
        abort_unless($desmedro->user_id === Auth::id(), 403);

        if ($desmedro->detalles()->count() === 0) {
            throw ValidationException::withMessages([
                'detalle' => 'Agrega al menos un producto antes de registrar el desmedro.',
            ]);
        }

        DB::transaction(function () use ($desmedro) {
            $detalles = $desmedro->detalles()->lockForUpdate()->get();

            foreach ($detalles as $detalle) {
                $producto = Product::lockForUpdate()->findOrFail($detalle->producto_id);

                if ($producto->stock < $detalle->cantidad) {
                    throw ValidationException::withMessages([
                        'stock' => "Stock insuficiente para {$producto->nombre} (disponible: {$producto->stock}, requerido: {$detalle->cantidad}).",
                    ]);
                }

                $producto->decrement('stock', $detalle->cantidad);
                $detalle->update(['stock_antes' => $producto->stock + $detalle->cantidad]);
            }

            $desmedro->update([
                'estado'        => 'registrado',
                'registrado_at' => now(),
            ]);
        });

        return redirect()
            ->route('desmedros.show', $desmedro)
            ->with('success', "Desmedro {$desmedro->codigo} registrado. Stock descontado correctamente.");
    }

    /**
     * Elimina una caja en borrador completa (no aplica a cajas ya registradas).
     */
    public function destroy(Desmedro $desmedro)
    {
        abort_unless($desmedro->estado === 'borrador', 422, 'No se puede eliminar una caja ya registrada.');
        abort_unless($desmedro->user_id === Auth::id(), 403);

        $desmedro->delete();

        return response()->json(['ok' => true]);
    }

    /**
     * Vista detalle de un desmedro (borrador o registrado).
     */
    public function show(Desmedro $desmedro)
    {
        $desmedro->load('detalles.producto', 'usuario');

        return view('desmedros.show', compact('desmedro'));
    }
}
