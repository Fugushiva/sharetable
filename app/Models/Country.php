<?php

namespace Nnjeim\World\Models;

use App\Models\Annonce;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nnjeim\World\Models\Traits\WorldConnection;
use Nnjeim\World\Models\Traits\CountryRelations;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	use CountryRelations;
    use WorldConnection;

	protected $guarded = [];

	public $timestamps = false;

	/**
	 * Get the table associated with the model.
	 *
	 * @return string
	 */
	public function getTable(): string
	{
		return config('world.migrations.countries.table_name', parent::getTable());
	}

    public function annonces():HasMany
    {
        return $this->hasMany(Annonce::class);
    }
}
