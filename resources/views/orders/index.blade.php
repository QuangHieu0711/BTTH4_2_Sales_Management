@extends('layouts.app')

@section('title', 'QUẢN LÝ ĐƠN HÀNG')

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
                        <a href="{{ route('orders.create') }}" class="btn btn-success"><i class="bi bi-plus-circle"></i> <span>Thêm đơn hàng</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $index => $order)
                    <tr>
                        <!-- Tính thứ tự -->
                        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ $order->order_date }}</td>
                        <td>
                            @switch($order->status)
                            @case('pending')
                            <span class="badge bg-warning text-dark badge-custom">
                                <i class="bi bi-hourglass-split"></i>  Chờ xử lý </span>
                            @break
                            @case('processing')
                            <span class="badge bg-info text-white badge-custom">
                                <i class="bi bi-gear"></i>  Đang xử lý </span>
                            @break
                            @case('shipped')
                            <span class="badge bg-primary text-white badge-custom">
                                <i class="bi bi-truck"></i>  Đã giao hàng </span>
                            @break
                            @case('completed')
                            <span class="badge bg-success text-white badge-custom">
                                <i class="bi bi-check-circle"></i>  Hoàn thành </span>
                            @break
                            @default
                            <span class="badge bg-secondary text-white badge-custom">
                                <i class="bi bi-question-circle"></i>  Không xác định</span>
                            @endswitch
                        </td>

                        <td>
                            <!-- Nút Xem chi tiết -->
                            <a href="{{ route('orderdetails.index', $order->id) }}" class="view-detail" title="Xem chi tiết"><i class="bi bi-eye text-primary ms-2"></i></a>

                            <!-- Nút chỉnh sửa -->
                            <a href="{{ route('orders.edit', $order->id) }}" class="edit" data-toggle="tooltip" title="Chỉnh sửa"><i class="bi bi-pencil-fill text-warning ms-2"></i></a>

                            <!-- Nút mở modal xóa -->
                            <a href="#deleteOrderModal{{ $order->id }}" class="delete" data-bs-toggle="modal" title="Xóa"><i class="bi bi-trash text-danger ms-4"></i></a>

                            <!-- Modal xác nhận xóa -->
                            <div id="deleteOrderModal{{ $order->id }}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h4 class="modal-title">Xác nhận xóa</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Bạn có chắc chắn muốn xóa đơn hàng này?</p>
                                                <p class="text-warning"><small>Hành động này không thể hoàn tác.</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-danger">Xóa</button>
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

            <!-- Phân trang -->
            <div class="clearfix">
                <div class="pagination-wrapper d-flex justify-content-end">
                    @if ($orders->hasPages())
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($orders->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                        @else
                        <li class="page-item">
                            <a href="{{ $orders->previousPageUrl() }}" class="page-link" rel="prev">&laquo;</a>
                        </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($orders->links()->elements as $element)
                        @if (is_string($element))
                        <li class="page-item disabled">
                            <span class="page-link">{{ $element }}</span>
                        </li>
                        @endif

                        @if (is_array($element))
                        @foreach ($element as $page => $url)
                        @if ($page == $orders->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                        @else
                        <li class="page-item">
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        </li>
                        @endif
                        @endforeach
                        @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($orders->hasMorePages())
                        <li class="page-item">
                            <a href="{{ $orders->nextPageUrl() }}" class="page-link" rel="next">&raquo;</a>
                        </li>
                        @else
                        <li class="page-item disabled">
                            <span class="page-link">&raquo;</span>
                        </li>
                        @endif
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection