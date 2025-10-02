<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::limit(4)->get();

        // Get 4 random suggestions
        $suggestedWords = Word::inRandomOrder()->limit(4)->get();

        
        return view('pages.welcome', compact('words', 'suggestedWords'));
    }

}
