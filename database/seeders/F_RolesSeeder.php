<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class F_RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // superadmin role
        $super_admin = Role::create(['name' => 'super admin']);
        $super_admin_permission = Permission::create(['name' => 'everything']);

        $super_admin->givePermissionTo($super_admin_permission);
        $super_admin_permission->assignRole($super_admin);


        // content manager role
        $content_manager = Role::create(['name' => 'content manager']);

        $permission_see = Permission::create(['name' => 'see content']);
        $permission_create = Permission::create(['name' => 'create content']);
        $permission_edit = Permission::create(['name' => 'edit content']);

        $content_manager->givePermissionTo($permission_see, $permission_create, $permission_edit);

        // orders manager
        $orders_manager = Role::create(['name' => 'orders manager']);

        $permission_see = Permission::create(['name' => 'see orders']);
        $permission_edit = Permission::create(['name' => 'edit orders']);

        $orders_manager->givePermissionTo($permission_see, $permission_edit);

        // feedback manager
        $feedback_manager = Role::create(['name' => 'feedback manager']);

        $permission_see_reviews = Permission::create(['name' => 'see reviews']);
        $feedback_manager->givePermissionTo($permission_see_reviews);

        // simple user
        $user_role = Role::create(['name' => 'user']);

        $permission_user = Permission::create(['name' => 'shopping']);
        $user_role->givePermissionTo($permission_user);
    }
}
