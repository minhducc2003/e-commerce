<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;
    
    public function definition()
    {
        return [
            'user_id' => User::factory(), // Assuming you have users created already
            'total_amount' => $this->faker->randomFloat(2, 10, 500), // Total amount between 10 and 500
            'status' => $this->faker->randomElement(['Approved', 'Delivered']),
            'created_at' => now(),
        ];
    }
}


