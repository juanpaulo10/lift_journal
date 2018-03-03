<?php

namespace Tests\Feature;

use App\User;
use App\Journal;
use App\Exercise;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
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

    /**
     * Given I create 3 journal
     * When I fetch them through 'api/feed', (but iTimesLoaded is 1)
     * Then I should get error msg
     *
     * Additional Notes:
     * When iTimesLoaded is 1, it will multiply to App\Helpers::$iLimit (int) 5
     * it skips (1 * 5) records(journals), if 2 then skips (2 * 5) records
     *
     * @return void
     */
    public function test_wrong_load_num_journals_feed()
    {
        $iNum = 3;
        $this->createJournals($iNum);

        $oResponse = $this->json('POST', '/api/feed', [
            'iTimesLoaded' => '1'
        ]);

        $oResponse
            ->assertStatus(200);

        $this->assertCount(0, $oResponse->json());
    }

    /**
     * Given I create 3 journals
     * When I fetch them through 'api/feed'
     * Then I should get exact 3 journals
     *
     * @return void
     */
    public function test_num_journals_feed()
    {
        $iNum = 3;
        $this->createJournals($iNum);

        $oResponse = $this->json('POST', '/api/feed', [
            'iTimesLoaded' => '0'
        ]);

        $oResponse
            ->assertStatus(200);

        $this->assertCount($iNum, $oResponse->json());
    }

    private function createJournals($iNum)
    {
        $iNum = $iNum ? $iNum : 1;
        $aJournals = factory(Journal::class, $iNum)->create()->each(function ($journal) {
            //randomize: select 1 to 3 exercises for every journal created
            $exercises = Exercise::all()->random(rand(1, 3));

            // input random data inside their pivot table.
            // and attach the same time.
            foreach ($exercises as $exercise) {
                $journal->exercises()->attach($exercise->id, [
                    'sets' => rand(1, 4),
                    'reps' => rand(6, 15),
                    'weight' => rand(30, 50)
                ]);
            }
        });
    }
}
