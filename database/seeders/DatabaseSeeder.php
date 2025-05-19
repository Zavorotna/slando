<?php

namespace Database\Seeders;

use App\Models\Rate;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Size;
use App\Models\User;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Subcategory;
use App\Models\Subsubcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $admin = Customer::factory()->create([
            'name' => 'admin',
            'surname' => 'admin',
            'phone' => '+380970000000',
            'role' => 'admin'
        ]);
        User::factory()->create([
            'customer_id' => $admin->id,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1111')
        ]);
        Rate::factory()->create([
            'currency' => 'uah',
            'exchange_rate' => 1
        ]);
        Rate::factory()->create([
            'currency' => 'eur',
            'exchange_rate' => 47
        ]);
        Rate::factory()->create([
            'currency' => 'usd',
            'exchange_rate' => 42
        ]);

        $customers = Customer::factory(10)->create();
        foreach($customers as $c) {
            if($c->role == 'user') {
                User::factory()->create(['customer_id' => $c->id,]);
            }
        }
        
        Category::factory(10)->create();
        Subcategory::factory(30)->create();
        Subsubcategory::factory(60)->create();
        Product::factory(200)->create();
        Color::factory(16)->create();
        Size::factory(100)->create();
    }
}
