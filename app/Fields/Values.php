<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Values extends Field
{
    public function fields(): array
    {
        $values = new FieldsBuilder('values');

        $values
            ->setLocation('options_page', '==', 'ovalues')

            /*--- TAB #1: Treści ---*/
            ->addTab('Treści', [
                'label' => 'Treści',
                'placement' => 'top'
            ])
            ->addGroup('g_values', [
                'label' => 'Treść główna',
            ])
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

            /*--- TAB #2: Kafelki ---*/
            ->addTab('Kafelki', [
                'label' => 'Kafelki',
                'placement' => 'top'
            ])
            ->addRepeater('r_values', [
                'label' => 'Kafelki',
                'layout' => 'block',
                'min' => 1,
                'button_label' => 'Dodaj kafelek'
            ])
            ->addImage('image', [
                'label' => 'Obraz',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ])
            ->addText('title', [
                'label' => 'Nagłówek kafelka',
            ])
            ->addTextarea('text', [
                'label' => 'Opis kafelka',
                'rows' => 3,
            ])
            ->endRepeater();

        return [$values];
    }
}