<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class _InitalSeeder extends Seeder
{
    public function userSeeder()
    {
        try {
            // admin
            User::create([
                'name' => '{ JEBC-DeV }',
                'email' => 'admin@admin.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'),
            ]);

            // user
            User::create([
                'name' => 'User',
                'email' => 'user@user.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'),
            ]);

            // guest
            User::create([
                'name' => 'Guest',
                'email' => 'guest@guest.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'),
            ]);
        } catch (\Throwable $th) {
        }
    }

    public function categoryProductSeeder()
    {
        try {

            $vaporizadores = Category::create([
                'name' => 'Vaporizadores',
                'description' => 'Vaporizadores',
            ]);

            Product::create([
                'category_id' => $vaporizadores->id,
                'code' => 'VAP-001',
                'name' => 'Vaporizador 001',
                'description' => 'Vaporizador 001',
                'images' => null,
                'stock' => 10,
                'min_stock' => 1,
                'max_stock' => 100,
                'purchase_price' => 10000,
                'sale_price' => 20000,
            ]);

            Product::create([
                'category_id' => $vaporizadores->id,
                'code' => 'VAP-002',
                'name' => 'Vaporizador 002',
                'description' => 'Vaporizador 002',
                'images' => null,
                'stock' => 10,
                'min_stock' => 1,
                'max_stock' => 100,
                'purchase_price' => 15000,
                'sale_price' => 25000,
            ]);

            /*  */

            $digitales = Category::create([
                'name' => 'Digitales',
                'description' => 'Digitales',
            ]);

            Product::create([
                'category_id' => $digitales->id,
                'code' => 'DIG-001',
                'name' => 'Web en WordPress',
                'description' => 'Web en WordPress',
                'images' => null,
                'stock' => 100,
                'min_stock' => 1,
                'max_stock' => 100,
                'purchase_price' => 0,
                'sale_price' => 800000,
            ]);

            /*  */

            $varios = Category::create([
                'name' => 'Varios',
                'description' => 'Varios',
            ]);

            Product::create([
                'category_id' => $varios->id,
                'code' => 'VAR-001',
                'name' => 'Varios 001',
                'description' => 'Varios 001',
                'images' => null,
                'stock' => 100,
                'min_stock' => 1,
                'max_stock' => 100,
                'purchase_price' => 0,
                'sale_price' => 800000,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function customerSeeder()
    {
        try {

            for ($i = 1; $i <= 11; $i++) {
                Customer::create([
                    'name' => fake()->name,
                    'email' => fake()->unique()->safeEmail(),
                    'phone' => fake()->phoneNumber,
                    'zip_code' => fake()->postcode,
                    'address' => fake()->address,
                    'city' => fake()->city,
                    'state' => fake()->state,
                    'country' => fake()->country,
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function purchasePurchaseDetailsSeeder()
    {
        $purchase_number = 'PRC-' . fake()->unique()->numberBetween(1000, 9999);

        $purchase = Purchase::create([
            'user_id' => User::inRandomOrder()->first()->id,
            'date' => fake()->dateTimeBetween('-1 year', 'now'),
            'purchase_number' => $purchase_number,
            'description' => $purchase_number,
        ]);

        /* Detalle de Compra */

        for ($i = 1; $i <= 5; $i++) {
            $product = Product::inRandomOrder()->first();

            PurchaseDetails::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product->id,
                'quantity' => fake()->numberBetween(1, 10),
                
                'purchase_price' => $product->sale_price-(($product->sale_price*20)/100),
                'sale_price' => $product->sale_price,
            ]);
        }

        /*  */

        $purchase_number = 'PRC-' . fake()->unique()->numberBetween(1000, 9999);

        $purchase = Purchase::create([
            'user_id' => User::inRandomOrder()->first()->id,
            'date' => fake()->dateTimeBetween('-1 year', 'now'),
            'purchase_number' => $purchase_number,
            'description' => $purchase_number,
        ]);

        /* Detalle de Compra */

        for ($i = 1; $i <= 5; $i++) {
            $product = Product::inRandomOrder()->first();

            PurchaseDetails::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product->id,
                'quantity' => fake()->numberBetween(1, 10),
                'purchase_price' => $product->sale_price-(($product->sale_price*20)/100),
                'sale_price' => $product->sale_price,
            ]);
        }
    }

    public function saleSaleDetailsSeeder()
    {
        $sale_number = 'SL-' . fake()->unique()->numberBetween(1000, 9999);

        $sale = Sale::create([
            'user_id' => User::inRandomOrder()->first()->id,
            'date' => fake()->dateTimeBetween('-1 year', 'now'),
            'sale_number' => $sale_number,
            'description' => $sale_number,
        ]);

        /* Detalle de Compra */

        for ($i = 1; $i <= 5; $i++) {
            $product = Product::inRandomOrder()->first();

            SaleDetails::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => fake()->numberBetween(1, 10),
                'sale_price' => $product->sale_price,
            ]);
        }

        /*  */
        $sale_number = 'SL-' . fake()->unique()->numberBetween(1000, 9999);

        $sale = sale::create([
            'user_id' => User::inRandomOrder()->first()->id,
            'date' => fake()->dateTimeBetween('-1 year', 'now'),
            'sale_number' => $sale_number,
            'description' => $sale_number,
        ]);

        /* Detalle de Compra */

        for ($i = 1; $i <= 5; $i++) {
            $product = Product::inRandomOrder()->first();

            saleDetails::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => fake()->numberBetween(1, 10),
                'sale_price' => $product->sale_price,
            ]);
        }
    }

    public function run(): void
    {
        $this->userSeeder();
        $this->categoryProductSeeder();
        $this->customerSeeder();
        $this->purchasePurchaseDetailsSeeder();
        $this->saleSaleDetailsSeeder();
    }
}
