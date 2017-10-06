<?php

namespace App\Http\Requests;

use App\Journal;
use App\Exercise;

use Illuminate\Foundation\Http\FormRequest;

class JournalForm extends FormRequest
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

    public function persist()
    {
        //create the journal and assign to a var
        $oJournal = auth()->user()->publish(
            new Journal( request(['title', 'notes']) ) // ["title" => "Asd"  "notes" => "asd"]
        );
        
        foreach( $this->workouts as $iWorkout => $aWorkout ){
            //find the exercise.
            $oTempExercise = Exercise::findOrFail( $this->workouts[$iWorkout]["selectedExercise"] );

            //attach the exercise to the journal  
            $oJournal->exercises()->attach($oTempExercise, [
                'sets' => $this->workouts[ $iWorkout ][ "sets" ],
                'reps' => $this->workouts[ $iWorkout ][ "reps" ],
                'weight' => $this->workouts[ $iWorkout ][ "weight" ]
            ]);
        }
    }
}
