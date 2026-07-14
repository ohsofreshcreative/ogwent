<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Support\SectionClasses;

class Categories extends Block
{
    public $name = 'Kategorie produktów';
    public $description = 'categories';
    public $slug = 'categories';
    public $category = 'formatting';
    public $icon = 'ellipsis';
    public $keywords = ['categories', 'kafelki'];
    public $mode = 'edit';
    public $supports = [
        'align' => false,
        'mode' => true,
        'jsx' => true,
    ];

    public function fields()
    {
        $categories = new FieldsBuilder('categories');

        $categories
            ->setLocation('block', '==', 'acf/categories')
            ->addText('block-title', [
                'label' => 'Tytuł',
                'required' => 0,
            ])
            ->addAccordion('accordion1', [
                'label' => 'Kategorie',
                'open' => false,
                'multi_expand' => true,
            ])

            /*--- TAB #1 ---*/
            ->addTab('Treści', ['placement' => 'top'])
            ->addGroup('g_categories', ['label' => ''])
            ->addText('title', ['label' => 'Tytuł'])
            ->addText('header', ['label' => 'Nagłówek'])
            ->addTextarea('text', [
                'label' => 'Opis',
                'rows' => 4,
                'new_lines' => 'br',
            ])
            ->addLink('button', [
                'label' => 'Przycisk',
                'return_format' => 'array',
            ])
            ->endGroup()

            /*--- TAB #2 ---*/
            ->addTab('Kategorie', ['placement' => 'top'])
            ->addTaxonomy('c_categories', [
                'label'         => 'Wybierz kategorie produktów (dokładnie 4)',
                'taxonomy'      => 'product_cat',
                'field_type'    => 'checkbox',
                'return_format' => 'object',
                'allow_null'    => 0,
                'multiple'      => 1,
            ])

            /*--- USTAWIENIA BLOKU ---*/
            ->addTab('Ustawienia bloku', ['placement' => 'top'])
            ->addText('section_id', [
                'label' => 'ID',
            ])
            ->addText('section_class', [
                'label' => 'Dodatkowe klasy CSS',
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
                    'none'              => 'Brak (domyślne)',
                    'section-white'     => 'Białe',
                    'section-light'     => 'Jasne',
                    'section-gray'      => 'Szare',
                    'section-brand'     => 'Marki',
                    'section-gradient'  => 'Gradient',
                    'section-dark'      => 'Ciemne',
                ],
                'default_value' => 'none',
                'ui'            => 0,
                'allow_null'    => 0,
            ]);

        return $categories;
    }

    public function with(): array
    {
        $terms = get_field('c_categories') ?: [];

        $r_categories = array_map(function ($term) {
            $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
            $image_src    = $thumbnail_id
                ? wp_get_attachment_image_src($thumbnail_id, 'large')
                : null;

            return [
                'name'      => $term->name,
                'link'      => get_term_link($term),
                'image_url' => $image_src ? $image_src[0] : '',
                'image_alt' => $thumbnail_id
                    ? (get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) ?: $term->name)
                    : $term->name,
            ];
        }, $terms);

        $fields = [
            'g_categories' => get_field('g_categories'),
            'r_categories' => $r_categories,

            'section_id'   => get_field('section_id'),
            'section_class' => get_field('section_class'),

            'flip'       => (bool) get_field('flip'),
            'wide'       => (bool) get_field('wide'),
            'nomt'       => (bool) get_field('nomt'),
            'gap'        => (bool) get_field('gap'),

            'background' => get_field('background') ?: 'none',
        ];

        $fields['sectionClass'] = SectionClasses::fromMap($fields, [
            'flip' => 'order-flip',
            'wide' => 'wide',
            'nomt' => '!mt-0',
            'gap'  => 'wider-gap',
        ]);

        return $fields;
    }
}