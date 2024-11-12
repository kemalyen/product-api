<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class ProductPriceFactory extends Factory
{
    protected $model = ProductPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'price' => fake()->randomFloat(2,1,1000),
            'account_id' => Account::factory(),
            
        ];
    }
}
