<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Registration extends TestCase
{
    use RefreshDatabase;

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
     * Given I register a user
     * When I input null values to http POST '/register'
     * Then I get err msgs
     *
     * @return void
     */
    public function test_no_input_register_user()
    {
        $oResponse = $this->json('POST', '/register', [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => ''
        ]);

        $oResponse
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => [
                        "The name field is required."
                    ],
                    "email" => [
                        "The email field is required."
                    ],
                    "password" => [
                        "The password field is required."
                    ]
                ]
            ]);
    }

    /**
     * Given I register a user
     * When I input wrong values to http POST '/register'
     * Then I get err msgs
     *
     * @return void
     */
    public function test_wrong_input_register_user()
    {
        $oResponse = $this->json('POST', '/register', [
            'name' => 'a',
            'email' => 's',
            'password' => 's',
            'password_confirmation' => 'd'
        ]);

        $oResponse
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => [
                        "The name must be at least 2 characters."
                    ],
                    "password" => [
                        "The password confirmation does not match.",
                        "The password must be at least 6 characters."
                    ]
                ]
            ]);
    }

    /**
     * Given I register a user
     * When I complete form but wrong password
     * Then i should get password confirmation err msg
     *
     * @return void
     */
    public function test_wrong_pw_register_user()
    {
        $oResponse = $this->json('POST', '/register', [
            'name' => 'Alibaba',
            'email' => 'jackma@example.com',
            'password' => '1234562',
            'password_confirmation' => '123456'
        ]);

        $oResponse
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "password" => [
                        "The password confirmation does not match."
                    ]
                ]
            ]);
    }

    /**
     * Given I register a user
     * When I complete form
     * Then i get success msg
     *
     * @return void
     */
    public function test_register_user()
    {
        $oResponse = $this->json('POST', '/register', [
            'name' => 'Alibaba',
            'email' => 'jackma@example.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);

        $oResponse
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Register Success!',
                
                //(notsure)auto gets whether dev or deploy url
                'url' => url('/')
            ]);
    }
}
