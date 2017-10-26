<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class About extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_about_page()
    {
        $oResponse = $this->get('/about');

        $oResponse
            ->assertStatus(200)
            ->assertSee('About');
    }
}
