<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            "name" => "admin",
            "email" => "usmonovabdulloh87@gmail.com",
            "phone_number" => "+998909001010",
            "email_verified_at" => now(),
            "password" => Hash::make("admin123"),
        ]);

        $user->assignRole('admin');

        $user = User::create([
            "name" => "manager",
            "email" => "manager98@gmail.com",
            "phone_number" => "+998918100217",
            "email_verified_at" => now(),
            "password" => Hash::make("manager123"),
        ]);

        $user->assignRole('manager');


        $user = User::create([
            "name" => "support",
            "email" => "support@gmail.com",
            "phone_number" => "+998995002030",
            "email_verified_at" => now(),
            "password" => Hash::make("support"),
        ]);
        $user->assignRole("helpdesk-support");

        $users = User::factory(10)->create();
        foreach($users as $user){
            $user->assignRole("customer");
        }
    }
}
