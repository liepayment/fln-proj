@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Products</h2>
                        <a href="{{ route('admin.products.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg">Add Product</a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="text-left py-2">Name</th>
                                <th class="text-left py-2">Category</th>
                                <th class="text-left py-2">Price</th>
                                <th class="text-left py-2">Stock</th>
                                <th class="text-left py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="border-b">
                                    <td class="py-4">{{ $product->name }}</td>
                                    <td class="py-4">{{ $product->category->name }}</td>
                                    <td class="py-4">${{ $product->price }}</td>
                                    <td class="py-4">{{ $product->stock }}</td>
                                    <td class="py-4">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 mr-4">Edit</a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
