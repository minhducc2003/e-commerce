<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        // Fetch all products from the database
        $products = Product::all();

        // Pass products to the view
        return view('user.index', compact('products'));
    }

    public function viewProduct($id)
    {
        // Fetch the product by its ID
        $product = Product::findOrFail($id);

        // Return the product view
        return view('user.product', compact('product'));
    }

    public function viewCart()
    {
        // Fetch the current user's cart
        $cart = Cart::where('user_id', Auth::id())->get();

        // Return the cart view
        return view('user.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        // Validate the input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Check if the product is already in the cart
        $cartItem = Cart::where('user_id', Auth::id()) // Using the Auth facade to get the authenticated user's ID
            ->where('product_id', $request->product_id)
            ->first();

        // If the product is in the cart, update the quantity
        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity,
            ]);
        } else {
            // Otherwise, create a new cart item
            Cart::create([
                'user_id' => Auth::id(), // Using the Auth facade to get the authenticated user's ID
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json(['success' => 'Product added to cart successfully']);
    }


    public function updateCart(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the cart item by its ID
        $cartItem = Cart::findOrFail($id);

        // Update the quantity
        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        // Redirect back to the cart page with a success message
        return redirect()->route('user.cart')->with('success', 'Cart updated successfully.');
    }

    public function removeFromCart($id)
    {
        // Find the cart item by its ID
        $cartItem = Cart::findOrFail($id);

        // Delete the cart item
        $cartItem->delete();

        // Redirect back to the cart page with a success message
        return redirect()->route('user.cart')->with('success', 'Product removed from cart.');
    }


}
