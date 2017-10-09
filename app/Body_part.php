<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Body_part extends Model
{
    protected $fillable = [
        'name', 'id'
    ];

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }
}
