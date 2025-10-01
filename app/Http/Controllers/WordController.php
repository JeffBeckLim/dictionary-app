<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

class WordController extends Controller
{
     public function index()
    {
        $words = Word::all();
        return view('pages.welcome', compact('words'));
    }
}
