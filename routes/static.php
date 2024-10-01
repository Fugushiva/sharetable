<?php

use Illuminate\Support\Facades\Route;

route::get('/terms', function () {
    return view('static.terms');
})->name('static.terms');

route::get('/faq', function () {
    return view('static.faq');
})->name('static.faq');
