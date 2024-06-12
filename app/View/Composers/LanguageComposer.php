<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Nnjeim\World\Models\Language;

class LanguageComposer
{
    public function compose(View $view)
    {
        $languages = Language::whereIn('name',['French', 'English'])->get();
        //dd($languages);
        $view->with('languages', $languages);
    }

}
