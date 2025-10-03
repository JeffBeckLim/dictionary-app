<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

class RecordAudioController extends Controller
{
    public function index($id)
    {
        $word = Word::findOrFail($id);
        return view('pages.record', compact('word'));
    }


   public function saveRecording(Request $request, $id)
    {
        $request->validate([
            'audio' => 'required|file|mimes:wav,mp3,webm,ogg|max:10240'
        ]);

        $word = Word::findOrFail($id);

        // Delete old recording if exists
        if ($word->recording_path && Storage::disk('public')->exists($word->recording_path)) {
            Storage::disk('public')->delete($word->recording_path);
        }

        // Save new recording
        $filename = 'word_' . $word->id . '_' . time() . '.' . $request->file('audio')->getClientOriginalExtension();
        $path = $request->file('audio')->storeAs('recordings', $filename, 'public');

        // Update word with recording path
        $word->update([
            'recording_path' => $path
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recording saved successfully!',
            'path' => Storage::url($path)
        ]);
    }
}
