<?php
namespace App\Http\Controllers;

use App\Models\Precinto;
use App\Models\PrecintoMovement;
use Illuminate\Http\Request;

class PrecintoController extends Controller
{
    const MOTIVOS = ['Producción','Despacho cliente','Exportación','Merma','Ajuste inventario','Stock inicial','Otro'];
    const COLORES = ['VERDE','BLANCO','NEGRO'];

    public function index(Request $request)
    {
        $query = Precinto::where('activo', true);

        if ($request->filled('color'))  $query->where('color', $request->color);
        if ($request->filled('estado')) {
            match($request->estado) {
                'AGOTADO'    => $query->where('stock_actual', '<=', 0),
                'STOCK_BAJO' => $query->where('stock_actual', '>', 0)->whereColumn('stock_actual','<=','stock_minimo'),
                'DISPONIBLE' => $query->whereColumn('stock_actual','>','stock_minimo'),
                default      => null
            };
        }
        if ($request->filled('search')) $query->where('nombre','like','%'.$request->search.'%');

        $precintos   = $query->orderBy('color')->orderBy('nombre')->get();
        $movimientos = PrecintoMovement::with('precinto')->orderByDesc('created_at')->take(50)->get();

        $all         = Precinto::where('activo',true)->get();
        $total       = $all->count();
        $disponibles = $all->filter(fn($p) => $p->estado === 'DISPONIBLE')->count();
        $stockBajo   = $all->filter(fn($p) => $p->estado === 'STOCK_BAJO')->count();
        $agotados    = $all->filter(fn($p) => $p->estado === 'AGOTADO')->count();
        $totalStock  = $all->sum('stock_actual');

        return view('precintos.index', compact(
            'precintos','movimientos','total','disponibles','stockBajo','agotados','totalStock'
        ));
    }

    public function create()
    {
        $colores = self::COLORES;
        return view('precintos.create', compact('colores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'color'         => 'required|in:VERDE,BLANCO,NEGRO',
            'stock_minimo'  => 'required|numeric|min:0',
            'stock_inicial' => 'nullable|numeric|min:0',
        ]);

        $precinto = Precinto::create([
            'nombre'       => $request->nombre,
            'color'        => $request->color,
            'stock_actual' => 0,
            'stock_minimo' => $request->stock_minimo,
        ]);

        $inicial = floatval($request->stock_inicial ?? 0);
        if ($inicial > 0) {
            PrecintoMovement::create([
                'precinto_id' => $precinto->id,
                'tipo'        => 'ENTRADA',
                'cantidad'    => $inicial,
                'motivo'      => 'Stock inicial',
                'saldo_post'  => $inicial,
            ]);
            $precinto->stock_actual = $inicial;
            $precinto->save();
        }

        return redirect()->route('precintos.index')
                         ->with('success','Precinto registrado correctamente.');
    }

    public function show(Precinto $precinto)
    {
        $movements = $precinto->movements()->paginate(20);
        return view('precintos.show', compact('precinto','movements'));
    }

    public function edit(Precinto $precinto)
    {
        $colores = self::COLORES;
        return view('precintos.edit', compact('precinto','colores'));
    }

    public function update(Request $request, Precinto $precinto)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'color'        => 'required|in:VERDE,BLANCO,NEGRO',
            'stock_minimo' => 'required|numeric|min:0',
        ]);

        $precinto->update([
            'nombre'       => $request->nombre,
            'color'        => $request->color,
            'stock_minimo' => $request->stock_minimo,
        ]);

        return redirect()->route('precintos.index')
                         ->with('success','Precinto actualizado.');
    }

    public function movimiento(Request $request, Precinto $precinto)
    {
        $request->validate([
            'tipo'      => 'required|in:ENTRADA,SALIDA',
            'cantidad'  => 'required|numeric|min:0.01',
            'motivo'    => 'required|string|max:255',
            'referencia'=> 'nullable|string|max:100',
        ]);

        $cantidad = floatval($request->cantidad);

        if ($request->tipo === 'SALIDA' && $cantidad > $precinto->stock_actual) {
            return back()->withErrors(['cantidad' => 'Stock insuficiente. Disponible: '.$precinto->stock_actual]);
        }

        $nuevoSaldo = $request->tipo === 'ENTRADA'
            ? $precinto->stock_actual + $cantidad
            : $precinto->stock_actual - $cantidad;

        PrecintoMovement::create([
            'precinto_id' => $precinto->id,
            'tipo'        => $request->tipo,
            'cantidad'    => $cantidad,
            'motivo'      => $request->motivo,
            'referencia'  => $request->referencia,
            'saldo_post'  => $nuevoSaldo,
        ]);

        $precinto->stock_actual = $nuevoSaldo;
        $precinto->save();

        return back()->with('success',
            ($request->tipo === 'ENTRADA' ? '+' : '−').$cantidad.' unidades registradas.'
        );
    }

    public function destroy(Precinto $precinto)
    {
        $precinto->update(['activo' => false]);
        return redirect()->route('precintos.index')->with('success','Precinto desactivado.');
    }
}