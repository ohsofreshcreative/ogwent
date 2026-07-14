<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Carousel extends Block
{
	public $name = 'Slider - produkty';
	public $description = 'carousel';
	public $slug = 'carousel';
	public $category = 'formatting';
	public $icon = 'image-flip-horizontal';
	public $keywords = ['carousel', 'kafelki'];
	public $mode = 'edit';
	public $supports = [
		'align' => false,
		'mode' => true,
		'jsx' => true,
	];

	public function fields()
	{
		$carousel = new FieldsBuilder('carousel');

		$carousel
			->setLocation('block', '==', 'acf/carousel') // ważne!
			->addText('block-title', [
				'label' => 'Tytuł',
				'required' => 0,
			])
			->addAccordion('accordion1', [
				'label' => 'Slider - produkty',
				'open' => false,
				'multi_expand' => true,
			])
			/*--- FIELDS ---*/
			->addTab('Treści', ['placement' => 'top'])
			->addGroup('g_carousel', ['label' => ''])

			->addText('title', ['label' => 'Tytuł'])
			->addText('header', ['label' => 'Nagłówek'])

			->addText('promo_title', ['label' => 'Kafelek - Tytuł'])
			->addTextarea('promo_text', [
				'label' => 'Opis',
				'rows' => 4,
				'new_lines' => 'br',
			])
			->addLink('promo_btn', [
				'label' => 'Kafelek - Przycisk',
				'return_format' => 'array',
			])
			->addImage('promo_image', [
				'label'         => 'Kafelek - Zdjęcie tła',
				'return_format' => 'array',
				'preview_size'  => 'thumbnail',
			])
			->addTaxonomy('product_category', [
				'label'         => 'Kategoria produktów',
				'taxonomy'      => 'product_cat',
				'field_type'    => 'select',
				'allow_null'    => 1,
				'return_format' => 'id',
			])
			->addNumber('products_count', [
				'label'         => 'Liczba produktów',
				'default_value' => 8,
				'min'           => 1,
				'max'           => 24,
			])
			->endGroup()

			/*--- USTAWIENIA BLOKU ---*/

			->addTab('Ustawienia bloku', ['placement' => 'top'])
			->addText('section_id', [
				'label' => 'ID',
			])
			->addText('section_class', [
				'label' => 'Dodatkowe klasy CSS',
			])
			->addTrueFalse('nolist', [
				'label' => 'Brak punktatorów',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addTrueFalse('flip', [
				'label' => 'Odwrotna kolejność',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addTrueFalse('wide', [
				'label' => 'Szeroka kolumna',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addTrueFalse('nomt', [
				'label' => 'Usunięcie marginesu górnego',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addTrueFalse('gap', [
				'label' => 'Większy odstęp',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addSelect('background', [
				'label' => 'Kolor tła',
				'choices' => [
					'none' => 'Brak (domyślne)',
					'section-white' => 'Białe',
					'section-light' => 'Jasne',
					'section-gray' => 'Szare',
					'section-brand' => 'Marki',
					'section-gradient' => 'Gradient',
					'section-dark' => 'Ciemne',
				],
				'default_value' => 'none',
				'ui' => 0, // Ulepszony interfejs
				'allow_null' => 0,
			]);

		return $carousel;
	}

	public function with()
	{
		$category_id = get_field('g_carousel')['product_category'] ?? null;
		$count       = get_field('g_carousel')['products_count'] ?? 8;

		$args = [
			'post_type'      => 'product',
			'posts_per_page' => $count,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'post_status'    => 'publish',
		];

		if (!empty($category_id)) {
			$args['tax_query'] = [[
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $category_id,
			]];
		}

		$query = new \WP_Query($args);

		return [
			'g_carousel' => get_field('g_carousel'),
			'carousel'      => $query->posts,
			'section_id' => get_field('section_id'),
			'section_class' => get_field('section_class'),
			'nolist' => get_field('nolist'),
			'flip' => get_field('flip'),
			'wide' => get_field('wide'),
			'nomt' => get_field('nomt'),
			'gap' => get_field('gap'),
			'background' => get_field('background'),
		];
	}
}
