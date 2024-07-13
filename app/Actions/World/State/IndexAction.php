<?php

namespace App\Actions\World\State;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use App\Actions\World\ActionInterface;
use App\Actions\World\BaseAction;
use App\Actions\World\State\Queries\IndexQuery;
use App\Actions\World\State\Transformers\IndexTransformer;

class IndexAction extends BaseAction implements ActionInterface
{
	use IndexTransformer;

	protected string $module = 'states';

	protected string $cacheTag = 'states';

	protected string $attribute = 'state';

	protected array $defaultFields = [
		'id',
		'name',
	];

	protected array $availableFields = [
		'id',
		'name',
		'country_id',
		'country_code',
	];

	protected array $availableRelations = [
		'country',
		'cities',
	];

	/**
	 * @param  array  $args
	 * @return $this
	 */
	public function execute(array $args = []): self
	{
		[
			'fields' => $fields,
			'filters' => $filters,
			'search' => $search,
		] = $args + [
			'fields' => null,
			'filters' => null,
			'search' => null,
		];

		$this->validateArguments($fields, $filters);

		// cache
		$this->data = $search === null
			? Cache::rememberForever(
				$this->cacheKey,
				fn () => $this->indexQuery($search)
			)
			: $this->indexQuery($search);

		$this->success = ! empty($this->data);

		return $this;
	}

	/**
	 * @param  string|null  $search
	 * @return Collection
	 */
	private function indexQuery(?string $search = null): Collection
	{
		return $this->transform(
			(new IndexQuery($this->validatedFilters, $this->validatedRelations, $search))(),
			array_merge($this->validatedFields, $this->validatedRelations)
		);
	}
}
