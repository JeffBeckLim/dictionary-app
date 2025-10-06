<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

class ManageController extends Controller
{
    public function index(Request $request)
    {
        // Search filter
        $search = $request->input('search');

        // Query builder
        $query = Word::query();

        if ($search) {
            $query->where('word', 'like', '%' . $search . '%')
                  ->orWhere('definition', 'like', '%' . $search . '%');
        }

        // Paginate results (10 per page)
        $words = $query->latest()->paginate(10);

        // Preserve search query in pagination links
        $words->appends(['search' => $search]);

        return view('pages.manage', compact('words', 'search'));
    }
    // Show edit form
    public function edit($id)
    {
        $word = Word::findOrFail($id);
        return view('pages.edit', compact('word'));
    }

    // Handle update form
    public function update(Request $request, $id)
    {
        $word = Word::findOrFail($id);

        $validated = $request->validate([
            'word' => 'required|string|max:255',
            'pronunciation' => 'nullable|string|max:255',
            'part_of_speech' => 'nullable|string|max:255',
            'definition' => 'nullable|string',
        ]);

        $word->update($validated);

        return redirect()->route('manage')->with('success', 'Word updated successfully!');
    }
}
