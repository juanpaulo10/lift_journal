<?php

namespace App\Http\Controllers;

use App\Journal;
use App\Exercise;
use App\Body_part;
use Illuminate\Http\Request;

class JournalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( 'journals.home' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $aRules = [
            'title' => 'required|min:2',
            'notes' => 'required|min:2'
        ];
        
        foreach( $request['workouts'] as $iWorkout => $aWorkout ){
            $aRules["workouts.{$iWorkout}.selectedExercise"] = 'required|numeric';
            $aRules["workouts.{$iWorkout}.sets"] = 'required|numeric';
            $aRules["workouts.{$iWorkout}.reps"] = 'required|numeric';
            $aRules["workouts.{$iWorkout}.weight"] = 'required|numeric';
        }
        
        $this->validate( $request, $aRules );
        
        //create the journal and assign to a var
        $oJournal = auth()->user()->publish(
            new Journal( request(['title', 'notes']) )
        );
        
        foreach( $request['workouts'] as $iWorkout => $aWorkout ){
            //find the exercise.
            
            $oTempExercise = Exercise::findOrFail( $request["workouts"][$iWorkout]["selectedExercise"] );

            //attach the exercise to the journal  
            //$user->roles()->attach($roleId, ['expires' => $expires]);
            $oJournal->exercises()->attach($oTempExercise, [
                'sets' => $request[ "workouts" ][ $iWorkout ][ "sets" ],
                'reps' => $request[ "workouts" ][ $iWorkout ][ "reps" ],
                'weight' => $request[ "workouts" ][ $iWorkout ][ "weight" ]
            ]);
        }

        return ['message' => 'Journal Published!'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Journal $journal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        //
    }
}
