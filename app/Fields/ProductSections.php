<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ProductSections extends Field
{
    public function fields(): array
    {
        $productSections = new FieldsBuilder('product_sections', [
            'title'    => 'Sekcje opisu i specyfikacji',
            'style'    => 'default', // z ramką dla czytelności
            'position' => 'normal',  // na samym dole pod edytorem WordPressa
        ]);

        $productSections
            ->setLocation('post_type', '==', 'product')

            /*--- SEKCJA: SPECYFIKACJA ---*/
            ->addRepeater('specification_table', [
                'label'        => 'Tabela specyfikacji technicznej',
                'instructions' => 'Wpisuj parametry lub twórz nagłówki sekcji technicznych. Możesz dowolnie zmieniać ich kolejność przeciągając wiersze.',
                'layout'       => 'block',
                'button_label' => 'Dodaj wiersz',
            ])
                ->addTrueFalse('is_header', [
                    'label'         => 'Czy to nagłówek sekcji?',
                    'instructions'  => 'Włącz, jeśli ten wiersz ma być grubym nagłówkiem grupy (np. Dane ogólne, Jednostka wewnętrzna).',
                    'ui'            => 1,
                    'default_value' => 0,
                ])
                ->addText('header_title', [
                    'label'       => 'Nazwa nagłówka grupy',
                    'placeholder' => 'Np. Jednostka wewnętrzna HRP-M24ELSI/2',
                    'conditional_logic' => [
                        [
                            [
                                'field'    => 'is_header',
                                'operator' => '==',
                                'value'    => '1',
                            ],
                        ],
                    ],
                ])
                ->addText('param_name', [
                    'label'       => 'Nazwa parametru (lewa strona)',
                    'placeholder' => 'Np. Wymiary (Dł x Wys x Głę)',
                    'conditional_logic' => [
                        [
                            [
                                'field'    => 'is_header',
                                'operator' => '==',
                                'value'    => '0',
                            ],
                        ],
                    ],
                ])
                ->addTextarea('param_value', [
                    'label'       => 'Wartość parametru (prawa strona)',
                    'placeholder' => 'Np. 1080 x 335 x 226 mm',
                    'rows'        => 2,
                    'conditional_logic' => [
                        [
                            [
                                'field'    => 'is_header',
                                'operator' => '==',
                                'value'    => '0',
                            ],
                        ],
                    ],
                ])
            ->endRepeater()

            /*--- SEKCJA: F-GAZ ---*/
            ->addWysiwyg('fgaz_text', [
                'label'        => 'Oświadczenie F-Gaz — Tekst',
                'instructions' => 'Wprowadź główną treść oświadczenia.',
                'toolbar'      => 'full',
                'media_upload' => true,
            ])
            ->addTrueFalse('fgaz_enable_table', [
                'label'         => 'Czy dodać tabelę parametrów pod oświadczeniem?',
                'ui'            => 1,
                'default_value' => 0,
            ])
            ->addRepeater('fgaz_table', [
                'label'        => 'Tabela F-Gaz',
                'instructions' => 'Dodatkowe dane tabelaryczne pod treścią F-Gaz (np. warunki sprzedaży).',
                'layout'       => 'block',
                'button_label' => 'Dodaj wiersz',
                'conditional_logic' => [
                    [
                        [
                            'field'    => 'fgaz_enable_table',
                            'operator' => '==',
                            'value'    => '1',
                        ],
                    ],
                ],
            ])
                ->addTrueFalse('is_header', [
                    'label'         => 'Czy to nagłówek sekcji?',
                    'ui'            => 1,
                    'default_value' => 0,
                ])
                ->addText('header_title', [
                    'label'       => 'Nazwa nagłówka grupy',
                    'conditional_logic' => [
                        [
                            [
                                'field'    => 'is_header',
                                'operator' => '==',
                                'value'    => '1',
                            ],
                        ],
                    ],
                ])
                ->addText('param_name', [
                    'label'       => 'Nazwa parametru',
                    'conditional_logic' => [
                        [
                            [
                                'field'    => 'is_header',
                                'operator' => '==',
                                'value'    => '0',
                            ],
                        ],
                    ],
                ])
                ->addTextarea('param_value', [
                    'label'       => 'Wartość',
                    'rows'        => 2,
                    'conditional_logic' => [
                        [
                            [
                                'field'    => 'is_header',
                                'operator' => '==',
                                'value'    => '0',
                            ],
                        ],
                    ],
                ])
            ->endRepeater()

            /*--- DYNAMICZNE DODATKOWE PROFILE (TABSY) ---*/
            ->addRepeater('custom_tabs', [
                'label'        => 'Dodatkowe sekcje dynamiczne',
                'instructions' => 'Dodaj dowolną ilość własnych sekcji (np. pliki do pobrania, certyfikaty)',
                'layout'       => 'block',
                'button_label' => 'Dodaj nową sekcję',
            ])
                ->addText('title', [
                    'label'    => 'Tytuł sekcji (np. "Certyfikaty")',
                    'required' => 1,
                ])
                ->addWysiwyg('content', [
                    'label'    => 'Treść sekcji',
                    'required' => 1,
                ])
            ->endRepeater();

        return [$productSections];
    }
}