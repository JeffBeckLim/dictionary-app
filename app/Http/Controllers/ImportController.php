<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

class ImportController extends Controller
{
    public function index()
    {
        return view('pages.import');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('file');
        $csvData = array_map('str_getcsv', file($file));
        
        // Remove header row
        $header = array_shift($csvData);

        
        $validated['user_id'] = $request->user()->id;
        
        foreach ($csvData as $row) {
            Word::create([
                'word' => $row[0],
                'pronunciation' => $row[1] ?? null,
                'part_of_speech' => $row[2] ?? null,
                'definition' => $row[3] ?? null,
                'user_id' => $validated['user_id']
            ]);
        }

        return redirect()->route('import')->with('success', 'Words imported successfully!');
    }
}
