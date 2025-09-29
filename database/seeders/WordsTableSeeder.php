<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class WordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
         DB::table('words')->insert([
            [
                'word' => 'run',
                'pronunciation' => 'rʌn',
                'definition' => 'To move swiftly on foot.',
                'part_of_speech' => 'verb',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'word' => 'happy',
                'pronunciation' => 'ˈhæpi',
                'definition' => 'Feeling or showing pleasure or contentment.',
                'part_of_speech' => 'adjective',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'word' => 'book',
                'pronunciation' => 'bʊk',
                'definition' => 'A set of written or printed pages, usually bound with a protective cover.',
                'part_of_speech' => 'noun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'word' => 'quickly',
                'pronunciation' => 'ˈkwɪkli',
                'definition' => 'At a fast speed; rapidly.',
                'part_of_speech' => 'adverb',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'word' => 'and',
                'pronunciation' => 'ænd',
                'definition' => 'Used to connect words of the same part of speech, clauses, or sentences.',
                'part_of_speech' => 'conjunction',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    
    }
}
