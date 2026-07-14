<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ProductHint extends Field
{
    public function fields(): array
    {
        $productHint = new FieldsBuilder('product_hint', [
            'title'    => 'Wskazówka pod galerią',
            'style'    => 'default',
            'position' => 'normal', // Wygodny panel pod głównym edytorem
        ]);

        $productHint
            ->setLocation('post_type', '==', 'product')
            ->addWysiwyg('product_gallery_hint', [
                'label'        => 'Treść wskazówki',
                'instructions' => 'Tekst oraz grafika wyświetlą się w ramce bezpośrednio pod galerią zdjęć produktu.',
                'toolbar'      => 'basic', // uproszczony edytor (pogrubienie, lista, link)
                'media_upload' => false,
            ]);

        return [$productHint];
    }
}