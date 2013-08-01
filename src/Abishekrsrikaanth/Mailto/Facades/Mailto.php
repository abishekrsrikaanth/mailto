<?php namespace Abishekrsrikaanth\Mailto\Facades;

use Illuminate\Support\Facades\Facade;

class Mailto extends Facade
{
	protected static function getFacadeAccessor()
	{
		return "mailto";
	}
}