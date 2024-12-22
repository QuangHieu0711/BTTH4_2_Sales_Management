<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index(Request $request)
    {
        $orders = Order::with('customer') 
            ->orderBy('id', 'desc')
            ->paginate(12); 

        $page = $request->input('page', 1); // Mặc định là trang 1
        return view('orders.index', compact('orders', 'page'));
    }

    // Hiển thị form tạo mới đơn hàng
    public function create()
    {
        $products = Product::all(); 
        $customers = Customer::all(); 

        return view('orders.create', compact('products', 'customers'));
    }

    // Lưu đơn hàng mới
    public function store(Request $request)
    {
        // Validate thông tin đơn hàng
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|string|max:255',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Tạo đơn hàng mới
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'order_date' => $request->order_date,
            'status' => $request->status,
        ]);

        // Thêm chi tiết đơn hàng
        foreach ($request->products as $product) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được tạo thành công!');
    }

    // Hiển thị chi tiết đơn hàng
    public function show(Order $order)
    {
        $order->load('orderDetails.product'); 

        return view('orders.show', compact('order'));
    }

    // Hiển thị form sửa thông tin đơn hàng
    public function edit(Order $order)
    {
        $products = Product::all(); 
        $customers = Customer::all();

        return view('orders.edit', compact('order', 'products', 'customers'));
    }

    // Cập nhật thông tin đơn hàng
    public function update(Request $request, Order $order)
    {
        // Validate thông tin cập nhật
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        // Cập nhật thông tin đơn hàng
        $order->update([
            'customer_id' => $request->customer_id,
            'order_date' => $request->order_date,
            'status' => $request->status,
        ]);

        // Cập nhật chi tiết đơn hàng
        $order->orderDetails()->delete(); // Xóa tất cả chi tiết cũ

        foreach ($request->products as $product) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được cập nhật thành công!');
    }

    // Xóa đơn hàng
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được xóa thành công!');
    }
}
