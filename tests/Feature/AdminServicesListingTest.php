<?php

namespace Tests\Feature;

use App\Models\Icon;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminServicesListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_admin_can_sort_services_listing(): void
    {
        $user = User::factory()->create();
        $icon = Icon::create([
            'title' => 'Main Icon',
            'location' => 'icon.png',
        ]);

        Service::create([
            'title' => 'Zulu Service',
            'description' => 'Zulu description',
            'text' => ['content' => 'Zulu body'],
            'principal_page' => false,
            'icon_id' => $icon->id,
        ]);

        Service::create([
            'title' => 'Alpha Service',
            'description' => 'Alpha description',
            'text' => ['content' => 'Alpha body'],
            'principal_page' => false,
            'icon_id' => $icon->id,
        ]);

        $response = $this->actingAs($user)->get('/services/list?sort=title&direction=asc');

        $response->assertOk();
        $response->assertSeeInOrder(['Alpha Service', 'Zulu Service'], false);
    }
}
