<?php

namespace Tests\Unit;

use App\User;
use App\Journal;
use App\Exercise;
use Carbon\Carbon;
use App\Helpers;
use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JournalTest extends TestCase
{
    use RefreshDatabase;

    private $oUser;
    private $oSessionResponse;

    public function setUp()
    {
        parent::setUp();

        //seed the static body_parts and exercises table
        $this->artisan('db:seed', ['--class' => 'ExerciseSeeder']);
        $this->artisan('db:seed', ['--class' => 'BodypartSeeder']);

        $this->oUser = factory(User::class)->create();
        $this->oSessionResponse = $this->actingAs($this->oUser)
                                        ->get('/'); //session created
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

    /**
     * Given I create a journal with exercise
     * When I find the first journal (since there is only 1 created)
     * Then they should be equal in their exercises pivot table.
     *
     * @return void
     */
    public function test_exercises_from_journal()
    {
        $oOriginalJournal = $this->createJournalExercise();

        $oJournal = Journal::first();
        $aExpected = $oJournal->exercises->toArray();

        $this->assertEquals($aExpected, $oOriginalJournal->exercises->toArray());
    }
    

    /**
     * Given I create two journals (separated by one month) [July, August]
     * When I call Journal::monthlyWorkouts()
     * Then there should be exactly two arrays for the two months
     *
     * @return void
     */
    public function test_monthly_workouts()
    {
        $this->createJournalExercise( Carbon::now()->subMonth()->toDateTimeString() );
        $this->createJournalExercise();
        
        $aMonthlyWorkouts = Journal::monthlyWorkouts();

        $aExpected = [
            [
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->format('F'),
                'published' => 1
            ],
            [
                'year' => Carbon::now()->subMonth()->year,
                'month' => Carbon::now()->subMonth()->format('F'),
                'published' => 1
            ]
        ];
        
        $this->assertEquals( $aExpected, $aMonthlyWorkouts );
    }

    /**
     * Given I create 12 journals (from JournalExerciseSeeder.php)
     * When I call Journal::userJournals();
     * Then I should get exactly 5 (Helpers::$iLimit) records from current user
     * 
     * @return void
     */
    public function test_user_journals_take_limit()
    {
        $this->artisan('db:seed', ['--class' => 'JournalExerciseSeeder']);

        $aUserJournals = Journal::userJournals()->get()->toArray();
        
        $this->assertCount(Helpers::$iLimit, $aUserJournals);
    }

    /**
     * Given I create 12 journals (from JournalExerciseSeeder.php)
     * When I call Journal::userJournals( null, $iTimesLoaded = 2 )
     * Then I should skip (2 sets of 5 records) = 10. and get the last 2 records
     *
     * @return void
     */
    public function test_user_journals_times_loaded()
    {
        $this->artisan('db:seed', ['--class' => 'JournalExerciseSeeder']);

        $oJournal = Journal::all()->random();

        $iTimesLoaded = 2;

        $aUserJournals = Journal::userJournals( null, $iTimesLoaded )->get()->toArray();

        $this->assertCount(2, $aUserJournals);
    }

    /**
     * Given I create 12 journals (from JournalExerciseSeeder.php)
     * When I call Journal::userJournals( [ not_array_here ] )
     * Then I should get 5 (Helpers::$iLimit) records
     *
     * @return void
     */
    public function test_user_journals_attr_not_array()
    {
        $this->artisan('db:seed', ['--class' => 'JournalExerciseSeeder']);

        $oJournal = Journal::all()->random();

        $iId = 1;

        $aUserJournals = Journal::userJournals( $iId )->get()->toArray();

        $this->assertCount(Helpers::$iLimit, $aUserJournals);
    }

    /**
     * Given I create 12 journals (from JournalExerciseSeeder.php)
     * When I call Journal::userJournals( [ 'id' => random_journal ] )
     * Then I should get the journal I passed as id.
     *
     * @return void
     */
    public function test_user_journals_attr_exercise_id()
    {
        $this->artisan('db:seed', ['--class' => 'JournalExerciseSeeder']);

        $oJournal = Journal::all()->random();

        $aId = [
            'id' => $oJournal->id
        ];

        $aUserJournals = Journal::userJournals( $aId )->get()->toArray();

        $this->assertCount(1, $aUserJournals);
        $this->assertEquals($oJournal->id, $aUserJournals[0]['id']);
    }

    /**
     * Given I create two journals (separated by one month) [July, August]
     * When I call latest journals of current user and filter them by empty arr
     * Then I should get 1 record because it should default by current month.
     *
     * @return void
     */
    public function test_scope_filter_no_params()
    {
        $this->createJournalExercise( Carbon::now()->subMonth()->toDateTimeString() );
        $this->createJournalExercise();

        $aJournals = Journal::latest()
                    ->where('user_id', auth()->user()->id)
                    ->filter( [] )
                    ->get()
                    ->toArray();

        $this->assertCount(1, $aJournals);
        $this->assertEquals( Carbon::now()->toDateTimeString(), $aJournals[0]['created_at'] );
    }

    /**
     * Given I create two journals (separated by one month) [July, August]
     * When I call latest journals of current user and filter them by empty arr
     * 
     * Then I should get 1 record because it should default by current month
     * and month key exists (will convert to this month)
     *
     * @return void
     */
    public function test_scope_filter_with_params_empty_month()
    {
        $this->createJournalExercise( Carbon::now()->subMonth()->toDateTimeString() );
        $this->createJournalExercise();

        $aRequest = [
            'month' => '',
            'year' => Carbon::now()->year
        ];

        $aJournals = Journal::latest()
                    ->where('user_id', auth()->user()->id)
                    ->filter( $aRequest )
                    ->get()
                    ->toArray();

        $this->assertCount(1, $aJournals);
        $this->assertEquals( Carbon::now()->toDateTimeString(), $aJournals[0]['created_at'] );
    }

    /**
     * Given I create two journals (separated by one month) [July, August]
     * When I call latest journals of current user and filter them by empty arr
     * 
     * Then I should get empty since input is not a month (in uri /filter?month=wrong)
     *
     * @return void
     */
    public function test_scope_filter_with_params_wrong_month()
    {
        $this->createJournalExercise( Carbon::now()->subMonth()->toDateTimeString() );
        $this->createJournalExercise();

        $aRequest = [
            'month' => 'wrong',
            'year' => Carbon::now()->year
        ];

        $aJournals = Journal::latest()
                    ->where('user_id', auth()->user()->id)
                    ->filter( $aRequest )
                    ->get()
                    ->toArray();

        
        $this->assertCount(0, $aJournals);
    }

    /**
     * Given I create two journals (separated by one month) [July, August]
     * When I call latest journals of current user and filter them by empty arr
     * 
     * Then I should get empty a request param 'year' exists but no value, undecided 
     * to which year to return
     *
     * @return void
     */
    public function test_scope_filter_with_params_empty_year()
    {
        $this->createJournalExercise( Carbon::now()->subMonth()->toDateTimeString() );
        $this->createJournalExercise();

        $aRequest = [
            'month' => Carbon::now()->format('F'),
            'year' => ''
        ];

        $aJournals = Journal::latest()
                    ->where('user_id', auth()->user()->id)
                    ->filter( $aRequest )
                    ->get()
                    ->toArray();
        
        $this->assertCount(0, $aJournals);
    }

    /**
     * Given I create two journals (separated by one month) [July, August]
     * When I call latest journals of current user and filter them by empty arr
     * 
     * Then I should get empty a request param 'year' exists but no value, undecided 
     * to which year to return
     *
     * @return void
     */
    public function test_scope_filter_with_params()
    {
        $this->createJournalExercise( Carbon::now()->subMonth()->toDateTimeString() );
        $this->createJournalExercise();

        $aRequest = [
            'month' => Carbon::now()->format('F'),
            'year' => Carbon::now()->year
        ];

        $aJournals = Journal::latest()
                    ->where('user_id', auth()->user()->id)
                    ->filter( $aRequest )
                    ->get()
                    ->toArray();
        
        $this->assertCount(1, $aJournals);
        $this->assertEquals( Carbon::now()->toDateTimeString(), $aJournals[0]['created_at'] );
    }

    /**
     * from the $this->oUser in setUp()
     * creates a journal with a single exercises as its pivot.
     *
     * @return Journal $oJournal
     */
    private function createJournalExercise($sCreatedAt = null)
    {
        $aNewJournal = [
            'title' => 'This is title',
            'notes' => 'I think I should bla'
        ];
        
        if($sCreatedAt){
            $aNewJournal[ 'created_at' ] = $sCreatedAt;
        }

        $oJournal = $this->oUser->publish(
            new Journal( $aNewJournal )
        );

        //find an exercise
        $oTempExercise = Exercise::first();

        //attach exercise
        $oJournal->exercises()->attach($oTempExercise, [
            'sets' => rand(1,4),
            'reps' => rand(6,15),
            'weight' => rand(30, 50)
        ]);

        return $oJournal;
    }
}
