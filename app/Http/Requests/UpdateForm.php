<?php

namespace App\Http\Requests;

use App\Journal;
use App\Exercise;

use Illuminate\Foundation\Http\FormRequest;

class UpdateForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $aRules = [
            'title' => 'required|min:2',
            'notes' => 'required|min:2'
        ];
        
        foreach( $this->workouts as $iWorkout => $aWorkout ){
            $aRules["workouts.{$iWorkout}.selectedExercise"] = 'required|numeric';
            $aRules["workouts.{$iWorkout}.sets"] = 'required|numeric';
            $aRules["workouts.{$iWorkout}.reps"] = 'required|numeric';
            $aRules["workouts.{$iWorkout}.weight"] = 'required|numeric';
        }
        
        return $aRules;
    }

    /**
     * UPDATES EXISTING AND INSERTS PIVOT ROWS AT SAME TIME
     *
     * @param Journal $oJournal
     * @return void
     */
    public function persist( Journal $oJournal )
    {
        $oJournal->title = $this->title;
        $oJournal->notes = $this->notes;

        $aPivotExercises = [];

        foreach( $this->workouts as $iWorkout => $aWorkout ){
            $iExerciseId = $this->workouts[$iWorkout]["selectedExercise"];
            
            $aPivotExercises[$iExerciseId] = [
                'sets' => $this->workouts[ $iWorkout ][ "sets" ],
                'reps' => $this->workouts[ $iWorkout ][ "reps" ],
                'weight' => $this->workouts[ $iWorkout ][ "weight" ]
            ];
        }

        // dont use updateExistingPivot and attach at the same time.
        // this updates existing pivot records and adding new at same time.
        $oJournal->exercises()->syncWithoutDetaching($aPivotExercises);
        $oJournal->save();
    }
}
