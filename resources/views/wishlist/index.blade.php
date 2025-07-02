
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Wishlist') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Your Favourite Items</h3>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($wishlistItems as $item)
                    <div class="group relative">
                        <a href="{{ route('products.show', $item->product_id) }}">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-100 dark:bg-gray-800 group-hover:opacity-75">
                                <img src="{{ asset('images/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover object-center">
                            </div>
                            <div class="mt-4">
                                <h4 class="text-sm text-gray-700 dark:text-gray-300">{{ $item->product->name }}</h4>
                                <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">Rp{{ number_format($item->product->price) }}</p>
                            </div>
                        </a>

                        <form action="{{ route('wishlist.toggle', $item->product_id) }}" method="POST" class="absolute top-3 right-3 z-10">
                            @csrf
                            <button type="submit" class="p-2 rounded-full bg-white/60 text-red-500 backdrop-blur-sm transition hover:bg-white/80">
                                <span class="sr-only">Remove from Wishlist</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">Your wishlist is empty.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>