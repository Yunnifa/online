<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium">Product Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full" required>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium">Category</label>
                            <input type="text" name="category" id="category" class="mt-1 block w-full" required>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full" required></textarea>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium">Price</label>
                            <input type="number" name="price" id="price" class="mt-1 block w-full" required>
                        </div>

                        <!-- Sizes -->
                        <div>
                            <label for="sizes" class="block text-sm font-medium">Sizes</label>
                            <input type="text" name="sizes" id="sizes" placeholder="e.g. 38,39,40" class="mt-1 block w-full">
                        </div>

                        <!-- Image -->
                        <div>
                            <label for="image" class="block text-sm font-medium">Image</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full" required>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                                Save Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
