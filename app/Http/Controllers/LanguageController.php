<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Nnjeim\World\Models\Language;

class LanguageController extends Controller
{
    /**
     * Change the language of the application
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse with the new language
     */
    public function changeLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|string|exists:languages,code',
        ]);

        session(['locale' => $request->language]);


        App::setLocale($request->language);

        return redirect()->back();
    }
}
