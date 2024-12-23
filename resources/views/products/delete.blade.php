@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Xác nhận xóa</h1>
        <p>Bạn có chắc chắn muốn xóa sản phẩm <strong>{{ $product->name }}</strong> không?</p>
        <p>Thao tác này không thể hoàn tác.</p>

        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Xóa</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection
