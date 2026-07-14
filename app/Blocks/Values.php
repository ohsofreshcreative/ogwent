<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Support\SectionClasses;

class Values extends Block
{
	public $name = 'Wartości';
	public $description = 'Sekcja prezentująca unikalne wartości firmy';
	public $slug = 'values'; 
	public $category = 'formatting';
	public $icon = 'star-filled';
	public $keywords = ['values', 'wartości', 'kafelki'];
	public $mode = 'edit';
	public $supports = [
		'align' => false,
		'mode' => true,
		'jsx' => true,
		'anchor' => true,
		'customClassName' => true,
	];

	 public function fields()
    {
        $valuesBlock = new FieldsBuilder('values_block');

        $valuesBlock
            ->addText('block-title', [
                'label' => 'Tytuł bloku (tylko w edytorze)',
                'required' => 0,
            ])
            ->addAccordion('accordion1', [
                'label' => 'Wartości',
                'open' => false,
                'multi_expand' => true,
            ])
            ->addTab('Elementy', ['placement' => 'top'])
            ->addMessage('Edycja', 'Tę zawartość edytujemy klikając w menu panelu administratora "Wartości" (na dole menu).')

            ->addTrueFalse('show_top', [
                'label' => 'Pokaż nagłówek i opis (sekcja góry)',
                'default_value' => 1, // domyślnie włączone
                'ui' => 1,
                'ui_on_text' => 'Tak',
                'ui_off_text' => 'Nie',
            ])

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
            ->addTrueFalse('mb', [
                'label' => 'Dodanie marginesu dolnego',
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
                'ui' => 0, 
                'allow_null' => 0,
            ]);

        return $valuesBlock->build();
    }

   public function with(): array
   {
        $fields = [
            'g_values' => get_field('g_values', 'option'),
            'r_values' => get_field('r_values', 'option'),
            
            // Pobieramy wartość do zmiennej $show_top
            'show_top' => get_field('show_top') !== null ? (bool) get_field('show_top') : true,

            'section_id' => get_field('section_id'),
            'section_class' => get_field('section_class'),

            'flip' => (bool) get_field('flip'),
            'wide' => (bool) get_field('wide'),
            'nomt' => (bool) get_field('nomt'),
            'mb' => (bool) get_field('mb'),
            'gap' => (bool) get_field('gap'),
            'nolist' => (bool) get_field('nolist'),

            'background' => get_field('background') ?: 'none',
        ];

        $fields['sectionClass'] = \App\Support\SectionClasses::fromMap($fields, [
            'flip' => 'order-flip',
            'wide' => 'wide',
            'nomt' => '!mt-0',
            'mb' => '-smb',
            'gap' => 'wider-gap',
            'nolist' => 'no-list',
        ]);

        return $fields;
   }
}
