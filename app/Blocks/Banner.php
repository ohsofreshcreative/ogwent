<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Support\SectionClasses;

class Banner extends Block
{
    public $name = 'Banner - Slider';
    public $description = 'banner';
    public $slug = 'banner';
    public $category = 'formatting';
    public $icon = 'image-flip-horizontal';
    public $keywords = ['banner', 'kafelki'];
    public $mode = 'edit';
    public $supports = [
        'align' => false,
        'mode' => true,
        'jsx' => true,
    ];

    public function fields()
    {
        $banner = new FieldsBuilder('banner');

        $banner
            ->setLocation('block', '==', 'acf/banner') // ważne!
            ->addText('block-title', [
                'label' => 'Tytuł',
                'required' => 0,
            ])
            ->addAccordion('accordion1', [
                'label' => 'Banner - Slider',
                'open' => false,
                'multi_expand' => true,
            ])
            /*--- FIELDS ---*/
            ->addTab('Treści', ['placement' => 'top'])
            ->addGroup('g_banner', ['label' => ''])

            ->addText('title', ['label' => 'Tytuł'])

            ->addRepeater('r_banner', [
                'label' => 'banner',
                'layout' => 'table', // 'row', 'block', albo 'table'
                'min' => 1,
                'max' => 10,
                'button_label' => 'Dodaj kafelek'
            ])
            ->addImage('bg', [
                'label' => 'Zdjęcie - tło',
                'return_format' => 'array', // lub 'url', lub 'id'
                'preview_size' => 'thumbnail',
            ])
            ->addImage('image', [
                'label' => 'Zdjęcie',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ])
            ->addText('title', [
                'label' => 'Tytuł',
            ])
            ->addText('header', [
                'label' => 'Nagłówek',
            ])
			->addLink('button', [
				'label' => 'Przycisk',
				'return_format' => 'array',
			])
            ->endRepeater()

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

        return $banner;
    }

  public function with(): array
	{
		$fields = [
            'g_banner' => get_field('g_banner'),
            'banner' => get_field('g_banner')['r_banner'] ?? [],

			'section_id' => get_field('section_id'),
			'section_class' => get_field('section_class'),

			'flip' => (bool) get_field('flip'),
			'wide' => (bool) get_field('wide'),
			'nomt' => (bool) get_field('nomt'),
			'gap' => (bool) get_field('gap'),
			'nolist' => (bool) get_field('nolist'),

			'background' => get_field('background') ?: 'none',
		];

		$fields['sectionClass'] = SectionClasses::fromMap($fields, [
			'flip' => 'order-flip',
			'wide' => 'wide',
			'nomt' => '!mt-0',
			'gap' => 'wider-gap',
			'nolist' => 'no-list',
		]);

		return $fields;
	}
}
