<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Word extends Model
{
    protected $fillable = [
        'word', 
        'pronunciation', 
        'definition', 
        'part_of_speech',
        'recording_path',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); 
    }

}
