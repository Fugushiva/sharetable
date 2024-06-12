<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nnjeim\World\Models\Language;

class NavigationController extends Controller
{
    public function index()
    {
        $languages = Language::whereIn('name',['French', 'English'])->get();

        return view('layouts.navigation', compact('languages'));
    }
}
