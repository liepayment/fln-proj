<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-6">Order Summary</h2>
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="text-left py-2">Product</th>
                                <th class="text-left py-2">Price</th>
                                <th class="text-left py-2">Quantity</th>
                                <th class="text-left py-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                <tr class="border-b">
                                    <td class="py-4">{{ $item->product->name }}</td>
                                    <td class="py-4">${{ $item->product->price }}</td>
                                    <td class="py-4">{{ $item->quantity }}</td>
                                    <td class="py-4">${{ $item->product->price * $item->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6 text-right">
                        <h3 class="text-xl font-semibold">Total: ${{ $total }}</h3>
                    </div>

                    <div class="mt-6 text-right">
                        <form action="{{ route('payment.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg">Pay with Stripe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
