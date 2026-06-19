<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [

    'order_id',
    'product_id',

    'cantidad_solicitada',
    'cantidad_despachada',

    'precio_unitario',

    'subtotal',

    'estado_item',

    'paleta',
    'fecha_vencimiento',
    'nivel',
    'ubicacion'
];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getEstadoColorAttribute()
    {
    if ($this->cantidad_despachada >= $this->cantidad_solicitada) {
        return '#16A34A';
    }

    if ($this->cantidad_despachada > 0) {
        return '#F59E0B';
    }

    return '#DC2626';

    }
    public function getEstadoTextoAttribute()
    {
        if ($this->cantidad_despachada >= $this->cantidad_solicitada) {
        return 'COMPLETO';
    }

    if ($this->cantidad_despachada > 0) {
        return 'PARCIAL';
    }

    return 'INCOMPLETO';
    }
    public function updateDetail(
    Request $request,
    OrderDetail $detail
)
{
    $subtotal =
        $request->cantidad_solicitada *
        $request->precio_unitario;

    $estado = 'INCOMPLETO';

    if(
        $request->cantidad_despachada >=
        $request->cantidad_solicitada
    ){
        $estado = 'COMPLETO';
    }
    elseif(
        $request->cantidad_despachada > 0
    ){
        $estado = 'PARCIAL';
    }

    $detail->update([

        'cantidad_solicitada' =>
            $request->cantidad_solicitada,

        'cantidad_despachada' =>
            $request->cantidad_despachada,

        'precio_unitario' =>
            $request->precio_unitario,


        'subtotal' => $subtotal,

        'estado_item' => $estado

    ]);

    $order = $detail->order;

    $order->subtotal =
        $order->details->sum('subtotal');

    $order->igv =
        round(
            $order->subtotal * 0.18,
            2
        );

    $order->total =
        $order->subtotal +
        $order->igv;

    $items = $order->details;

    if(
        $items->every(
            fn($i) => $i->estado_item == 'COMPLETO'
        )
    ){
        $order->estado = 'COMPLETO';
    }
    elseif(
        $items->contains(
            fn($i) => $i->estado_item == 'PARCIAL'
        )
    ){
        $order->estado = 'PARCIAL';
    }
    else{
        $order->estado = 'INCOMPLETO';
    }

    $order->save();

    return back();
    }
    
}