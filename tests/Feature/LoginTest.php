<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private $oUser;

    /**
     * adds a user for every test case
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->oUser = factory(User::class)->create();
    }
    
    /**
     * Given I have no user,
     * When i go to homepage
     * Then it should be error
     *
     * @return void
     */
    public function test_error_on_home_no_user()
    {
        $oResponse = $this->get('/');

        $oResponse->assertStatus(302);
    }

    /**
     * Given I create a user ( setUp() )
     * When I login with inappropriate email
     * Then I should receive response from validation
     *
     * @return void
     */
    public function test_fail_incomplete_email_login_http()
    {
        $oResponse = $this->json('POST', '/login', [
            'email' => 'asdf',
            'password' => 'secret'
        ]);
        
        //response from validator
        $oResponse
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => [
                        'The email must be a valid email address.'
                    ]
                ]
            ]);
    }

    /**
     * Given i create a user ( setUp() )
     * When I login with a non-existent user
     * Then response should include a message from exception.
     *
     * @return void
     */
    public function test_fail_complete_email_login_http()
    {
        $oResponse = $this->json('POST', '/login', [
            'email' => $this->oUser->email . 'x',
            'password' => 'secret'
        ]);
        
        $oResponse
            ->assertJsonFragment([
                'message' => 'Please check your credentials'
            ]);
    }

    /**
     * Given i create a user ( setUp() )
     * When I login with a non-existent user
     * Then response should include a message from exception.
     *
     * @return void
     */
    public function test_fail_wrong_password_login_http()
    {
        $oResponse = $this->json('POST', '/login', [
            'email' => $this->oUser->email,
            'password' => 'secretx'
        ]);
        
        $oResponse
            ->assertJsonFragment([
                'message' => 'Please check your credentials'
            ]);
    }

    /**
     * Given I create a user
     * When I login using http post
     * Then I should succeed with json response.
     *
     * @return void
     */
    public function test_login_success_http()
    {
        //see response @ SessionsController@store
        $oResponse = $this->json('POST', '/login', [
            'email' => $this->oUser->email,
            'password' => 'secret' //see UserFactory.php
        ]);

        $oResponse
            ->assertSuccessful()
            ->assertJson([
                'url' => '/'
            ]);
    }

    /**
     * Given I create a user
     * When I login
     * Then it should succeed
     *
     * @return void
     */
    public function test_login_success()
    {
        //session with user
        $oResponse = $this->actingAs($this->oUser)
                            ->get('/');

        $oResponse->assertSuccessful();
    }

    /**
     * Given I login as user
     * When I logout and go to homepage
     * Then I should be getting 302 status
     *
     * @return void
     */
    public function test_logout_as_user()
    {
        //session with user
        $oResponse = $this->actingAs($this->oUser)
                            ->get('/');
        auth()->logout();

        //it should redirect to login page
        $oGetLocation = $this->get('/');

        $oGetLocation->assertStatus(302);
    }

    /**
     * Given I login as user
     * When I logout through http post
     * Then I should be redirected to login page.
     *
     * @return void
     */
    public function test_logout_as_user_http()
    {
        //session with user
        $oResponse = $this->actingAs($this->oUser)
                            ->get('/');

        $oLogout = $this->json('POST', '/logout');

        $oLogout
            ->assertRedirect('/login');
    }
}
