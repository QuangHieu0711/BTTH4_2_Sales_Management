
@extends('layouts.app')

@section('title', 'CUSTOMER MANAGEMENT')

@section('content')
<div class="container-xl">
    <h1 class="my-4"></h1>
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
                        <a href="{{ route('customers.create') }}" class="btn btn-success"><i class="bi bi-person-plus"></i> <span>ADD CUSTOMER</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone number</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $index => $customer)
                    <tr>
                        <!-- Tính thứ tự: (Trang hiện tại - 1) * Số bản ghi mỗi trang + chỉ số trong trang + 1 -->
                        <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $index + 1 }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>
                            <!-- Nút chỉnh sửa -->
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square" style="font-size: 20px;"></i>
                            </a>

                            <!-- Form xóa khách hàng -->
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete??')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="bi bi-trash" style="font-size: 20px;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center-end">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection