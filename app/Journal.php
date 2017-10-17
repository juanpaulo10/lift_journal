<?php

namespace App;

use App\Helpers;

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

    public static function userJournals( $aJournalAttr = null , $iTimesLoaded = 0 )
    {
        $aWhere = [
            'user_id' => auth()->user()->id
        ];

        if( is_array($aJournalAttr) === true ) {
            foreach ($aJournalAttr as $sKey => $mVal) {
                $aWhere[$sKey] = $mVal;
            }
        }

        return static::with('exercises', 'exercises.bodypart')
                    ->latest()
                    ->where( $aWhere )
                    ->skip( $iTimesLoaded * Helpers::$iLimit )
                    ->take(Helpers::$iLimit);
    }

    public static function pivotExerciseExists( $iExerciseId ) {
        return static::whereHas('exercises', function ($oQuery) use ($iExerciseId) { 
            $oQuery->where('exercise_id', $iExerciseId); 
        })
        ->exists();
    }
}
