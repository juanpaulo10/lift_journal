<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'title', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercises()
    {
        // $this->belongsToMany('App\Role')->withPivot('column1', 'column2');
        
        return $this->belongsToMany(Exercise::class)
                    ->withPivot('weight', 'sets', 'reps');
    }

    public static function userJournals()
    {
        return static::with('exercises', 'exercises.bodypart')
                    ->latest()
                    ->where( 'user_id', auth()->user()->id )
                    ->get();
    }
}
