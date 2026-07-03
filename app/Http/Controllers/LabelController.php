<?php
namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\LabelMovement;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    // Constantes compartidas
    const PAISES = ['PERU','PANAMA','COSTA_RICA','BRASIL','USA'];
    const ZONAS  = ['ZONA_SUL','SANTA_LUZIA'];
    const IDIOMAS= ['ES','PT','EN'];
    const MOTIVOS= ['Producción','Despacho cliente','Exportación','Merma','Ajuste inventario','Otro'];

    public function index(Request $request)
    {
        $query = Label::where('activo', true);

        if ($request->filled('idioma'))
            $query->where('idioma', $request->idioma);

        if ($request->filled('pais'))
            $query->where('pais', $request->pais);

        if ($request->filled('zona'))
            $query->where('zona', $request->zona);

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

        $labels = $query->orderBy('idioma')->orderBy('nombre')->get();

        // Movimientos recientes para historial global
        $movimientos = LabelMovement::with('label')
            ->orderByDesc('created_at')
            ->take(50)
            ->get();

        // KPIs
        $all        = Label::where('activo',true)->get();
        $total      = $all->count();
        $disponibles= $all->filter(fn($l) => $l->estado === 'DISPONIBLE')->count();
        $stockBajo  = $all->filter(fn($l) => $l->estado === 'STOCK_BAJO')->count();
        $agotadas   = $all->filter(fn($l) => $l->estado === 'AGOTADO')->count();
        $totalStock = $all->sum('stock_actual');

        return view('labels.index', compact(
            'labels','movimientos',
            'total','disponibles','stockBajo','agotadas','totalStock'
        ));
    }

    public function create()
    {
        return view('labels.create', [
            'paises' => self::PAISES,
            'zonas'  => self::ZONAS,
            'idiomas'=> self::IDIOMAS,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'idioma'       => 'required|in:ES,PT,EN',
            'stock_minimo' => 'required|numeric|min:0',
            'formato'      => 'nullable|string|max:100',
            'pais'         => 'nullable|string',
            'zona'         => 'nullable|string',
            'stock_inicial'=> 'nullable|numeric|min:0',
        ]);

        $label = Label::create([
            'nombre'       => $request->nombre,
            'idioma'       => $request->idioma,
            'pais'         => $request->idioma === 'ES' ? $request->pais : null,
            'zona'         => $request->idioma === 'PT' ? $request->zona : null,
            'formato'      => $request->formato,
            'stock_actual' => 0,
            'stock_minimo' => $request->stock_minimo,
            'activo'       => true,
        ]);

        // Registra stock inicial como ENTRADA
        $inicial = floatval($request->stock_inicial ?? 0);
        if ($inicial > 0) {
            LabelMovement::create([
                'label_id'  => $label->id,
                'tipo'      => 'ENTRADA',
                'cantidad'  => $inicial,
                'motivo'    => 'Stock inicial',
                'referencia'=> null,
                'saldo_post'=> $inicial,
            ]);
            $label->stock_actual = $inicial;
            $label->save();
        }

        return redirect()->route('labels.index')
                         ->with('success','Etiqueta registrada correctamente.');
    }

    public function edit(Label $label)
    {
        return view('labels.edit', [
            'label'  => $label,
            'paises' => self::PAISES,
            'zonas'  => self::ZONAS,
            'idiomas'=> self::IDIOMAS,
        ]);
    }

    public function update(Request $request, Label $label)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'idioma'       => 'required|in:ES,PT,EN',
            'stock_minimo' => 'required|numeric|min:0',
            'formato'      => 'nullable|string|max:100',
            'pais'         => 'nullable|string',
            'zona'         => 'nullable|string',
        ]);

        $label->update([
            'nombre'      => $request->nombre,
            'idioma'      => $request->idioma,
            'pais'        => $request->idioma === 'ES' ? $request->pais : null,
            'zona'        => $request->idioma === 'PT' ? $request->zona : null,
            'formato'     => $request->formato,
            'stock_minimo'=> $request->stock_minimo,
        ]);

        return redirect()->route('labels.index')
                         ->with('success','Etiqueta actualizada correctamente.');
    }

    // POST /labels/{label}/movimiento
    public function movimiento(Request $request, Label $label)
    {
        $request->validate([
            'tipo'      => 'required|in:ENTRADA,SALIDA',
            'cantidad'  => 'required|numeric|min:0.01',
            'motivo'    => 'required|string|max:255',
            'referencia'=> 'nullable|string|max:100',
        ]);

        $cantidad = floatval($request->cantidad);

        if ($request->tipo === 'SALIDA' && $cantidad > $label->stock_actual) {
            return back()->withErrors(['cantidad' => 'Stock insuficiente. Disponible: '.$label->stock_actual]);
        }

        $nuevoSaldo = $request->tipo === 'ENTRADA'
            ? $label->stock_actual + $cantidad
            : $label->stock_actual - $cantidad;

        LabelMovement::create([
            'label_id'  => $label->id,
            'tipo'      => $request->tipo,
            'cantidad'  => $cantidad,
            'motivo'    => $request->motivo,
            'referencia'=> $request->referencia,
            'saldo_post'=> $nuevoSaldo,
        ]);

        $label->stock_actual = $nuevoSaldo;
        $label->save();

        return back()->with('success',
            ($request->tipo === 'ENTRADA' ? '+' : '−') .
            $cantidad . ' unidades registradas correctamente.'
        );
    }

    public function show(Label $label)
    {
        $movements = $label->movements()->paginate(20);
        return view('labels.show', compact('label','movements'));
    }

    public function destroy(Label $label)
    {
        $label->update(['activo' => false]);
        return redirect()->route('labels.index')
                         ->with('success','Etiqueta desactivada.');
    }
}