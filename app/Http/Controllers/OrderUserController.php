<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderUserController extends Controller
{
    // Place an order after payment
    public function placeOrder(Request $request)
    {
        // Calculate total from the cart
        $totalAmount = 0;
        foreach (Auth::user()->cart as $item) {
            $totalAmount += $item->product->price * $item->quantity;
        }

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        // Clear the user's cart...

        return redirect()->route('user.orders')->with('success', 'Order placed successfully.');
    }

    // View user orders
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get(); // Fetch user orders
        return view('user.orders.index', compact('orders'));
    }

    // View a single order
    public function viewOrder($id)
    {
        $order = Order::findOrFail($id);
        return view('user.order', compact('order'));
    }
}
