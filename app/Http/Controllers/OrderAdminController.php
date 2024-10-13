<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderAdminController extends Controller
{
    // Display all orders
    public function index()
    {
        $orders = Order::with('user')->get(); // Load orders with user info
        return view('admin.orders.index', compact('orders'));
    }

    // Approve an order
    public function approve($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'approved'; // Update status
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order approved successfully.');
    }

    // Mark an order as delivered
    public function deliver($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'delivered'; // Update status
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order marked as delivered successfully.');
    }
}
