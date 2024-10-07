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
                'bio' => "passionné de cuisine depuis mon plus jeune age je vous propose de découvrir mes spécialités",
                'birthdate' => Carbon::create(1990, 11, 21)
            ],
            [
                'name' => 'Ayu',
                'bio' => "Je vous invite à découvrir des plats typiques de ma région, cuisinés avec des produits frais et locaux. L'ambiance est chaleureuse et conviviale, comme à la maison.",
                'birthdate' => Carbon::create(1995, 8, 30)
            ],
            [
                'name' => 'Chen',
                'bio' => "Passionate about cooking, I love sharing moments around a good meal. My recipes blend tradition and creativity, offering a unique gastronomic experience.",
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
