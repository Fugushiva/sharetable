<?php

namespace Database\Seeders;

use App\Models\profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('profile_user')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $profilesUser = [
            [
                'profile' => 'host',
                'name' => 'Jerome'
            ],
            [
                'profile' => 'guest',
                'name' => 'Jerome'
            ],
            [
                'profile' => 'guest',
                'name' => 'Ayu'
            ],
            [
                'profile' => 'host',
                'name' => 'Ayu'
            ],
            [
                'profile' => 'guest',
                'name' => 'Bob'
            ],
            [
                'profile' => 'guest',
                'name' => 'Chen'
            ]

        ];

        foreach($profilesUser as &$profileUser){
            $profile = profile::where([
                ['profile', '=', $profileUser['profile']]
            ])->first();
            $user = User::where([
                ['firstname', '=', $profileUser['name']]
            ])->first();

            $profileUser['profile_id'] = $profile->id;
            $profileUser['user_id'] = $user->id;

            unset($profileUser['profile']);
            unset($profileUser['name']);
        }

        DB::table('profile_user')->insert($profilesUser);

    }
}
