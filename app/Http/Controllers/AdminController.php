<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;



class AdminController extends Controller
{
    
    public function indexUsers()
    {
        $users = User::all(); // Fetch all users from the database
        return view('admin.accounts.index', compact('users')); // Pass the users to the view
    }

    public function createUser()
    {
        return view('admin.accounts.create'); // Return the user creation form
    }

    public function storeUser(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash the password
        ]);

        // Redirect to the user index with a success message
        return redirect()->route('admin.accounts.index')->with('success', 'User created successfully.');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id); // Find user by ID
        return view('admin.accounts.edit', compact('user')); // Return edit form
    }

    public function updateUser(Request $request, $id)
    {
        // Validate and update the user
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('admin.accounts.index')->with('success', 'User updated successfully.'); // Redirect to users index
    }

    public function destroyUser($id)
    {
        User::destroy($id); // Delete user by ID
        return back()->with('success', 'User deleted successfully.'); // Redirect back with message
    }
    
    public function dashboard()
{
    // 1. User Growth Data: Generate random user growth data
    $userData = [];
    for ($i = 0; $i < 12; $i++) {
        $userData[] = rand(5, 20); // Randomly generating user growth between 5 and 20 per month
    }

    // 2. Sales Data: Randomize monthly sales data
    $salesData = [];
    for ($i = 0; $i < 12; $i++) {
        $salesData[] = round(rand(100, 500), 2); // Randomizing sales amount between 100 and 500
    }

    // Tính toán tỷ lệ tăng trưởng người dùng
    $growthPercentage = (end($userData) - reset($userData)) / reset($userData) * 100;

    // Tính toán tỷ lệ tăng trưởng doanh thu
    $salesGrowthPercentage = (end($salesData) - reset($salesData)) / reset($salesData) * 100;

    // 3. Product Stock Data
    $products = Product::all();
    $productNames = $products->pluck('name')->toArray();
    $productStocks = $products->pluck('stock')->toArray();

    // Tính toán tỷ lệ tăng trưởng sản phẩm
    $currentMonthProductsCount = $products->count();
    // Giả sử bạn có một cách để lấy số lượng sản phẩm trong tháng trước (ví dụ, một biến đã lưu trữ hoặc một phương thức truy vấn)
    $previousMonthProductsCount = 20; // Bạn cần thay đổi cách lấy số lượng sản phẩm trước đó tùy theo logic của bạn

    if ($previousMonthProductsCount > 0) {
        $productGrowthPercentage = (($currentMonthProductsCount - $previousMonthProductsCount) / $previousMonthProductsCount) * 100;
    } else {
        $productGrowthPercentage = 100; // Hoặc 0 tùy thuộc vào logic bạn muốn
    }

    $productsCount = $products->count();
    $usersCount = User::count();
    $ordersCount = Order::count();
    $totalRevenue = Order::where('status', 'Delivered')->sum('total_amount');

    return view('admin.dashboard', compact(
        'productsCount', 
        'usersCount', 
        'ordersCount', 
        'totalRevenue', 
        'userData',  
        'salesData', 
        'productNames', 
        'productStocks', 
        'growthPercentage',
        'salesGrowthPercentage',
        'productGrowthPercentage' // Thêm biến này vào
    ));
}










}
