<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class adCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $firstAd;
    public function __construct($firstAd)
    {
        $this->firstAd = $firstAd;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ad-card');
    }
}
