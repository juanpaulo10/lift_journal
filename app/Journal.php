<?php

namespace App;

use App\Helpers;

use Carbon\Carbon;

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

    /**
     * Journals including their pivot tables
     * can skip a number of records.
     * has default records to take
     * 
     * @param [type] $aJournalAttr
     * @param integer $iTimesLoaded
     * @return journals with pivot table data
     */
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

    public function scopeFilter($sQuery, $aFilters)
    {
        if( array_key_exists('month', $aFilters) === true ) {
            //'March' => 3, 'July' => 7
            try{
                $sQuery->whereMonth('created_at', Carbon::parse($aFilters['month'])->month);
            }catch( \Exception $e ){
                $sQuery->whereMonth('created_at', Carbon::now()->month);
            }
        }

        if( array_key_exists('year', $aFilters) === true ) {
            $sQuery->whereYear('created_at', $aFilters['year']);
        }

        return $sQuery;
    }

    /**
     * Returns journals published per month
     * [
     *      year => 2017,      
     *      month => "October",
     *      published => 2,   
     * ],
     * [                  
     *      year => 2017,      
     *      month => "November",
     *      published => 1,    
     *  ],                 
     */ 
    public static function monthlyWorkouts()
    {
        return static::selectRaw('year(created_at) year, monthname(created_at) month, count(*) published')
                    ->groupBy('year','month')
                    ->orderByRaw('min(created_at) DESC')
                    ->get()
                    ->toArray();
    }
    
    /**
     * Undocumented function
     *
     * @param [type] $iExerciseId
     * @return void
     */
    public static function pivotExerciseExists( $iExerciseId ) {
        return static::whereHas('exercises', function ($oQuery) use ($iExerciseId) { 
            $oQuery->where('exercise_id', $iExerciseId); 
        })
        ->exists();
    }
}
