<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-auto object-cover">
                        </div>
                        <div>
                            <h3 class="text-2xl font-semibold">{{ $product->name }}</h3>
                            <p class="text-gray-600 mt-2">${{ $product->price }}</p>
                            <p class="mt-4">{{ $product->description }}</p>

                            <form action="{{ route('cart.store') }}" method="POST" class="mt-6">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="flex items-center">
                                    <label for="quantity" class="mr-4">Quantity:</label>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" class="w-20 text-center border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                </div>
                                <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
