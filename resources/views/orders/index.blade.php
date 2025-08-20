<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Orders') }}
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

                    @if ($orders->isEmpty())
                        <p>You have no orders.</p>
                    @else
                        @foreach ($orders as $order)
                            <div class="mb-6 border rounded-lg p-4">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-semibold">Order #{{ $order->id }}</h3>
                                    <span class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                                <p class="mb-2"><strong>Status:</strong> <span class="capitalize">{{ $order->status }}</span></p>
                                <p class="mb-4"><strong>Total:</strong> ${{ $order->order_total }}</p>
                                <table class="w-full">
                                    <thead>
                                        <tr>
                                            <th class="text-left py-2">Product</th>
                                            <th class="text-left py-2">Price</th>
                                            <th class="text-left py-2">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderItems as $item)
                                            <tr class="border-b">
                                                <td class="py-2">{{ $item->product->name }}</td>
                                                <td class="py-2">${{ $item->price_at_purchase }}</td>
                                                <td class="py-2">{{ $item->quantity }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
