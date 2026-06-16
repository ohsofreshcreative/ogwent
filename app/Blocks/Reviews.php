<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Support\SectionClasses;

class Reviews extends Block
{
	public $name = 'Slider - Opinie';
	public $description = 'reviews';
	public $slug = 'reviews';
	public $category = 'formatting';
	public $icon = 'format-quote';
	public $keywords = ['reviews', 'kafelki'];
	public $mode = 'edit';
	public $supports = [
		'align' => false,
		'mode' => false,
		'jsx' => true,
	];

	public function fields()
	{
		$reviews = new FieldsBuilder('reviews');

		$reviews
			->setLocation('block', '==', 'acf/reviews') // ważne!
			->addText('block-title', [
				'label' => 'Tytuł',
				'required' => 0,
			])
			->addAccordion('accordion1', [
				'label' => 'Slider - Opinie',
				'open' => false,
				'multi_expand' => true,
			])
			/*--- FIELDS ---*/
			->addTab('Treści', ['placement' => 'top'])
			->addGroup('g_reviews', ['label' => ''])
			->addText('title', ['label' => 'Tytuł'])
			->addWysiwyg('text', ['label' => 'Opis', 'media_upload' => 0, 'tabs' => 'visual'])
			->endGroup()

			/*--- OPINIE ---*/

			->addTab('Opinie', ['placement' => 'top'])
			->addRepeater('r_reviews', [
				'label' => 'Slider - Opinie',
				'layout' => 'table', // 'row', 'block', albo 'table'
				'min' => 1,
				'max' => 15,
				'button_label' => 'Dodaj kafelek'
			])
			->addTextarea('txt', [
				'label' => 'Opis',
				'rows' => 4,
				'new_lines' => 'br',
			])
			->addText('name', [
				'label' => 'Klient',
			])
			->endRepeater()

			/*--- USTAWIENIA BLOKU ---*/

			->addTab('Ustawienia bloku', ['placement' => 'top'])
			->addText('section_id', [
				'label' => 'ID',
			])
			->addText('section_class', [
				'label' => 'Dodatkowe klasy CSS',
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

		return $reviews;
	}

	public function with(): array
	{
		$fields = [
			'g_reviews' => get_field('g_reviews'),
			'r_reviews' => get_field('r_reviews'),

			'section_id' => get_field('section_id'),
			'section_class' => get_field('section_class'),

			'flip' => (bool) get_field('flip'),
			'wide' => (bool) get_field('wide'),
			'nomt' => (bool) get_field('nomt'),

			'background' => get_field('background') ?: 'none',
		];

		$fields['sectionClass'] = SectionClasses::fromMap($fields, [
			'flip' => 'order-flip',
			'wide' => 'wide',
			'nomt' => '!mt-0',
		]);

		return $fields;
	}

	public function enqueue()
	{
		// Pozostaw tę metodę pustą.
	}
}
