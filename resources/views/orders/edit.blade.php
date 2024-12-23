@extends('layouts.app')

@section('title', 'Edit Order')

@section('content')
<div class="container">
    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group mb-4">
            <label for="customer_id"><strong>Customer</strong></label>
            <select class="form-control" id="customer_id" name="customer_id" required>
                @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" {{ $customer->id == $order->customer_id ? 'selected' : '' }}>
                    {{ $customer->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-4">
            <label for="order_date"><strong>Order Date</strong></label>
            <input type="date" class="form-control" id="order_date" name="order_date" value="{{ $order->order_date }}" required>
        </div>

        <div class="form-group mb-4">
            <label for="status"><strong>Status</strong></label>
            <select class="form-control" id="status" name="status" required>
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <h4 class="mb-3">Order Details</h4>
        <table class="table" id="orderDetails">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $index => $orderDetail)
                <tr>
                    <td>
                        <select name="products[{{ $index }}][product_id]" class="form-control" required>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ $product->id == $orderDetail->product_id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control" name="products[{{ $index }}][quantity]" value="{{ $orderDetail->quantity }}" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-product"><i class="fas fa-trash-alt"></i> Remove</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Add Product Button -->
        <button type="button" class="btn btn-secondary mb-3" id="addProduct"><i class="fas fa-plus-circle"></i> Add Product</button>

        <!-- Form buttons (Update and Back) -->
        <div class="d-flex justify-content-between mt-3">
            <!-- Back Button -->
            <a href="{{ route('orders.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Order List</a>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Order</button>
        </div>
    </form>
</div>

<script>
    document.querySelector('#addProduct').addEventListener('click', function () {
        const rowCount = document.querySelectorAll('#orderDetails tbody tr').length;
        const newRow = `
        <tr>
            <td>
                <select name="products[${rowCount}][product_id]" class="form-control" required>
                    @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" class="form-control" name="products[${rowCount}][quantity]" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger remove-product"><i class="fas fa-trash-alt"></i> Remove</button>
            </td>
        </tr>`;
        document.querySelector('#orderDetails tbody').insertAdjacentHTML('beforeend', newRow);
    });

    // Remove product row
    document.querySelector('#orderDetails').addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('remove-product')) {
            event.target.closest('tr').remove();
        }
    });
</script>
@endsection
