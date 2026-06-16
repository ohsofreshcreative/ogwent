<?php

namespace App\Options;

use Log1x\AcfComposer\Options;

class Products extends Options
{
	public $name = 'Produkty';
	public $slug = 'products';
	public $title = 'Produkty';
	public $capability = 'edit_posts';
	public $redirect = false;
	public function fields(): array
	{
		return [];
	}
}
