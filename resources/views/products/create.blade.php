<x-app-layout>

    <div class="p-6 max-w-xl">

        <h1 class="text-2xl font-bold mb-6">
            Nuevo Producto
        </h1>

        <form action="{{ route('products.store') }}" method="POST">

            @csrf

            <div class="mb-4">
                <label>Código</label>
                <input type="text"
                       name="codigo"
                       class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label>Nombre</label>
                <input type="text"
                       name="nombre"
                       class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label>Unidad</label>
                <input type="text"
                       name="unidad"
                       value="UND"
                       class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label>Stock</label>
                <input type="number"
                       name="stock"
                       value="0"
                       class="w-full border rounded p-2">
            </div>

            <button type="submit"
        style="background:#16a34a;color:white;padding:10px 20px;border-radius:6px;">
    Guardar
</button>

        </form>

    </div>

</x-app-layout>