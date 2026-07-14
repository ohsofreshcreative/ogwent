<?php

namespace App\Options;

use Log1x\AcfComposer\Options;

class OValues extends Options
{
    public $name = 'Wartości';
    public $slug = 'ovalues';
    public $title = 'Wartości';
    public $position = 101; 
    public $capability = 'edit_posts';
    public $redirect = false;
    
    public function fields(): array
    {
        return [];
    }
}