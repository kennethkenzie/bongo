<?php

namespace Tests\Feature;

use Tests\TestCase;

class WebRouteTest extends TestCase
{
    public function test_root_redirects_browser_requests_to_frontend(): void
    {
        $this->get('/')
            ->assertRedirect(config('app.frontend_url'));
    }

    public function test_root_can_still_return_api_status(): void
    {
        $this->getJson('/')
            ->assertOk()
            ->assertJsonPath('status', 'ok')
            ->assertJsonPath('docs', url('/api/v1/home'));
    }
}
