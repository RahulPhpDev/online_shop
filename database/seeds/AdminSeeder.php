<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Enums\RoleEnums;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user =  User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => 81111111,
            'password' => 123456,
            'role_id' => RoleEnums::ADMIN
        ]);

        $user->createToken('authToken');
    }
}
