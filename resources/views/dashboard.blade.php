<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            DISTAN ERP
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg mb-4">
                Si ves este cuadro azul, Tailwind está funcionando.
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-white p-5 rounded-lg shadow">
                    <h3 class="font-bold text-lg">📦 Productos</h3>
                    <p>0 registrados</p>
                </div>

                <div class="bg-white p-5 rounded-lg shadow">
                    <h3 class="font-bold text-lg">🛒 Pedidos</h3>
                    <p>0 pendientes</p>
                </div>

                <div class="bg-white p-5 rounded-lg shadow">
                    <h3 class="font-bold text-lg">🏭 Producción</h3>
                    <p>0 órdenes</p>
                </div>

                <div class="bg-white p-5 rounded-lg shadow">
                    <h3 class="font-bold text-lg">🚚 Transporte</h3>
                    <p>0 despachos</p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>