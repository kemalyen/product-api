<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

//use Illuminate\Support;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::truncate();
        User::truncate();
        Account::truncate();
        Product::truncate();
        Category::truncate();

        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Account Admin']);
        Role::create(['name' => 'Account User']);
        Role::create(['name' => 'Account Api User']);


        $accounts = Account::factory(5)
            ->has(
                User::factory()
            )->create()
            ->each(function ($account) {
                $account->users->each(function ($user) {
                    $user->assignRole('Account Admin');
                });
            });

        User::factory(3)
            ->recycle($accounts)
            ->create()
            ->each(function ($user) {
                $user->assignRole('Account User');
            });


        $categories = Category::factory(3)->create();
        Product::factory(10)
            ->recycle($categories)
            ->create();


        User::factory()
            ->recycle($accounts)
            ->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ])
            ->assignRole('Account Api User');

        User::factory()
            ->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
            ])
            ->assignRole('Admin');

        Model::reguard();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
