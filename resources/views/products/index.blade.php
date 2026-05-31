<x-app-layout>

    <div class="p-6">

        <div class="flex justify-between mb-6">
            <h1 class="text-2xl font-bold">
                Productos
            </h1>

            <a href="{{ route('products.create') }}"
               class="bg-blue-500 text-white px-4 py-2 rounded">
                Nuevo Producto
            </a>
        </div>

        <table class="w-full bg-white shadow rounded">

            <thead>
                <tr>
                    <th class="p-3 text-left">Código</th>
                    <th class="p-3 text-left">Nombre</th>
                    <th class="p-3 text-left">Unidad</th>
                    <th class="p-3 text-left">Stock</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $product)
                    <tr class="border-t">
                        <td class="p-3">{{ $product->codigo }}</td>
                        <td class="p-3">{{ $product->nombre }}</td>
                        <td class="p-3">{{ $product->unidad }}</td>
                        <td class="p-3">{{ $product->stock }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</x-app-layout>