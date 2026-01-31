<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/places', 'places.places')->name('places.index');
Route::livewire('/places/form', 'places.form-place')->name('places.form');