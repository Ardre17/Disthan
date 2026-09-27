@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-6">

    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <div class="mb-6">

            <h1 class="text-2xl font-bold text-gray-800">
                Importar pedido PDF
            </h1>

            <p class="text-gray-500 mt-1">
                Carga el PDF del pedido para analizarlo
                automáticamente.
            </p>

        </div>


        @if(session('error'))

            <div class="mb-5 p-4 rounded-xl
                        bg-red-50
                        border border-red-200
                        text-red-700">

                {{ session('error') }}

            </div>

        @endif


        <form
            action="{{ route('orders.importPdf.preview') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <div
                class="border-2 border-dashed
                       border-gray-300
                       rounded-2xl
                       p-10
                       text-center"
            >

                <div class="text-5xl mb-4">
                    📄
                </div>

                <h2 class="text-lg font-semibold">
                    Seleccionar pedido PDF
                </h2>

                <p class="text-sm text-gray-500 mt-2 mb-6">
                    Utiliza el PDF generado por el sistema de pedidos.
                </p>


                <input
                    type="file"
                    name="archivo"
                    accept="application/pdf"
                    required
                    class="block w-full max-w-md
                           mx-auto text-sm"
                >

            </div>


            <div class="mt-6 flex justify-end">

                <button
                    type="submit"
                    class="px-6 py-3
                           rounded-xl
                           bg-blue-600
                           text-white
                           font-semibold
                           hover:bg-blue-700"
                >
                    Analizar pedido
                </button>

            </div>

        </form>

    </div>

</div>

@endsection