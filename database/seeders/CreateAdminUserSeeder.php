<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '0123456789',
            'password' => bcrypt(123456),
            'image' => 'test.jpg'
        ]);
        $role = Role::create(['name' => 'Admin']);
        $permission = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permission);
        $role->revokePermissionTo('can-be-pic');
        $user->assignRole($role->id);
    }
}
