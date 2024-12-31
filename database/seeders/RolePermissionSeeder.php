<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(["name" => "admin"]);


        $rolesPermissions = [
            "customer" => [
                "stadium:view", "stadium:viewAny", 
                "review:view", "review:viewAny", "review:create", "review:update", "review:delete",
                "booking:view", "booking:viewAny", "booking:create", "booking:update", "booking:delete",
                "chat:sendMessage", "chat:editMessage", "chat:deleteMessage", "chat:viewChat"
            ],
            "manager" => [
                "stadium:view", "stadium:viewAny", "stadium:create", "stadium:update", "stadium:delete",
                "review:view", "review:viewAny", "review:delete",
                "booking:view", "booking:viewAny",
            ],
            "helpdesk-support" => [
                "chat:sendMessage", "chat:editMessage", "chat:deleteMessage", "chat:viewChat",
            ]    
        ];

        foreach ($rolesPermissions as $role => $permissions) {
            $role = Role::create(["name" => $role]);
            $lst = [];
            foreach ($permissions as $permission) {
                array_push($lst, Permission::firstOrCreate(["name" => $permission]));
            }
            $role->syncPermissions($lst);
        }

    }
}
