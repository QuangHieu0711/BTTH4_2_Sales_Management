@extends('layouts.app')
@section('title', 'List Product')
@section('content')
    <div class="container">
        <a href="{{ route('products.create') }}" class="btn btn-success">Add product</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>


        @foreach ($products as $index => $product)
        <tr>
            <!-- Chỉ số bắt đầu từ 1 -->
            <td>{{ $products->firstItem() + $index }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->quantity }}</td>
            <td>
                <!-- Liên kết đến trang chỉnh sửa sách -->
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm" title="Chỉnh sửa sản phẩm">
                    <i class="bi bi-pencil-square" style="font-size: 20px;"></i>
                </a>

                <!-- Form xóa sách -->
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa sản phẩm">
                        <i class="bi bi-trash" style="font-size: 20px;"></i>
                    </button>
                </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
@endsection
