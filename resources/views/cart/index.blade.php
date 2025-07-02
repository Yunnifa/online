<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6">Barang di Keranjang Anda</h3>

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if(session('cart') && count(session('cart')) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Produk</th>
                                        <th scope="col" class="px-6 py-3">Harga</th>
                                        <th scope="col" class="px-6 py-3" width="150px">Jumlah</th>
                                        <th scope="col" class="px-6 py-3">Subtotal</th>
                                        <th scope="col" class="px-6 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0 @endphp
                                    @foreach(session('cart') as $id => $details)
                                        @php $total += $details['price'] * $details['quantity'] @endphp
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 align-middle">
                                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex items-center">
                                                    <img src="{{ asset('images/' . $details['image']) }}" width="60" class="mr-4 rounded">
                                                    <span>{{ $details['name'] }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">Rp {{ number_format($details['price']) }}</td>
                                            <td class="px-6 py-4">
                                                <form action="{{ route('cart.update', $id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="w-20 rounded border-gray-300 text-center dark:bg-gray-700">
                                                    <button type="submit" class="ml-2 text-xs text-indigo-600 hover:text-indigo-900 font-semibold">Update</button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4">Rp {{ number_format($details['price'] * $details['quantity']) }}</td>
                                            <td class="px-6 py-4">
                                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <div class="w-full max-w-sm">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total Belanja:</span>
                                    <span>Rp {{ number_format($total) }}</span>
                                </div>
                                <button class="mt-4 w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Lanjut ke Checkout
                                </button>
                            </div>
                        </div>

                    @else
                        <p>Keranjang belanja Anda kosong.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
