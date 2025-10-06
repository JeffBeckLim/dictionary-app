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
            'user_id' => 1,
        ],
        [
            'word' => 'happy',
            'pronunciation' => 'ˈhæpi',
            'definition' => 'Feeling or showing pleasure or contentment.',
            'part_of_speech' => 'adjective',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
        [
            'word' => 'book',
            'pronunciation' => 'bʊk',
            'definition' => 'A set of written or printed pages, usually bound with a protective cover.',
            'part_of_speech' => 'noun',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
        [
            'word' => 'quickly',
            'pronunciation' => 'ˈkwɪkli',
            'definition' => 'At a fast speed; rapidly.',
            'part_of_speech' => 'adverb',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
        [
            'word' => 'and',
            'pronunciation' => 'ænd',
            'definition' => 'Used to connect words of the same part of speech, clauses, or sentences.',
            'part_of_speech' => 'conjunction',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
        [
            'word' => 'under',
            'pronunciation' => 'ˈʌndər',
            'definition' => 'In or into a position below or beneath something.',
            'part_of_speech' => 'preposition',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
        [
            'word' => 'blue',
            'pronunciation' => 'bluː',
            'definition' => 'Of a color intermediate between green and violet.',
            'part_of_speech' => 'adjective',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
        [
            'word' => 'slowly',
            'pronunciation' => 'ˈsləʊli',
            'definition' => 'At a slow speed; not quickly.',
            'part_of_speech' => 'adverb',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
        [
            'word' => 'cat',
            'pronunciation' => 'kæt',
            'definition' => 'A small domesticated carnivorous mammal with soft fur.',
            'part_of_speech' => 'noun',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
        [
            'word' => 'think',
            'pronunciation' => 'θɪŋk',
            'definition' => 'To have a particular opinion or belief.',
            'part_of_speech' => 'verb',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
        [
            'word' => 'beautiful',
            'pronunciation' => 'ˈbjuːtɪfəl',
            'definition' => 'Pleasing the senses or mind aesthetically.',
            'part_of_speech' => 'adjective',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
        [
            'word' => 'but',
            'pronunciation' => 'bʌt',
            'definition' => 'Used to introduce a phrase or clause contrasting with what has already been mentioned.',
            'part_of_speech' => 'conjunction',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
        [
            'word' => 'above',
            'pronunciation' => 'əˈbʌv',
            'definition' => 'At a higher level or layer than.',
            'part_of_speech' => 'preposition',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
        [
            'word' => 'dog',
            'pronunciation' => 'dɔɡ',
            'definition' => 'A domesticated carnivorous mammal typically kept as a pet.',
            'part_of_speech' => 'noun',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
        [
            'word' => 'eat',
            'pronunciation' => 'iːt',
            'definition' => 'To put food into the mouth, chew, and swallow it.',
            'part_of_speech' => 'verb',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ],
    ]);

    
    }
}
