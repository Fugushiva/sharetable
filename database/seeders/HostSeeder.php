<?php

namespace Database\Seeders;

use App\Models\Host;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Faker\Provider\Text;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nnjeim\World\Models\City;


class HostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Host::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $hosts = [
            [
                'name' => 'jerome',
                'bio' => $faker->text(1200),
                'birthdate' => Carbon::create(1990,11,21)
            ],
            [
                'name' => 'Ayu',
                'bio' => $faker->text(720),
                'birthdate' => Carbon::create(1995,8,30)
            ],
        ];

        foreach($hosts as &$host){
            $user = User::where([
                ['firstname', '=', $host['name']]
            ])->first();

            $host['user_id'] = $user->id;

            unset($host['name']);

        }

        DB::table('hosts')->insert($hosts);
    }
}
