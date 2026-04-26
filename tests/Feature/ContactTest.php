<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_can_be_rendered(): void
    {
        $response = $this->get('/contact');

        $response->assertOk();
    }

    public function test_contact_form_requires_captcha(): void
    {
        $response = $this->from('/contact')->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Necesito informacion.',
        ]);

        $response->assertRedirect('/contact');
        $response->assertSessionHasErrors('g-recaptcha-response');
    }
}
