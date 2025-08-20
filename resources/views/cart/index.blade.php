<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if ($cartItems->isEmpty())
                        <p>Your cart is empty.</p>
                    @else
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="text-left py-2">Product</th>
                                    <th class="text-left py-2">Price</th>
                                    <th class="text-left py-2">Quantity</th>
                                    <th class="text-left py-2">Total</th>
                                    <th class="text-left py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach ($cartItems as $item)
                                    @php $total += $item->product->price * $item->quantity; @endphp
                                    <tr class="border-b">
                                        <td class="py-4">{{ $item->product->name }}</td>
                                        <td class="py-4">${{ $item->product->price }}</td>
                                        <td class="py-4">
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-20 text-center border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                                <button type="submit" class="ml-4 bg-blue-500 text-white py-1 px-3 rounded-lg">Update</button>
                                            </form>
                                        </td>
                                        <td class="py-4">${{ $item->product->price * $item->quantity }}</td>
                                        <td class="py-4">
                                            <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-6 text-right">
                            <h3 class="text-xl font-semibold">Total: ${{ $total }}</h3>
                        </div>

                        <div class="mt-6 text-right">
                            <a href="{{ route('checkout.index') }}" class="bg-green-500 text-white py-2 px-6 rounded-lg">Proceed to Checkout</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
