<?php

namespace Tests\Feature\Services;

use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactServiceTest extends TestCase
{
    use RefreshDatabase;

    private ContactService $contactService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->contactService = app(ContactService::class);
    }

    public function test_subscribe_creates_contact()
    {
        $contact = $this->contactService->subscribe([
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);

        $this->assertDatabaseHas('contacts', ['email' => 'test@example.com']);
        $this->assertTrue($contact->subscribed);
        $this->assertTrue($contact->opted_in);
    }

    public function test_subscribe_updates_existing_contact()
    {
        Contact::factory()->create(['email' => 'existing@example.com', 'name' => 'Old Name']);

        $contact = $this->contactService->subscribe([
            'email' => 'existing@example.com',
            'name' => 'Updated Name',
        ]);

        $this->assertEquals('Updated Name', $contact->name);
        $this->assertEquals(1, Contact::count());
    }

    public function test_unsubscribe()
    {
        $contact = Contact::factory()->create(['email' => 'test@example.com']);

        $this->contactService->unsubscribe('test@example.com');

        $this->assertFalse($contact->fresh()->subscribed);
    }
}
