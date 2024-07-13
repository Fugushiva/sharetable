<?php

namespace App\Actions\World;

interface ActionInterface
{
	public function execute(array $args): self;
}
