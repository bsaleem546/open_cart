<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $data = Order::latest()->get();
        return view('admin.orders.index', compact('data'));
    }

    public function orderDetails($id)
    {
        $order = Order::find($id);
        $orderProduct = $order->orderProducts;
        $customer = $order->customer;

        return view('admin.orders.details', compact('order', 'orderProduct', 'customer'));
    }

    public function orderStatus(Request $request)
    {
        Order::where('id', $request->id)->update([ 'status' => $request->order_status ]);
        return redirect()->back();
    }

    public function allCustomers()
    {
        $data = Customer::latest()->get();
        return view('admin.orders.customers', compact('data'));
    }
}
