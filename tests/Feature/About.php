<?php

namespace Tests\Feature;

use Tests\TestCase;

class About extends TestCase
{
    /**
     * Given I go use http get
     * When I go to /about page
     * Then I can see "About" text on page.
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
