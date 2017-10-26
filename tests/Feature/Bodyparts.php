<?php

namespace Tests\Feature;

use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Bodyparts extends TestCase
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
     * When I fetch data without any bodyparts data
     * Then I should receive 0
     *
     * @return void
     */
    public function test_fetch_no_bodyparts()
    {
        $oResponse = $this->json('POST', '/api/bodyparts');

        $oResponse->assertStatus(200);

        $this->assertCount( 0, $oResponse->json() );
    }

    /**
     * Given I create user and login
     * When I fetch data with bodyparts data
     * Then I should receive 5
     *
     * @return void
     */
    public function test_fetch_with_bodyparts()
    {
        $this->artisan('db:seed', ['--class' => 'BodypartSeeder']);

        $oResponse = $this->json('POST', '/api/bodyparts');

        $oResponse->assertStatus(200);

        $this->assertCount( 5, $oResponse->json() );
    }
}
