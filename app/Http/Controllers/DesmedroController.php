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
    public function index()
    {
        $desmedros = Desmedro::withCount('detalles')
            ->with('usuario')
            ->where('estado', 'registrado')
            ->latest('registrado_at')
            ->paginate(15);

        $borrador = Desmedro::with('detalles.producto')
            ->where('estado', 'borrador')
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        return view('desmedros.index', compact('desmedros', 'borrador'));
    }

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

    public function destroy(Desmedro $desmedro)
    {
        abort_unless($desmedro->estado === 'borrador', 422, 'No se puede eliminar una caja ya registrada.');
        abort_unless($desmedro->user_id === Auth::id(), 403);

        $desmedro->delete();

        return response()->json(['ok' => true]);
    }

    public function show(Desmedro $desmedro)
    {
        $desmedro->load('detalles.producto', 'usuario');

        return view('desmedros.show', compact('desmedro'));
    }
}