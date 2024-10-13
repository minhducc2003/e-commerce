<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function indexProducts()
    {
        $products = Product::all(); // Fetch all products
        return view('admin.products.index', compact('products')); // Pass products to the view
    }

    // Show the form to create a new product
    public function createProduct()
    {
        return view('admin.products.create'); // Return create product form
    }

    // Store a new product
    public function storeProduct(Request $request)
    {
        // Validate input including the image field
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|max:2048', // Ensure the image is uploaded
            'description' => 'nullable|string',
        ]);
    
        // Store the image in the 'public/products' directory
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public'); // Save the image
        } else {
            $imagePath = null; // Default to null if no image is uploaded
        }
    
        // Create the product
        $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->image_path = basename($imagePath); // Lưu tên file vào cơ sở dữ 
            $product->description = $request->description;
            $product->save(); // Lưu sản phẩm vào cơ sở dữ liệu
    
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }
    

    // Show the form to edit a product
    public function editProduct($id)
    {
        $product = Product::findOrFail($id); // Fetch the product by its ID
        return view('admin.products.edit', compact('product')); // Pass the product to the edit view
    }


    // Update a product
    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048', // Optional image during update
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);

        // Handle the new image if uploaded, else keep the old one
        if ($request->hasFile('image')) {
            // Optionally delete the old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = $product->image; // Retain existing image if no new image is uploaded
        }

        // Update product details
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }


    // Delete a product
    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);

        // Delete the product image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete the product from the database
        $product->delete();

        return back()->with('success', 'Product deleted successfully.');
    }


    // Similarly, add methods for edit, update, and destroy
}
