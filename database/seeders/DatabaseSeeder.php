<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

//use Illuminate\Support;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Model::unguard();
        \DB::table('products')->truncate();
        $options = [
            'Colour' => [
                'Blue',
                'Green',
                'Black',
                'White',
                'Pink',
                'Red',
                'Yellow',
                'Navy',
                'Crimson'
            ],

            'Size' => ['Small', 'Medium', 'Large', 'X Large', 'XX Large']
        ];
        Product::factory(10)
            ->has(
                Product::factory()
                    ->count(3)
                    ->state(function (array $attributes) use ($options) {
                        $size = Arr::random($options['Size'], 1);
                        $colour = Arr::random($options['Colour'], 1);
                        return [
                            'options' => ['Size', 'Colour'],
                            'option_values' => [
                                'Size' => $size[0],
                                'Colour' => $colour[0]
                            ]
                        ];
                    })
                ,
                'variants'
            )
            ->create();

        Model::reguard();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}