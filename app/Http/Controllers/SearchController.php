<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

class SearchController extends Controller
{
     public function search(Request $request)
    {
        $query = $request->get('query');

        // Search by 'word' in words table
        $results = Word::where('word', 'LIKE', "%{$query}%")
            ->limit(5) // limit suggestions
            ->get(['id', 'word']); // return id + word column

        return response()->json($results);

    }


    public function getWord($id)
    {
        $word = Word::findOrFail($id);
        return response()->json($word);
    }
    
}
