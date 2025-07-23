<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Example Feature Test for Trends Application
 * 
 * This test serves as a basic template and health check for the application.
 * It verifies that the home page loads successfully and returns a 200 status.
 * 
 * Note: RefreshDatabase trait can be uncommented when database tests are needed:
 * use Illuminate\Foundation\Testing\RefreshDatabase;
 */
class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
