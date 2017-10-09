<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
        'name', 'body_part_id', 'weight', 'sets', 'reps'
    ];

    public function bodypart()
    {
        //Eloquent determines the default foreign key name by examining the name of the relationship method and suffixing the method name with _id. (in this case bodypart_id)
        //however, i named the column as body_part_id so i specify that in belongsTo 2nd param;
        return $this->belongsTo(Body_part::class, 'body_part_id');
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class);
    }
}
