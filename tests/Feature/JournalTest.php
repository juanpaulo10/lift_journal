<?php

namespace Tests\Feature;

use App\User;
use App\Exercise;
use App\Journal;
use Carbon\Carbon;

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

        //create exercises and body_parts records.
        $this->artisan('db:seed', ['--class' => 'ExerciseSeeder']);
        $this->artisan('db:seed', ['--class' => 'BodypartSeeder']);

        $this->oUser = factory(User::class)->create();
        $this->oSessionResponse = $this->actingAs($this->oUser)
                                        ->get('/'); //session created
    }

    //test journal delete

    /**
     * Given I create a journal
     * When I input data with no values
     * Then I should get error messages
     *
     * @return void
     */
    public function test_no_input_user_create_journal()
    {
        $oResponse = $this->json('POST', '/api/journal/create', [
            'title' =>  '',
            'notes' =>  '',
            'workouts' =>  [
                0 => [
                    'selectedExercise' =>  '',
                    'sets' =>  '',
                    'reps' =>  '',
                    'weight' =>  ''
                ]
            ]
        ]);

        $oResponse
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'title' => [
                        'The title field is required.'
                    ],
                    'notes' => [
                        'The notes field is required.'
                    ],
                    'workouts.0.selectedExercise' => [
                        'The workouts.0.selected exercise field is required.'
                    ],
                    "workouts.0.sets" => [
                        "The workouts.0.sets field is required."
                    ],
                    "workouts.0.reps" => [
                        "The workouts.0.reps field is required."
                    ],
                    "workouts.0.weight" => [
                        "The workouts.0.weight field is required."
                    ]
                ]
            ]);
    }

    /**
     * Given when I create journal
     * When I pass data with inappropriate values
     * Then I get error msgs
     *
     * @return void
     */
    public function test_wrong_input_user_create_journal()
    {
        $oResponse = $this->json('POST', '/api/journal/create', [
            'title' =>  'a',
            'notes' =>  'a',
            'workouts' =>  [
                0 => [
                    'selectedExercise' =>  's',
                    'sets' =>  's',
                    'reps' =>  's',
                    'weight' =>  'd'
                ]
            ]
        ]);

        $oResponse
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'title' => [
                        'The title must be at least 2 characters.'
                    ],
                    'notes' => [
                        'The notes must be at least 2 characters.'
                    ],
                    'workouts.0.selectedExercise' => [
                        'The workouts.0.selected exercise must be a number.'
                    ],
                    "workouts.0.sets" => [
                        "The workouts.0.sets must be a number."
                    ],
                    "workouts.0.reps" => [
                        "The workouts.0.reps must be a number."
                    ],
                    "workouts.0.weight" => [
                        "The workouts.0.weight must be a number."
                    ]
                ]
            ]);
    }

    /**
     * Given I create a journal
     * When I pass data with proper values
     * Then I should get a success msg
     *
     * @return void
     */
    public function test_user_create_journal()
    {
        $oResponse = $this->json('POST', '/api/journal/create', [
            'title' =>  'Shoulder into Boulder',
            'notes' =>  'Great sets today.',
            'workouts' =>  [
                0 => [
                    'selectedExercise' =>  1,
                    'sets' =>  3,
                    'reps' =>  8,
                    'weight' =>  100
                ]
            ]
        ]);

        //newly created journal
        $oJournal = Journal::first();

        $oResponse
            ->assertStatus(200)
            ->assertJson(['message' => 'Journal Published!']);

        $this->assertEquals($oJournal->title, 'Shoulder into Boulder');
    }

    /**
     * Given I create journal with pivot
     * When I update data through http patch (with no values)
     * Then I should get err msgs
     *
     * @return void
     */
    public function test_no_input_user_edit_journal()
    {
        $oJournal = $this->createJournalExercise();

        $oResponse = $this->json('PATCH', '/api/journal/' . $oJournal->id, [
            'title' =>  '',
            'notes' =>  '',
            'workouts' =>  [
                0 => [
                    'selectedExercise' =>  '',
                    'sets' =>  '',
                    'reps' =>  '',
                    'weight' =>  ''
                ]
            ]
        ]);

        $oNewJournal = Journal::find($oJournal->id);

        $oResponse
        ->assertStatus(422)
        ->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'title' => [
                    'The title field is required.'
                ],
                'notes' => [
                    'The notes field is required.'
                ],
                'workouts.0.selectedExercise' => [
                    'The workouts.0.selected exercise field is required.'
                ],
                "workouts.0.sets" => [
                    "The workouts.0.sets field is required."
                ],
                "workouts.0.reps" => [
                    "The workouts.0.reps field is required."
                ],
                "workouts.0.weight" => [
                    "The workouts.0.weight field is required."
                ]
            ]
        ]);

        $this->assertNotEquals($oNewJournal->title, 'Shoulder into Boulder');
    }

    /**
     * Given I create journal with pivot
     * When I update data through http patch (with wrong values)
     * Then I should get err msgs
     *
     * @return void
     */
    public function test_wrong_input_user_edit_journal()
    {
        $oJournal = $this->createJournalExercise();

        $oResponse = $this->json('PATCH', '/api/journal/' . $oJournal->id, [
            'title' =>  'a',
            'notes' =>  'a',
            'workouts' =>  [
                0 => [
                    'selectedExercise' =>  'a',
                    'sets' =>  'a',
                    'reps' =>  'a',
                    'weight' =>  'a'
                ]
            ]
        ]);

        $oNewJournal = Journal::find($oJournal->id);

        $oResponse
        ->assertStatus(422)
        ->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'title' => [
                    'The title must be at least 2 characters.'
                ],
                'notes' => [
                    'The notes must be at least 2 characters.'
                ],
                'workouts.0.selectedExercise' => [
                    'The workouts.0.selected exercise must be a number.'
                ],
                "workouts.0.sets" => [
                    "The workouts.0.sets must be a number."
                ],
                "workouts.0.reps" => [
                    "The workouts.0.reps must be a number."
                ],
                "workouts.0.weight" => [
                    "The workouts.0.weight must be a number."
                ]
            ]
        ]);

        $this->assertNotEquals($oNewJournal->title, 'Shoulder into Boulder');
    }

    /**
     * Given I create journal with pivot
     * When I update data through http patch (with proper values)
     * Then I should get success msg.
     *
     * @return void
     */
    public function test_user_edit_journal()
    {
        $oJournal = $this->createJournalExercise();

        $oResponse = $this->json('PATCH', '/api/journal/' . $oJournal->id, [
            'title' =>  'Shoulder into Boulder',
            'notes' =>  'Great sets today.',
            'workouts' =>  [
                0 => [
                    'selectedExercise' =>  1,
                    'sets' =>  3,
                    'reps' =>  8,
                    'weight' =>  100
                ]
            ]
        ]);

        $oNewJournal = Journal::find($oJournal->id);

        $oResponse
        ->assertStatus(200)
        ->assertJson(['message' => 'Journal Updated!']);

        $this->assertEquals($oNewJournal->title, 'Shoulder into Boulder');
    }

    /**
     * Given I create journal with pivot
     * When I delete data through http delete (wrong id)
     * Then I should get success msg
     *
     * @return void
     */
    public function test_wrongid_user_delete_journal()
    {
        $oJournal = $this->createJournalExercise();

        $oResponse = $this->json('DELETE', '/api/journal/' . ($oJournal->id + 1) );

        $oResponse
            ->assertStatus(404)
            ->assertJsonFragment([
                'message' => 'No query results for model [App\Journal].'
            ]);
    }

    /**
     * Given I create journal with pivot
     * When I delete data through http delete (correct id)
     * Then I should get success msg
     *
     * @return void
     */
    public function test_user_delete_journal()
    {
        $oJournal = $this->createJournalExercise();

        $oResponse = $this->json('DELETE', '/api/journal/' . $oJournal->id);

        $oResponse
            ->assertStatus(200)
            ->assertJson(['message' => 'Journal Deleted!']);
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

    /**
     * Given I create two journals (separated by month [July, August])
     * When I visit page without any request params
     * Then I should see sidebar with ('Month_1 Year_1' and 'Month_2 Year_2')
     *
     * @return void
     */
    public function test_visit_filter_check_sidebar_no_params()
    {
        $this->createJournalExercise( Carbon::now()->subMonth()->toDateTimeString() );
        $this->createJournalExercise( Carbon::now()->toDateTimeString() );
        
        $sParams = '';
        $oResponse = $this->get('/filter' . $sParams);
        
        $sFirstMonth = Carbon::now()->format('F') . ' ' . Carbon::now()->format('Y');
        $sSecondMonth = Carbon::now()->subMonth()->format('F') . ' ' . Carbon::now()->subMonth()->format('Y');
        
        $oResponse
            ->assertStatus(200)
            ->assertSee($sFirstMonth)
            ->assertSee($sSecondMonth);
    }

    /**
     * Given I create two journals (separated by month [July, August])
     * When I visit page without any request params
     * Then I should see ONE journal only for the current month.
     *
     * @return void
     */
    public function test_visit_filter_check_journals_no_params()
    {
        $oFirst = $this->createJournalExercise( Carbon::now()->subMonth()->toDateTimeString() );
        $oSecond = $this->createJournalExercise( Carbon::now()->toDateTimeString() );
        
        $sParams = '';
        $oResponse = $this->get('/filter' . $sParams);
        
        $oResponse
            ->assertStatus(200)
            ->assertDontSee( $oFirst->created_at->toFormattedDateString() )
            ->assertSee( $oSecond->created_at->toFormattedDateString() );
    }
}