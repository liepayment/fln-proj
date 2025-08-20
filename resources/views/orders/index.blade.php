<h1>Your Orders</h1>

@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

@if ($orders->isEmpty())
    <p>You have no orders.</p>
@else
    @foreach ($orders as $order)
        <div>
            <h2>Order #{{ $order->id }}</h2>
            <p><strong>Status:</strong> {{ $order->status }}</p>
            <p><strong>Total:</strong> ${{ $order->order_total }}</p>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>${{ $item->price_at_purchase }}</td>
                            <td>{{ $item->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
@endif
