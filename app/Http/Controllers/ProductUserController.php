<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProductUSerController extends Controller
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
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        // Redirect back to the cart with a success message
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
        }

        // Redirect back to the cart with a success message
        return redirect()->route('user.cart')->with('success', ' Product removed from cart successfully.');
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

        // Redirect back to the cart with a success message
        return redirect()->route('user.cart')->with('success', 'Cart updated successfully.');
    }

    public function checkout()
    {
        // Fetch the current user's cart
        $cart = Cart::where('user_id', Auth::id())->get();

        // Calculate the total price of the cart
        $total = $cart->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Create a new order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
        ]);

        // Move cart items to the order
        foreach ($cart as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
            ]);
        }

        // Clear the cart
        Cart::where('user_id', Auth::id())->delete();

        // Redirect to the orders page with a success message
        return redirect()->route('user.orders')->with('success', 'Order placed successfully.');
    }

    public function viewOrders()
    {
        // Fetch the current user's orders
        $orders = Order::where('user_id', Auth::id())->get();

        // Return the orders view
        return view('user.orders', compact('orders'));
    }

    public function viewOrder($id)
    {
        // Fetch the order by its ID
        $order = Order::findOrFail($id);

        // Return the order view
        return view('user.order', compact('order'));
    }

    public function cancelOrder($id)
    {
        // Find the order by its ID
        $order = Order::findOrFail($id);

        // Check if the order belongs to the current user
        if ($order->user_id == Auth::id()) {
            // Delete the order
            $order->delete();
        }

        // Redirect back to the orders page with a success message
        return redirect()->route('user.orders')->with('success', 'Order cancelled successfully.');
    }
    public function storeProduct(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'required|image|max:2048', // Make sure the image is required for new products
        'description' => 'nullable|string',
    ]);

    // Store the image in the 'public/products' directory
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public'); // Save the image
    } else {
        $imagePath = null; // In case image is optional
    }

    // Create the product and store the image path
    Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'stock' => $request->stock,
        'image' => $imagePath, // Save image path in the database
        'description' => $request->description,
    ]);

    return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
}

public function updateProduct(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|image|max:2048', // Allow optional image update
        'description' => 'nullable|string',
    ]);

    $product = Product::findOrFail($id);

    // If a new image is uploaded, replace the old one
    if ($request->hasFile('image')) {
        // Delete the old image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Store the new image
        $imagePath = $request->file('image')->store('products', 'public');
    } else {
        $imagePath = $product->image; // Keep the current image if no new one is uploaded
    }

    // Update the product details
    $product->update([
        'name' => $request->name,
        'price' => $request->price,
        'stock' => $request->stock,
        'image' => $imagePath, // Update the image path
        'description' => $request->description
    ]);

    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
}


}