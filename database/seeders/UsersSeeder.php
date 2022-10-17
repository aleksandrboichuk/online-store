<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // super admin
        $admin = User::query()->create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@divisima.com',
            'is_admin' => true,
            'password' => Hash::make('admin'),
        ]);

        $admin->createCart();

        $admin->assignRole('super admin');

        // content manager
        $content_manager = User::query()->create([
            'first_name' => 'Content',
            'last_name' => 'Manager',
            'email' => 'content_manager@divisima.com',
            'is_admin' => true,
            'password' => Hash::make('content_manager'),
        ]);

        $content_manager->createCart();

        $content_manager->assignRole('content manager');

        // orders manager
        $orders_manager= User::query()->create([
            'first_name' => 'Orders',
            'last_name' => 'Manager',
            'email' => 'orders_manager@divisima.com',
            'is_admin' => true,
            'password' => Hash::make('orders_manager'),
        ]);

        $orders_manager->createCart();

        $orders_manager->assignRole('orders manager');

        // feedback manager
        $feedback_manager= User::query()->create([
            'first_name' => 'Feedback',
            'last_name' => 'Manager',
            'email' => 'feedback_manager@divisima.com',
            'is_admin' => true,
            'password' => Hash::make('feedback_manager'),
        ]);

        $feedback_manager->createCart();

        $feedback_manager->assignRole('feedback manager');

        // feedback manager
        $user = User::query()->create([
            'first_name' => 'Simple',
            'last_name' => 'User',
            'email' => 'user@divisima.com',
            'is_admin' => true,
            'password' => Hash::make('user'),
        ]);

        $user->createCart();

        $user->assignRole('user');
    }
}
