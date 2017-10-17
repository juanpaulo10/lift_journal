<?php

namespace App\Http\Controllers;

use App\Journal;
use App\Exercise;
use App\Body_part;
use App\Http\Requests\JournalForm;
use App\Http\Requests\UpdateForm;

use Redis;

use Illuminate\Http\Request;

class JournalsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //->except(['index', 'show']);
    }

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
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(JournalForm $oJournalRequest)
    {
        $oJournalRequest->persist();
        $oJournal = Journal::userJournals()->first();
        $oRedis = Redis::connection();
        //publish to redis server that a journal was created
        $oRedis->publish('createdjournal', json_encode($oJournal));
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
        //validate
        $this->validate(request(), [
            'iTimesLoaded' => 'required|numeric',
        ]);

        return Journal::userJournals( null, request('iTimesLoaded') )->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Journal $oJournal, UpdateForm $oUpdateForm)
    {
        $oUpdateForm->persist($oJournal);
        
        //event fire with the journal to be sent to channel
        $oJournal = Journal::userJournals( ['id' => $oJournal->id] )->first();
        $oRedis = Redis::connection();
        //publish to redis server that a journal was updated
        $oRedis->publish('updatedjournal', json_encode($oJournal));
        //event( new Updated($oJournal) );

        return [
            'message' => 'Journal Updated!'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $oJournal)
    {
        $aId = ['id' => $oJournal->id];
        //publish to redis server that a journal was updated
        $oJournal->exercises()->detach();
        $oJournal->delete();

        $oRedis = Redis::connection();
        $oRedis->publish('deletedjournal', json_encode($aId));
        
        return ['message' => 'Journal Deleted!'];
    }

    public function bodyparts()
    {
        return Body_part::all()->toArray();
    }

    public function exercises()
    {
        return Exercise::where('body_part_id', request(['selectedPart']) )
                ->get()
                ->toArray();
    }
}
