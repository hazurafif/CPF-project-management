<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'task-list',
            'task-create',
            'task-edit',
            'edit-all-task',
            'edit-finished-task',
            'task-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'can-be-pic',
            'title-create-task',
            'pic-create-task',
            'start-create-task',
            'deadline-create-task',
            'description-create-task',
            'picdescription-create-task',
            'upload-create-task',
            'picupload-create-task',
            'status-create-task',
            'title-edit',
            'pic-edit',
            'start-edit',
            'deadline-edit',
            'delay-edit',
            'description-edit',
            'picdescription-edit',
            'upload-edit',
            'picupload-edit',
            'status-edit'
         ];
        foreach ($permissions as $permission)
        {
            Permission::create(['name' => $permission]);
        }
   }
}
