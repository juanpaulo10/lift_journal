<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * create a user,
     * get the first record in users table
     * 
     * check if the same user name
     *
     * @return void
     */
    public function test_user_compare_to_db()
    {
        //Given I have created a user
        $oUser = factory('App\User')->create();
        //When I get the first record in users table
        $oCompareUser = \App\User::first();
        
        //Then their name should be the same
        $this->assertEquals($oUser->name, $oCompareUser->name);
    }
}
