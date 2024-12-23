<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index($orderId)
    {
        $order = Order::with('products')->findOrFail($orderId);
        return view('order_details.index', compact('order'));
    }
    public function create()
    {
        $orders = Order::all();
        $products = Product::all();
        return view('order_details.create', compact('orders', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
        ]);

        OrderDetail::create($request->all());
        return redirect()->route('order_details.index');
    }

    public function show(OrderDetail $orderDetail)
    {
        return view('order_details.show', compact('orderDetail'));
    }

    public function destroy(OrderDetail $orderDetail)
    {
        $orderDetail->delete();
        return redirect()->route('order_details.index');
    }
}
