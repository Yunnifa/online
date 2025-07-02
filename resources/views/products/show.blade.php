<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-16">
                <!-- Kolom Kiri: Gambar Produk -->
                <div>
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800">
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center">
                    </div>
                </div>

                <!-- Kolom Kanan: Detail Produk -->
                <div class="text-gray-900 dark:text-gray-100">
                    <!-- Menampilkan Kategori -->
                    <p class="text-lg text-gray-600 dark:text-gray-400">{{ $product->category ?? 'Uncategorized' }}</p>
                    <h1 class="text-4xl font-bold tracking-tight mt-1">{{ $product->name }}</h1>
                    
                    <div class="mt-4">
                        <p class="text-3xl tracking-tight">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>

                    <!-- Menampilkan Ukuran (Sizes) -->
                    @if(!empty($product->sizes))
                        <div class="mt-8">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-200">Select Size</h3>
                            </div>
                            <div class="grid grid-cols-4 gap-4 mt-4">
                                @foreach(explode(',', $product->sizes) as $size)
                                    <button class="group relative flex items-center justify-center rounded-md border py-3 px-4 text-sm font-medium uppercase hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none sm:flex-1">
                                        {{ trim($size) }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Tombol Aksi -->
                    <div class="mt-8 grid grid-cols-1 gap-4">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center rounded-md border border-transparent bg-gray-900 dark:bg-gray-200 px-8 py-3 text-base font-medium text-white dark:text-gray-900 hover:bg-gray-700 dark:hover:bg-white">
                                Add to Cart
                            </button>
                        </form>
                         <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center rounded-md border bg-white dark:bg-gray-800 px-8 py-3 text-base font-medium text-gray-900 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.5l1.318-1.182a4.5 4.5 0 116.364 6.364L12 21.727l-7.682-7.682a4.5 4.5 0 010-6.364z"></path></svg>
                                Add to Wishlist
                            </button>
                        </form>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-10">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-gray-200">Description</h3>
                        <div class="mt-4 prose prose-sm text-gray-500 dark:text-gray-400">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
