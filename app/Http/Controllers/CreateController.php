<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

class CreateController extends Controller
{
    public function index()
    {
        return view('pages.contribute');
    }
    
    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'word' => 'required|string|max:255',
            'pronunciation' => 'nullable|string|max:255',
            'part_of_speech' => 'nullable|string|max:255',
            'definition' => 'nullable|string',
        ]);

        // Create the word in database
        Word::create($validated);

        // Redirect back with success message
        return redirect()->route('contribute')->with('success', 'Word added successfully!');
    }
}
