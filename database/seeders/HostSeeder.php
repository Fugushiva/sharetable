<?php

namespace Database\Seeders;

use App\Models\Host;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'birthdate' => Carbon::create(1990, 11, 21)
            ],
            [
                'name' => 'Ayu',
                'bio' => $faker->text(720),
                'birthdate' => Carbon::create(1995, 8, 30)
            ],
            [
                'name' => 'Chen',
                'bio' => $faker->text(720),
                'birthdate' => Carbon::create(1992, 8, 30)
            ],
        ];

        DB::transaction(function () use ($hosts) {
            foreach ($hosts as &$host) {
                $user = User::where('firstname', '=', $host['name'])->first();

                if ($user) {
                    $hostExists = Host::where('user_id', $user->id)->exists();
                    if (!$hostExists) {
                        $host['user_id'] = $user->id;
                        unset($host['name']);
                        DB::table('hosts')->insert($host);
                    }
                }
            }

            $usersWithoutHost = User::doesntHave('host')->get();
            foreach ($usersWithoutHost as $user) {
                Host::factory()->create(['user_id' => $user->id]);
            }
        });
    }
}
