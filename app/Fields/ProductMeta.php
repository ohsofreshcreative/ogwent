<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ProductMeta extends Field
{
    public function fields(): array
    {
        $productMeta = new FieldsBuilder('product_meta', [
            'title'    => 'Dane produktu',
            'style'    => 'seamless',
            'position' => 'normal',
        ]);

        $productMeta
            ->setLocation('post_type', '==', 'product')

            /*--- SEKCJA 1: CZAS DOSTAWY ---*/
            ->addAccordion('acc_delivery', [
                'label'        => 'Ustawienia dostawy',
                'open'         => true,
                'multi_expand' => true,
            ])
                ->addText('delivery_time', [
                    'label'        => 'Czas dostawy',
                    'instructions' => 'Np. "2-3 dni robocze", "24h"',
                    'placeholder'  => '2-3 dni robocze',
                ])

            /*--- SEKCJA 2: WYRÓŻNIKI ---*/
            ->addAccordion('acc_badges', [
                'label'        => 'Wyróżniki pod przyciskiem',
                'open'         => false,
                'multi_expand' => true,
            ])
                ->addRepeater('product_badges', [
                    'label'        => 'Wyróżniki produktu',
                    'instructions' => 'Pojawią się bezpośrednio pod przyciskiem dodaj do koszyka',
                    'layout'       => 'row',
                    'button_label' => 'Dodaj wyróżnik',
                ])
                    ->addImage('image', [
                        'label'         => 'Grafika / Logo',
                        'return_format' => 'array',
                        'preview_size'  => 'thumbnail',
                    ])
                    ->addLink('link', [
                        'label'         => 'Link (opcjonalnie)',
                        'return_format' => 'array',
                    ])
                ->endRepeater();

        return [$productMeta];
    }
}