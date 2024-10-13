<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        // Fetch the current user's cart items
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $total = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->product->price * $item->quantity);
        }, 0);

        return view('user.cart', compact('cartItems', 'total')); // Return the cart view
    }
    //viewCart
    public function viewCart()
    {
        // Fetch the cart items for the logged-in user
        $cartItems = Cart::where('user_id', Auth::id())->get();

        // Calculate total price
        $total = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->product->price * $item->quantity);
        }, 0);

        // Pass cartItems and total to the view
        return view('user.cart', compact('cartItems', 'total'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id(); // Get the authenticated user's ID

        // Check if the product already exists in the cart
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Update quantity if already in the cart
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity,
            ]);
        } else {
            // Add the item to the cart
            Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('user.cart')->with('success', 'Product added to cart successfully.');
    }

    public function removeFromCart($id)
    {
        // Find the cart item by its ID
        $cartItem = Cart::findOrFail($id);

        // Check if the cart item belongs to the current user
        if ($cartItem->user_id == Auth::id()) {
            // Delete the cart item
            $cartItem->delete();
            return redirect()->route('user.cart')->with('success', 'Product removed from cart successfully.');
        } else {
            return redirect()->route('user.cart')->with('error', 'You do not have permission to remove this product from the cart.');
        }
    }

    // Update the quantity of a cart item
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the cart item by its ID
        $cartItem = Cart::findOrFail($id);

        if ($cartItem->user_id == Auth::id()) {
            // Update the quantity
            $cartItem->update(['quantity' => $request->quantity]);
            return redirect()->route('user.cart')->with('success', 'Cart updated successfully.');
        } else {
            return redirect()->route('user.cart')->with('error', 'You do not have permission to update this cart item.');
        }
    }

    public function checkout()
    {
        // Fetch the current user's cart
        $cartItems = Cart::where('user_id', Auth::id())->get();

        // Calculate the total price of the cart
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        // Process the order (this part would need your logic for handling payment)
        // You might want to create an Order model and store it in a separate table.

        // After processing, you might want to clear the cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user.cart')->with('success', 'Order placed successfully.'); // Or redirect to order confirmation page
    }
}
