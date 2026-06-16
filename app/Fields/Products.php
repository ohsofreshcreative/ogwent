<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Products extends Field
{
    public function fields(): array
    {
        $products = new FieldsBuilder('products');

        $products
            ->setLocation('options_page', '==', 'products')
            ->addImage('logo', [
                'label' => 'Logo',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ])
            ->addImage('logo_footer', [
                'label' => 'Logo Stopka',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ]);

        return [$products];
    }
}