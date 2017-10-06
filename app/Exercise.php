<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
        'name', 'bodypart_id', 'weight', 'sets', 'reps'
    ];
    
    public function bodyparts()
    {
        return $this->hasMany(Body_part::class);
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class);
    }
}
