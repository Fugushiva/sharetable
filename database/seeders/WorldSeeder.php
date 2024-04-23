<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nnjeim\World\Actions\SeedAction;
use Nnjeim\World\Models\Country;

class WorldSeeder extends Seeder
{
	public function run()
	{



		$this->call([
			SeedAction::class,
		]);


	}
}
