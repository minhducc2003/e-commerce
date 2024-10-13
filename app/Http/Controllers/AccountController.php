<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

class AccountController extends Controller
{

public function index()
    {
        $users = User::all(); // Fetch all users from the database
        return view('admin.accounts.index', compact('users')); // Pass the users to the view
    }

    public function create()
    {
        return view('admin.accounts.create'); // Return the user creation form
    }

    public function store(Request $request)
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

    public function edit($id)
    {
        $user = User::findOrFail($id); // Find user by ID
        return view('admin.accounts.edit', compact('user')); // Return edit form
    }

    public function update(Request $request, $id)
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

    public function destroy($id)
    {
        User::destroy($id); // Delete user by ID
        return back()->with('success', 'User deleted successfully.'); // Redirect back with message
    }

}