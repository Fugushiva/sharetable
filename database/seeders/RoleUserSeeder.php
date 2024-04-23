<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        DB::table('role_user')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $rolesUsers = [
            [
                'role' => 'admin',
                'name' => 'Jerome'
            ],
            [
                'role' => 'user',
                'name' => 'Ayu'
            ],
            [
                'role' => 'user',
                'name' => 'Bob'
            ],
            [
                'role' => 'user',
                'name' => 'Chen'
            ]

        ];

        foreach($rolesUsers as &$roleUser){
            $role = Role::where([
                ['role', '=', $roleUser['role']]
            ])->first();
            $user = User::where([
                ['firstname', '=', $roleUser['name']]
            ])->first();

            $roleUser['role_id'] = $role->id;
            $roleUser['user_id'] = $user->id;

            unset($roleUser['role']);
            unset($roleUser['name']);
        }

        DB::table('role_user')->insert($rolesUsers);

    }
}
