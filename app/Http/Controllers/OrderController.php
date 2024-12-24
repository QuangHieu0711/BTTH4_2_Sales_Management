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
            ->paginate(10);
        
        return view('orders.index', compact('orders'));
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
        $this->validateOrder($request); // Sử dụng phương thức validateOrder() để validate thông tin

        // Tạo đơn hàng mới
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'order_date' => $request->order_date,
            'status' => $request->status,
        ]);

        // Thêm chi tiết đơn hàng
        $this->saveOrderDetails($order, $request->products);

        return redirect()->route('orders.index')->with('success', 'The order has been successfully created!');
    }

    // Hiển thị chi tiết đơn hàng
    public function show(Order $order)
    {
        return view('order_details.show', compact('order'));
    }

    // Hiển thị form sửa thông tin đơn hàng
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $customers = Customer::all();
        $products = Product::all(); // Thêm dòng này để lấy danh sách sản phẩm
        return view('orders.edit', compact('order', 'customers', 'products'));
    }

    public function update(Request $request, $id)
    {
        $this->validateOrder($request); // Validate thông tin đơn hàng

        // Cập nhật thông tin đơn hàng
        $order = Order::findOrFail($id);
        $order->update([
            'customer_id' => $request->customer_id,
            'order_date' => $request->order_date,
            'status' => $request->status,
        ]);

        // Cập nhật chi tiết đơn hàng
        $order->orderDetails()->delete(); // Xóa tất cả chi tiết cũ

        // Lưu lại chi tiết đơn hàng mới
        $this->saveOrderDetails($order, $request->products);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    protected function validateOrder(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,processing,shipped,completed',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);
    }

    // Xóa đơn hàng
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Xóa các chi tiết đơn hàng liên quan
        $order->orderDetails()->delete();

        // Xóa đơn hàng
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }

    // Hiển thị lịch sử đơn hàng của khách hàng
    public function showOrderHistory(Customer $customer)
    {
        // Lấy danh sách đơn hàng của khách hàng
        $orders = $customer->orders()->paginate(10);

        // Đặt giá trị cho biến idColumnLabel
        $idColumnLabel = 'Order ID';  // Hoặc thay bằng bất kỳ giá trị nào bạn muốn

        // Truyền dữ liệu vào view
        return view('orders.history', compact('orders', 'customer', 'idColumnLabel'));
    }

    // Phương thức dùng chung để validate thông tin đơn hàng
    protected function saveOrderDetails(Order $order, array $products)
    {
        foreach ($products as $product) {
            $order->orderDetails()->create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
            ]);
        }
    }

    // Phương thức hiển thị lịch sử đơn hàng của khách hàng (đã thêm vào)
    public function customerOrderHistory(Customer $customer)
    {
        // Lấy danh sách đơn hàng của khách hàng, phân trang 10 đơn hàng mỗi trang
        $orders = $customer->orders()->paginate(10);
        
        // Đặt giá trị cho biến idColumnLabel
        $idColumnLabel = 'Order ID';
    
        // Trả về view 'orders.history' với các tham số đã truyền
        return view('orders.history', compact('customer', 'orders', 'idColumnLabel'));
    }
}
