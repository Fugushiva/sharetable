<?php

namespace Database\Seeders;

use App\Models\profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        profile::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $profiles = [
            ['profile' => 'host'],
            ['profile' => 'guest']
        ];


        DB::table('profiles')->insert($profiles);
    }
}
