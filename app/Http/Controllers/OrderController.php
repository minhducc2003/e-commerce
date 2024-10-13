<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    // List all orders for admin
    public function index()
    {
        $orders = Order::with('user')->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Approve an order
    public function approve($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'approved';
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order approved successfully.');
    }

    // Mark an order as delivered
    public function deliver($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'delivered';
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order marked as delivered successfully.');
    }


    public function placeOrder(Request $request)
{
    // Logic to process payment...

    // Calculate total from cart
    $totalAmount = 0;
    $items = []; // An array to hold the order items

    foreach (Auth::user()->cart->items as $item) {
        $totalAmount += $item->price * $item->quantity;

        // Prepare item data for the order_items table
        $items[] = [
            'product_id' => $item->product_id, // Assuming you have product_id in your cart items
            'quantity' => $item->quantity,
            'price' => $item->price,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Create the order
    $order = Order::create([
        'user_id' => Auth::id(),
        'total_amount' => $totalAmount,
        'total' => $totalAmount,
        'status' => 'pending',
    ]);

    // Insert the order items
    foreach ($items as $item) {
        $item['order_id'] = $order->id; // Set the order_id for the order_items
        OrderItem::create($item); // Assuming you have an OrderItem model
    }

    // Clear the user's cart...

    return redirect()->route('user.orders')->with('success', 'Order placed successfully.');
}
    public function viewOrder($id)
    {
        // Lấy đơn hàng theo ID, cùng với các sản phẩm liên quan
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        
        // Trả về view cùng với dữ liệu đơn hàng
        return view('admin.orders.view', compact('order'));
    }



}
