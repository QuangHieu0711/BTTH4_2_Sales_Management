@extends('layouts.app')

@section('title') Order History for Customer: {{ $customer->name }} @endsection

@section('content')
<div class="container">
    @if ($orders->isEmpty())
        <p>This customer has no order history.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>{{ $idColumnLabel }}</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>${{ number_format($order->total ?? 0, 2) }}</td>
                <td>
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('orderdetails.index', $order->id) }}" class="btn btn-info btn-sm">Details</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-end">
            {{ $orders->links() }}
        </div>
    @endif

    <!-- Back Button -->
    <div class="mt-3">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Customer List</a>
    </div>
</div>
@endsection
