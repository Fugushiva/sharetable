<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nnjeim\World\Models\Language;

class NavigationController extends Controller
{
    /**
     * Display a listing of the resource.
     * Get the languages French and English
     * @return \Illuminate\View\View with the languages
     */
    public function index()
    {
        $languages = Language::whereIn('name',['French', 'English'])->get();

        return view('layouts.navigation', compact('languages'));
    }
}
