<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WordController;
use App\Http\Controllers\SearchController;

Route::get('/', [WordController::class, 'index']);

// WORD SEARCH ROUTE
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/word/{id}', [SearchController::class, 'getWord'])->name('word.details');
