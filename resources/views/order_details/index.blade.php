@extends('layouts.app')

@section('title', 'CHI TIẾT ĐƠN HÀNG #' . $order->id)

@section('content')
<div class="container">
    <p><strong>Khách hàng:</strong> {{ $order->customer->name }}</p>
    <p><strong>Ngày đặt:</strong> {{ $order->order_date }}</p>
    <p><strong>Trạng thái:</strong>
        @switch($order->status)
        @case('pending')
        <span class="badge bg-warning text-dark badge-custom">
            <i class="bi bi-hourglass-split"></i> Chờ xử lý
        </span>
        @break
        @case('processing')
        <span class="badge bg-info text-white badge-custom">
            <i class="bi bi-gear"></i> Đang xử lý
        </span>
        @break
        @case('shipped')
        <span class="badge bg-primary text-white badge-custom">
            <i class="bi bi-truck"></i> Đã giao hàng
        </span>
        @break
        @case('completed')
        <span class="badge bg-success text-white badge-custom">
            <i class="bi bi-check-circle"></i> Hoàn thành
        </span>
        @break
        @default
        <span class="badge bg-secondary text-white badge-custom">
            <i class="bi bi-question-circle"></i> Không xác định
        </span>
        @endswitch

    <p><strong>Sản phẩm:</strong></p>
    <ul>
        @foreach ($order->products as $product)
        <li>{{ $product->name }} - Số lượng: {{ $product->pivot->quantity }}</li>
        @endforeach
    </ul>

    <a href="{{ route('orders.index') }}" class="btn btn-primary">Trở về</a>
</div>
@endsection