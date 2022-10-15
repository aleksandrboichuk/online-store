<?php

namespace Database\Seeders;

use App\Models\CategoryGroup;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $role = Role::create(['name' => 'super admin']);
        $permission = Permission::create(['name' => 'everything']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);

        $user = User::query()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'is_admin' => true,
            'password' => Hash::make('admin'),
        ]);

        $user->createCart();

        $user->assignRole($role);

        CategoryGroup::query()->create([
            'name' => 'Жінкам',
            'seo_name' => 'women',
        ]);

        CategoryGroup::query()->create([
            'name' => 'Чоловікам',
            'seo_name' => 'men',
        ]);

        //TODO::
    }
}
