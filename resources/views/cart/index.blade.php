<h1>Your Cart</h1>

@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

@if ($cartItems->isEmpty())
    <p>Your cart is empty.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($cartItems as $item)
                @php $total += $item->product->price * $item->quantity; @endphp
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>${{ $item->product->price }}</td>
                    <td>
                        <form action="{{ route('cart.update', $item) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td>${{ $item->product->price * $item->quantity }}</td>
                    <td>
                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        <h3>Total: ${{ $total }}</h3>
    </div>

    <div>
        <a href="{{ route('checkout.index') }}">Proceed to Checkout</a>
    </div>
@endif
