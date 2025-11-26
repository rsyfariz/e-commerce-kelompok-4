<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
        Daftar Produk
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($products as $product)
        <a href="{{ route('product.show', $product->id) }}">
            <div class="border rounded-lg p-4 shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold">{{ $product->name }}</h3>
                <p class="text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
        </a>
        @endforeach
    </div>
</x-app-layout>