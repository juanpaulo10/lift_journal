<?php

namespace App\Http\Controllers;

use App\Journal;
use App\Exercise;
use App\Body_part;
use App\Http\Requests\JournalForm;
use App\Http\Requests\UpdateForm;
use App\Helpers;

use Illuminate\Http\Request;

class JournalsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //->except(['index', 'show']);
    }

    /**
     * show view for home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( 'journals.home' );
    }

    /**
     * create new journal
     *
     * @return \Illuminate\Http\Response
     */
    public function store(JournalForm $oJournalRequest)
    {
        $oJournalRequest->persist();
        $oJournal = Journal::userJournals()->first();

        //publish to redis, journal is created
        Helpers::RedisPublish( 'createdjournal', $oJournal );
        
        return ['message' => 'Journal Published!'];
    }

    /**
     * Load more journals (when scrollY is at bottom of page)
     *
     * @return Journal records
     */
    public function show()
    {
        //validate
        $this->validate(request(), [
            'iTimesLoaded' => 'required|numeric',
        ]);

        return Journal::userJournals( null, request('iTimesLoaded') )->get();
    }

    /**
     * Update the journal w/ validation, publish in redis
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

        //publish to redis server that a journal was updated
        Helpers::RedisPublish( 'updatedjournal', $oJournal );
        //event( new Updated($oJournal) );

        return [
            'message' => 'Journal Updated!'
        ];
    }

    /**
     * Remove journal from db.
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

        Helpers::RedisPublish('deletedjournal', $aId);
        
        return ['message' => 'Journal Deleted!'];
    }

    /**
     * for ajax call of body parts in the <select> tag of
     * create/edit form
     *
     * @return array body_parts records
     */
    public function bodyparts()
    {
        //data here is static, can use all()
        return Body_part::all()->toArray();
    }

    /**
     * for ajax call of exercises in the <select> tag of
     * create/edit form
     *
     * @return array exercises records
     */
    public function exercises()
    {
        return Exercise::where('body_part_id', request(['selectedPart']) )
                ->get()
                ->toArray();
    }

    public function filter()
    {
        $aJournals = Journal::latest()
                    ->where('user_id', auth()->user()->id)
                    ->filter(request(['year', 'month']))
                    ->get()
                    ->toArray();

        return view( 'journals.filter', compact('aJournals') );
    }
}
