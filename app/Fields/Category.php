<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Category extends Field
{
	public function fields(): array
	{
		$category = new FieldsBuilder('category_hero', [
			'title'    => 'Hero kategorii',
			'style'    => 'seamless',
			'position' => 'normal',
		]);

		$category
			->setLocation('taxonomy', '==', 'product_cat')
			->addImage('hero_image', [
				'label'          => 'Zdjęcie tła',
				'return_format'  => 'array',
				'preview_size'   => 'medium',
				'library'        => 'all',
			])
			->addWysiwyg('hero_header', [
				'label' => 'Nagłówek',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => false,
			]);

		return [$category];
	}
}
