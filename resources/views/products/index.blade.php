<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Catalog') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">All Products</h3>
                
                <!-- Pengecekan Admin yang Diperbaiki dan Lebih Aman -->
                @auth
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('products.create') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            Add New Product
                        </a>
                    @endif
                @endauth
            </div>
            
            @if ($message = Session::get('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ $message }}</p>
                </div>
            @endif

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                @forelse ($products as $product)
                    <div class="group relative">
                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800">
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center group-hover:opacity-75 transition-opacity">
                            <a href="{{ route('products.show', $product->id) }}" class="absolute inset-0" aria-hidden="true"></a>
                            
                            <!-- Tombol Wishlist -->
                            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                                @csrf
                                <button type="submit" class="p-2 rounded-full bg-white/60 text-gray-700 backdrop-blur-sm transition hover:text-red-500 hover:bg-white/80">
                                    <span class="sr-only">Toggle Wishlist</span>
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.5l1.318-1.182a4.5 4.5 0 116.364 6.364L12 21.727l-7.682-7.682a4.5 4.5 0 010-6.364z"></path></svg>
                                </button>
                            </form>
                        </div>
                        
                        <div class="mt-4">
                            <div class="flex justify-between">
                                <div>
                                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                        <a href="{{ route('products.show', $product->id) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h4>
                                    <p class="mt-1 text-sm text-gray-500">{{ $product->category ?? 'Uncategorized' }}</p>
                                </div>
                                <p class="text-base font-medium text-gray-900 dark:text-white">Rp{{ number_format($product->price) }}</p>
                            </div>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 truncate">{{ $product->description }}</p>

                            <!-- Tombol Add to Cart -->
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="w-full text-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:hover:bg-gray-600">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 dark:text-gray-400 py-10">
                        <p class="text-2xl">No products found.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
