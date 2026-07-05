<?php
namespace App\Http\Controllers;

use App\Models\Sticker;
use App\Models\StickerMovement;
use Illuminate\Http\Request;

class StickerController extends Controller
{
    const MOTIVOS = ['Producción','Despacho cliente','Exportación','Merma','Ajuste inventario','Stock inicial','Otro'];

    public function index(Request $request)
    {
        $query = Sticker::where('activo', true);

        if ($request->filled('idioma'))  $query->where('idioma', $request->idioma);
        if ($request->filled('estado')) {
            match($request->estado) {
                'AGOTADO'    => $query->where('stock_actual', '<=', 0),
                'STOCK_BAJO' => $query->where('stock_actual', '>', 0)->whereColumn('stock_actual','<=','stock_minimo'),
                'DISPONIBLE' => $query->whereColumn('stock_actual','>','stock_minimo'),
                default      => null
            };
        }
        if ($request->filled('search')) $query->where('nombre','like','%'.$request->search.'%');

        $stickers    = $query->orderBy('idioma')->orderBy('nombre')->get();
        $movimientos = StickerMovement::with('sticker')->orderByDesc('created_at')->take(50)->get();

        $all         = Sticker::where('activo',true)->get();
        $total       = $all->count();
        $disponibles = $all->filter(fn($s) => $s->estado === 'DISPONIBLE')->count();
        $stockBajo   = $all->filter(fn($s) => $s->estado === 'STOCK_BAJO')->count();
        $agotados    = $all->filter(fn($s) => $s->estado === 'AGOTADO')->count();
        $totalStock  = $all->sum('stock_actual');

        return view('stickers.index', compact(
            'stickers','movimientos','total','disponibles','stockBajo','agotados','totalStock'
        ));
    }

    public function create()
    {
        return view('stickers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'idioma'        => 'required|in:EN,PT',
            'stock_minimo'  => 'required|numeric|min:0',
            'stock_inicial' => 'nullable|numeric|min:0',
        ]);

        $sticker = Sticker::create([
            'nombre'       => $request->nombre,
            'idioma'       => $request->idioma,
            'stock_actual' => 0,
            'stock_minimo' => $request->stock_minimo,
        ]);

        $inicial = floatval($request->stock_inicial ?? 0);
        if ($inicial > 0) {
            StickerMovement::create([
                'sticker_id' => $sticker->id,
                'tipo'       => 'ENTRADA',
                'cantidad'   => $inicial,
                'motivo'     => 'Stock inicial',
                'saldo_post' => $inicial,
            ]);
            $sticker->stock_actual = $inicial;
            $sticker->save();
        }

        return redirect()->route('stickers.index')
                         ->with('success','Sticker registrado correctamente.');
    }

    public function show(Sticker $sticker)
    {
        $movements = $sticker->movements()->paginate(20);
        return view('stickers.show', compact('sticker','movements'));
    }

    public function edit(Sticker $sticker)
    {
        return view('stickers.edit', compact('sticker'));
    }

    public function update(Request $request, Sticker $sticker)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'idioma'       => 'required|in:EN,PT',
            'stock_minimo' => 'required|numeric|min:0',
        ]);

        $sticker->update([
            'nombre'       => $request->nombre,
            'idioma'       => $request->idioma,
            'stock_minimo' => $request->stock_minimo,
        ]);

        return redirect()->route('stickers.index')
                         ->with('success','Sticker actualizado.');
    }

    public function movimiento(Request $request, Sticker $sticker)
    {
        $request->validate([
            'tipo'      => 'required|in:ENTRADA,SALIDA',
            'cantidad'  => 'required|numeric|min:0.01',
            'motivo'    => 'required|string|max:255',
            'referencia'=> 'nullable|string|max:100',
        ]);

        $cantidad = floatval($request->cantidad);

        if ($request->tipo === 'SALIDA' && $cantidad > $sticker->stock_actual) {
            return back()->withErrors(['cantidad' => 'Stock insuficiente. Disponible: '.$sticker->stock_actual]);
        }

        $nuevoSaldo = $request->tipo === 'ENTRADA'
            ? $sticker->stock_actual + $cantidad
            : $sticker->stock_actual - $cantidad;

        StickerMovement::create([
            'sticker_id' => $sticker->id,
            'tipo'       => $request->tipo,
            'cantidad'   => $cantidad,
            'motivo'     => $request->motivo,
            'referencia' => $request->referencia,
            'saldo_post' => $nuevoSaldo,
        ]);

        $sticker->stock_actual = $nuevoSaldo;
        $sticker->save();

        return back()->with('success',
            ($request->tipo === 'ENTRADA' ? '+' : '−').$cantidad.' unidades registradas.'
        );
    }

    public function destroy(Sticker $sticker)
    {
        $sticker->update(['activo' => false]);
        return redirect()->route('stickers.index')->with('success','Sticker desactivado.');
    }
}