<h1>Checkout</h1>

<h2>Order Summary</h2>
<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cartItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>${{ $item->product->price }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ $item->product->price * $item->quantity }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div>
    <h3>Total: ${{ $total }}</h3>
</div>

<form action="{{ route('checkout.store') }}" method="POST">
    @csrf
    <button type="submit">Place Order</button>
</form>
