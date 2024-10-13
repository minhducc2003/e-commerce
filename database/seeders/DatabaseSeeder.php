<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \App\Models\User::truncate();
        \App\Models\Product::truncate();
        \App\Models\Order::truncate();

        \App\Models\User::factory(50)->create();
        \App\Models\Product::factory(30)->create();
        $this->generateRandomOrdersForLast12Months();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call(AdminSeeder::class); // Gọi seeder để tạo admin
    }

    private function generateRandomOrdersForLast12Months()
    {
        $months = [];
        $now = Carbon::now();

        // Generate the last 12 months
        for ($i = 0; $i < 12; $i++) {
            $date = $now->copy()->subMonths($i);
            $months[] = $date->format('Y-m');
        }

        // Create orders with random data for each month
        foreach ($months as $month) {
            $numberOfOrders = rand(5, 20); // Random number of orders for each month
            for ($j = 0; $j < $numberOfOrders; $j++) {
                Order::create([
                    'user_id' => rand(1, 50), // Random user from 1 to 50
                    'total_amount' => rand(1000, 5000) / 100, // Random total amount between 10.00 and 50.00
                    'status' => rand(0, 1) ? 'Approved' : 'Delivered', // Randomly assign status
                    'created_at' => Carbon::parse($month)->addDays(rand(1, 28)), // Random day of the month
                ]);
            }
        }
    }
}




