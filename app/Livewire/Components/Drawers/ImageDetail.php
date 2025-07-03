<?php

namespace App\Livewire\Components\Drawers;

use Livewire\Component;

class ImageDetail extends Component
{
    public static function getTitle(): string
    {
        return "File details";
    }

    public static function getCloseEvents(): array
    {
        return [];
    }
}