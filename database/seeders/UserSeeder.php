<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\Language;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        User::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $dataset = [
            [
                'firstname' => 'Jerome',
                'lastname' => 'Delodder',
                'email' => 'jeromedelodder90@gmail.com',
                'password' => Hash::make('epfc'),
                'country_name' => 'Belgium',
                'city_name' => 'Brussels',
                'profile_picture' => 'italian',
                'language_name' => 'French'
            ],
            [
                'firstname' => 'Bob',
                'lastname' => 'Sull',
                'email' => 'bob@epfc',
                'password' => Hash::make('epfc'),
                'country_name' => 'France',
                'city_name' => 'Paris',
                'profile_picture' => 'french',
                'language_name' => 'French'

            ],
            [
                'firstname' => 'Ayu',
                'lastname' => 'Safira',
                'email' => 'ayu@epfc',
                'password' => Hash::make('epfc'),
                'country_name' => 'Indonesia',
                'city_name' => 'Jakarta',
                'profile_picture' => 'indonesian',
                'language_name' => 'English'

            ],
            [
                'firstname' => 'Chen',
                'lastname' => 'Zhen',
                'email' => 'Chen@epfc',
                'password' => Hash::make('epfc'),
                'country_name' => 'China',
                'city_name' => 'Shanghai',
                'profile_picture' => 'chinese',
                'language_name' => 'English'
            ],

        ];

            foreach($dataset as &$data){
                $country = Country::where([
                    ['name', '=', $data['country_name']]
                ])->first();
                $city = City::where([
                    ['name', '=', $data['city_name']]
                ])->first();
                $language = Language::where([
                   ['name', '=', $data['language_name']]
                ])->first();

                $data['country_id'] = $country->id;
                $data['city_id'] = $city->id;
                $data['language_id'] = $language->id;

                unset($data['country_name']);
                unset($data['city_name']);
                unset($data['language_name']);
            }

            DB::table('users')->insert($dataset);

    }
}
