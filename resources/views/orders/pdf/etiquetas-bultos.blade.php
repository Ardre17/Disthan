@foreach($bultos as $bulto)

    @include('orders.pdf.etiqueta-bulto', [
        'bulto' => $bulto
    ])

    @if(!$loop->last)
        <div style="page-break-after: always;"></div>
    @endif

@endforeach