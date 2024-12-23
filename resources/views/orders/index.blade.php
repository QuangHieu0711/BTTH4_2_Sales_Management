@extends('layouts.app')

@section('title', 'LIST ORDERS')

@section('content')
<div class="container-xl">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title mt-4">
                <div class="row">
                    <div class="col-sm-6">
                        <a href="{{ route('orders.create') }}" class="btn btn-success"><i class="bi bi-plus-circle"></i> <span>Add Order</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <!-- Tính thứ tự -->
                        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ $order->order_date }}</td>
                        <td>
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
                        </td>
                        <td>
                            <!-- View Details Button -->
                            <a href="{{ route('orderdetails.index', $order->id) }}" class="view-detail" title="View Details"><i class="bi bi-eye text-primary ms-2"></i></a>
                            <!-- Edit Button -->
                            <a href="{{ route('orders.edit', $order->id) }}" class="edit" data-toggle="tooltip" title="Edit"> <i class="bi bi-pencil-fill text-warning ms-2"></i></a>
                            <!-- Delete Modal Button -->
                            <a href="#deleteOrderModal{{ $order->id }}" class="delete" data-bs-toggle="modal" title="Delete"><i class="bi bi-trash text-danger ms-4"></i></a>
                            <!-- View Customer Order History -->
                            <a href="{{ route('orders.history', $order->customer->id) }}" class="view-history" title="View Order History">
                                <i class="bi bi-clock-history text-secondary ms-2"></i>
                            </a>
                            <!-- Delete Confirmation Modal -->
                            <div id="deleteOrderModal{{ $order->id }}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirm Deletion</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this order?</p>
                                                <p class="text-warning"><small>This action cannot be undone.</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    </div>
</div>

@endsection
