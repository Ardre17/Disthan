<?php
namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\CajaMovement;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    const MOTIVOS = [
        'Producción','Despacho cliente','Exportación',
        'Merma','Ajuste inventario','Stock inicial','Otro'
    ];

    public function index(Request $request)
    {
        $query = Caja::where('activo', true);

        if ($request->filled('tipo'))
            $query->where('tipo', $request->tipo);

        if ($request->filled('estado')) {
            match($request->estado) {
                'AGOTADO'    => $query->where('stock_actual', '<=', 0),
                'STOCK_BAJO' => $query->where('stock_actual', '>', 0)
                                      ->whereColumn('stock_actual','<=','stock_minimo'),
                'DISPONIBLE' => $query->whereColumn('stock_actual','>','stock_minimo'),
                default      => null
            };
        }

        if ($request->filled('search'))
            $query->where('nombre','like','%'.$request->search.'%');

        $cajas       = $query->orderBy('tipo')->orderBy('nombre')->get();
        $movimientos = CajaMovement::with('caja')
                        ->orderByDesc('created_at')->take(50)->get();

        $all         = Caja::where('activo',true)->get();
        $total       = $all->count();
        $disponibles = $all->filter(fn($c) => $c->estado === 'DISPONIBLE')->count();
        $stockBajo   = $all->filter(fn($c) => $c->estado === 'STOCK_BAJO')->count();
        $agotadas    = $all->filter(fn($c) => $c->estado === 'AGOTADO')->count();
        $totalStock  = $all->sum('stock_actual');
        $conLogo     = $all->where('tipo','CON_LOGO')->count();
        $sinLogo     = $all->where('tipo','SIN_LOGO')->count();

        return view('cajas.index', compact(
            'cajas','movimientos',
            'total','disponibles','stockBajo','agotadas',
            'totalStock','conLogo','sinLogo'
        ));
    }

    public function create()
    {
        return view('cajas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'tipo'          => 'required|in:CON_LOGO,SIN_LOGO',
            'stock_minimo'  => 'required|numeric|min:0',
            'stock_inicial' => 'nullable|numeric|min:0',
        ]);

        $caja = Caja::create([
            'nombre'       => $request->nombre,
            'tipo'         => $request->tipo,
            'stock_actual' => 0,
            'stock_minimo' => $request->stock_minimo,
        ]);

        $inicial = floatval($request->stock_inicial ?? 0);
        if ($inicial > 0) {
            CajaMovement::create([
                'caja_id'   => $caja->id,
                'tipo'      => 'ENTRADA',
                'cantidad'  => $inicial,
                'motivo'    => 'Stock inicial',
                'saldo_post'=> $inicial,
            ]);
            $caja->stock_actual = $inicial;
            $caja->save();
        }

        return redirect()->route('cajas.index')
                         ->with('success','Caja registrada correctamente.');
    }

    public function show(Caja $caja)
    {
        $movements = $caja->movements()->paginate(20);
        return view('cajas.show', compact('caja','movements'));
    }

    public function edit(Caja $caja)
    {
        return view('cajas.edit', compact('caja'));
    }

    public function update(Request $request, Caja $caja)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'tipo'         => 'required|in:CON_LOGO,SIN_LOGO',
            'stock_minimo' => 'required|numeric|min:0',
        ]);

        $caja->update([
            'nombre'       => $request->nombre,
            'tipo'         => $request->tipo,
            'stock_minimo' => $request->stock_minimo,
        ]);

        return redirect()->route('cajas.index')
                         ->with('success','Caja actualizada correctamente.');
    }

    public function movimiento(Request $request, Caja $caja)
    {
        $request->validate([
            'tipo'      => 'required|in:ENTRADA,SALIDA',
            'cantidad'  => 'required|numeric|min:0.01',
            'motivo'    => 'required|string|max:255',
            'referencia'=> 'nullable|string|max:100',
        ]);

        $cantidad = floatval($request->cantidad);

        if ($request->tipo === 'SALIDA' && $cantidad > $caja->stock_actual) {
            return back()->withErrors([
                'cantidad' => 'Stock insuficiente. Disponible: '.$caja->stock_actual
            ]);
        }

        $nuevoSaldo = $request->tipo === 'ENTRADA'
            ? $caja->stock_actual + $cantidad
            : $caja->stock_actual - $cantidad;

        CajaMovement::create([
            'caja_id'   => $caja->id,
            'tipo'      => $request->tipo,
            'cantidad'  => $cantidad,
            'motivo'    => $request->motivo,
            'referencia'=> $request->referencia,
            'saldo_post'=> $nuevoSaldo,
        ]);

        $caja->stock_actual = $nuevoSaldo;
        $caja->save();

        return back()->with('success',
            ($request->tipo === 'ENTRADA' ? '+' : '−').
            $cantidad.' cajas registradas correctamente.'
        );
    }

    public function destroy(Caja $caja)
    {
        $caja->update(['activo' => false]);
        return redirect()->route('cajas.index')
                         ->with('success','Caja desactivada.');
    }
}