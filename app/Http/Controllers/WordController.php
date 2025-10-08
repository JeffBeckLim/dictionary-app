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
    public function destroy(Word $word)
    {
        // Delete the audio file if it exists
        if ($word->recording_path && Storage::exists($word->recording_path)) {
            Storage::delete($word->recording_path);
        }

        $word->delete();

        return redirect()->route('manage')->with('success', 'Word deleted successfully.');
    }


}
