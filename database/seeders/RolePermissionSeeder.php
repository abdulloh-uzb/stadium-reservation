<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(["name"=> "admin"]);
        $role = Role::create(["name" => "customer"]);

        $role = Role::create(["name" => "manager"]);
        $managerPermissions = [
            Permission::create(["name" => "stadium:viewAny"]),
            Permission::create(["name" => "stadium:view"]),
            Permission::create(["name" => "stadium:create"]),
            Permission::create(["name" => "stadium:update"]),
            Permission::create(["name" => "stadium:delete"]),
            Permission::create(["name" => "stadium:restore"]),
            Permission::create(["name" => "booking:viewAny"]),
            Permission::create(["name" => "booking:view"]),
        ]; 

        $role->syncPermissions($managerPermissions);


        $role = Role::create(["name" => "helpdesk-support"]);
        $helpDeskPermissions = [
            Permission::create(["name" => "chat:viewAny"]),
            Permission::create(["name" => "chat:view"]),
            Permission::create(["name" => "chat:create"]),
            Permission::create(["name" => "chat:update"]),
            Permission::create(["name" => "chat:delete"]),
            Permission::create(["name" => "chat:restore"]),
        ]; 

        $role->syncPermissions($helpDeskPermissions);

    }
}
