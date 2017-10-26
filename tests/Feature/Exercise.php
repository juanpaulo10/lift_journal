<?php

namespace Tests\Feature;

use App\User;
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

        $this->oUser = factory(User::class)->create();
        $this->oSessionResponse = $this->actingAs($this->oUser)
                                        ->get('/'); //session created
    }

    /**
     * Given I create user and login
     * When I fetch exercises data through http post
     * Then I get no records because it is not seeded
     *
     * @return void
     */
    public function test_no_bodypart_fetch_exercise()
    {
        $oResponse = $this->json('POST', '/api/exercises', [
            'selectedPart' => 1
        ]);

        $oResponse->assertStatus(200);

        $this->assertCount( 0, $oResponse->json() );
    }

    /**
     * Given I create user and login
     * When I fetch exercises data through http post
     * Then I get records
     *
     * @return void
     */
    public function test_with_bodypart_fetch_exercise()
    {
        $this->artisan('db:seed', ['--class' => 'ExerciseSeeder']);

        $oResponse = $this->json('POST', '/api/exercises', [
            'selectedPart' => 1
        ]);

        $oResponse->assertStatus(200);

        $this->assertCount( 1, $oResponse->json() );
    }

    /**
     * Given I create user and login
     * When I fetch exercises data through http post
     * Then I get records
     *
     * @return void
     */
    public function test_no_data_passed_fetch_exercise()
    {
        $this->artisan('db:seed', ['--class' => 'ExerciseSeeder']);

        $oResponse = $this->json('POST', '/api/exercises');

        $oResponse
            ->assertStatus(500)
            ->assertJsonFragment([
                'message' => 'SQLSTATE[HY000]: General error: 2031  (SQL: select * from `exercises` where `body_part_id` = ?)'
            ]);
    }
}
