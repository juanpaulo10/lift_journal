<?php

namespace Tests\Unit;

use App\User;
use App\Journal;
use App\Exercise;
use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JournalTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        //seed the static body_parts and exercises table
        $this->artisan('db:seed', ['--class' => 'ExerciseSeeder']);
        $this->artisan('db:seed', ['--class' => 'BodypartSeeder']);
    }

    /**
     * Given I have a user,
     * When user creates journal
     * Then confirm if journal's user_id is user's id
     *
     * @return void
     */
    public function test_publish_journal_by_user()
    {
        $oUser = factory(User::class)->create();
        $oUser->publish(
            new Journal( ['title' => 'This is title', 'notes' => 'I think I should bla'] )
        );

        $oJournal = Journal::first();
        $this->assertEquals($oUser->id, $oJournal->user_id);
    }

    /**
     * test pivot table existence
     *
     * @return void
     */
    public function test_attach_exercise_to_journal()
    {
        //create user and publish a journal
        $oUser = factory(User::class)->create();
        $oJournal = $oUser->publish(
            new Journal( ['title' => 'This is title', 'notes' => 'I think I should bla'] )
        );

        //find an exercise
        $oTempExercise = Exercise::first();

        //attach exercise
        $oJournal->exercises()->attach($oTempExercise, [
            'sets' => rand(1,4),
            'reps' => rand(6,15),
            'weight' => rand(30, 50)
        ]);
        
        //get a pivot where it is the journal created
        $aExerciseJournal = DB::table('exercise_journal')
            ->where( 'journal_id', $oJournal->id )
            ->get()
            ->toArray();

        //get the expected journal along with its pivot data.
        $aExpectedJournal = Journal::with('exercises', 'exercises.bodypart')->where('id', $oJournal->id)
                                ->get()->toArray();

        //readability
        $aExpectedExercises = $aExpectedJournal[0]['exercises'];

        $sSets = $aExpectedExercises[0]['pivot']['sets'];
        $sReps = $aExpectedExercises[0]['pivot']['reps'];
        $sWeight = $aExpectedExercises[0]['pivot']['weight'];
        $iJournalId = $aExpectedJournal[0]['id'];
        $iExerciseId = $aExpectedExercises[0]['id'];
        
        $this->assertEquals($iJournalId, $aExerciseJournal[0]->journal_id);
        $this->assertEquals($iExerciseId, $aExerciseJournal[0]->exercise_id);
        $this->assertEquals($sSets, $aExerciseJournal[0]->sets);
        $this->assertEquals($sReps, $aExerciseJournal[0]->reps);
        $this->assertEquals($sWeight, $aExerciseJournal[0]->weight);
    }
}
