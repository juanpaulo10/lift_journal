<?php

namespace App\Http\Controllers;

use App\Journal;
use App\Exercise;
use App\Body_part;
use App\Http\Requests\JournalForm;

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
     * @return \Illuminate\Http\Response
     */
    public function store(JournalForm $oJournalRequest)
    {
        $oJournalRequest->persist();

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
        return Journal::userJournals();
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

    public function bodyparts()
    {
        return Body_part::all()->toArray();
    }

    public function exercises()
    {
        return Exercise::where('body_part_id', request(['selectedPart']) )->get()->toArray();
    }
}
