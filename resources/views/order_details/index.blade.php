@extends('layouts.app')

@section('title', 'ORDER DETAILS #' . $order->id)

@section('content')
<div class="container">
    <p><strong>Customer Name:</strong> {{ $order->customer->name }}</p>
    <p><strong>Order Date:</strong> {{ $order->order_date }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>
    @switch($order->status)
    @case('pending')
    <span class="badge bg-warning text-dark badge-custom">
        <i class="bi bi-hourglass-split"></i> Pending
    </span>
    @break
    @case('processing')
    <span class="badge bg-info text-white badge-custom">
        <i class="bi bi-gear"></i> Processing
    </span>
    @break
    @case('shipped')
    <span class="badge bg-primary text-white badge-custom">
        <i class="bi bi-truck"></i> Shipped
    </span>
    @break
    @case('completed')
    <span class="badge bg-success text-white badge-custom">
        <i class="bi bi-check-circle"></i> Completed
    </span>
    @break
    @default
    <span class="badge bg-secondary text-white badge-custom">
        <i class="bi bi-question-circle"></i> Undefined
    </span>
    @endswitch

    <!-- Product List -->
    <h5><strong>Products</strong></h5>
    <div class="row">
        @foreach ($order->orderDetails as $orderDetail)
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @if ($orderDetail->product)
                            <h6 class="card-title">Product Name: {{ $orderDetail->product->name }}</h6>
                            <p class="card-text">Quantity: {{ $orderDetail->quantity }}</p>
                        @else
                            <h6 class="card-title">Product not found</h6>
                            <p class="card-text">Quantity: {{ $orderDetail->quantity }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil"></i> Edit Order
        </a>
    </div>
</div>
@endsection
