<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /** @test */
    public function root_route_responses_correctly()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function not_existing_route_returns_page_not_found() {
        $this->get('calendar')
            ->assertStatus(404);
    }

    /** @test */
    public function api_route_responses_correctly() {
        $this->post('/api/calendar', [
            'year'=> 2021
        ])
            ->assertSuccessful();
    }

    /** @test */
    public function api_route_with_wrong_year_param_returns_validation_error() {
        $this->post('/api/calendar', [
            'year' => 'word'
        ])
            ->assertSessionHasErrors('year');
    }

    /** @test */
    public function api_route_without_year_param_returns_validation_error() {
        $this->post('/api/calendar')
            ->assertSessionHasErrors('year');
    }

    /** @test */
    public function api_route_with_year_param_bigger_than_2050_returns_validation_error() {
        $this->post('/api/calendar', [
            'year' => 2060
        ])
            ->assertSessionHasErrors('year');
    }

    /** @test */
    public function api_route_with_year_param_smaller_than_2000_returns_validation_error() {
        $this->post('/api/calendar', [
            'year' => 1999
        ])
            ->assertSessionHasErrors('year');
    }
}
