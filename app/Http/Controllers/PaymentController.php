<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        // Show the payment form
        return view('user.payment');
    }

    //complete payment
    public function completePayment(Request $request)
    {
        // Calculate total from cart
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

        // Create order items
        foreach (Auth::user()->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,

            ]);
        }

        // Clear the user's cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user.orders')->with('success', 'Order placed successfully.');
    }
}