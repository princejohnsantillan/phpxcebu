<?php

use App\Http\Controllers\EventRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/event/{event:uuid}/register', \App\Livewire\EventRegistration::class);
