<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => "blue_rabbit",
            "password" => md5("blue_rabbit_password"),
            "email" => "sparow@salimon.ir",
            "phone" => "09216720496",
            "first_name" => "blue",
            "last_name" => "rabbit",
            "avatar" => "blue-rabbit.png",
            "status" => "active",
            "can_create_client" => true,
        ]);
        Permission::create([
            'user_id' => $user->id,
            'scope' => 'applications',
        ]);
        Permission::create([
            'user_id' => $user->id,
            'scope' => 'permissions',
        ]);
    }
}
