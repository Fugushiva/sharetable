<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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

        // Copier les fichiers d'images de source à destination
        $sourceDir = resource_path('test-images/host');
        $destDir = public_path('img/host');

        if (!File::isDirectory($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        $imageFiles = File::files($sourceDir);
        foreach ($imageFiles as $file) {
            $destPath = $destDir . '/' . $file->getFilename();
            File::copy($file->getRealPath(), $destPath);
        }

        // List of available images
        $images = array_map(fn ($file) => $file->getFilename(), $imageFiles);

        shuffle($images);

        $dataset = [
            [
                'firstname' => 'Jerome',
                'lastname' => 'Delodder',
                'email' => 'jeromedelodder90@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('epfc'),
                'country_name' => 'Belgium',
                'city_name' => 'Brussels',
                'profile_picture' =>'img/host/' . array_pop($images),
                'language_name' => 'French'
            ],
            [
                'firstname' => 'Bob',
                'lastname' => 'Sull',
                'email' => 'bob@epfc',
                'email_verified_at' => now(),
                'password' => Hash::make('epfc'),
                'country_name' => 'France',
                'city_name' => 'Paris',
                'profile_picture' => 'img/host/' . array_pop($images),
                'language_name' => 'French'
            ],
            [
                'firstname' => 'Ayu',
                'lastname' => 'Safira',
                'email' => 'ayu@epfc',
                'email_verified_at' => now(),
                'password' => Hash::make('epfc'),
                'country_name' => 'Indonesia',
                'city_name' => 'Jakarta',
                'profile_picture' => 'img/host/' . array_pop($images),
                'language_name' => 'Indonesian'
            ],
            [
                'firstname' => 'Chen',
                'lastname' => 'Zhen',
                'email' => 'Chen@epfc',
                'email_verified_at' => now(),
                'password' => Hash::make('epfc'),
                'country_name' => 'China',
                'city_name' => 'Shanghai',
                'profile_picture' => 'img/host/' . array_pop($images),
                'language_name' => 'English'
            ],
        ];

        foreach ($dataset as &$data) {
            $country = Country::where('name', '=', $data['country_name'])->first();
            $city = City::where('country_id', $country->id)->where('name', '=', $data['city_name'])->first();
            $language = Language::where('name', '=', $data['language_name'])->first();

            $data['country_id'] = $country->id;
            $data['city_id'] = $city->id;
            $data['language_id'] = $language->id;

            unset($data['country_name'], $data['city_name'], $data['language_name']);
        }

        DB::table('users')->insert($dataset);

        User::factory(30)->create()->each(function ($user) use (&$images) {
            if (empty($images)) {
                // Reset and shuffle images if they run out
                $sourceDir = resource_path('test-images/host');
                $imageFiles = File::files($sourceDir);
                $images = array_map(fn ($file) =>  $file->getFilename(), $imageFiles);
                shuffle($images);
            }

            $user->update([
                'profile_picture' => 'img/host/' . array_pop($images),
                'country_id' => Country::inRandomOrder()->first()->id,
                'city_id' => City::where('country_id', $user->country_id)->inRandomOrder()->first()->id,
            ]);
        });
    }
}
