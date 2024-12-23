@extends('layouts.app')

@section('title', 'Create New Order')

@section('content')
    <div class="container">
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="form-group mb-4">
                <label for="customer_id"><strong>Customer</strong></label>
                <select class="form-control" id="customer_id" name="customer_id" required>
                    <option value="">Select Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="order_date"><strong>Order Date</strong></label>
                <input type="date" class="form-control" id="order_date" name="order_date" required>
            </div>

            <div class="form-group mb-4">
                <label for="status"><strong>Status</strong></label>
                <select class="form-control" id="status" name="status" required>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <!-- Products and Quantity -->
            <div class="form-group mb-4">
                <label for="products"><strong>Select Products and Quantity</strong></label>
                <table class="table" id="orderDetails">
                    <thead>
                        <tr>
                            <th><strong>Product</strong></th>
                            <th><strong>Quantity</strong></th>
                            <th><strong>Action</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select class="form-control" name="products[0][product_id]" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="products[0][quantity]" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-product">Remove</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" id="addProduct"><i class="fas fa-plus-circle"></i> Add Product</button>
            </div>

            <div class="form-group mb-4">
                <label for="total"><strong>Total Amount</strong></label>
                <input type="number" step="0.01" class="form-control" id="total" name="total" required>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Create Order</button>
        </form>
    </div>

    <script>
        // Add new product row
        document.getElementById('addProduct').addEventListener('click', function () {
            let rowCount = document.querySelectorAll('#orderDetails tbody tr').length;
            let newRow = `<tr>
                <td>
                    <select class="form-control" name="products[${rowCount}][product_id]" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" name="products[${rowCount}][quantity]" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-product">Remove</button>
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
