<?php

namespace Tests\Feature\Models;

use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscribed_scope()
    {
        Contact::factory()->create(['subscribed' => true]);
        Contact::factory()->unsubscribed()->create();

        $this->assertEquals(1, Contact::subscribed()->count());
    }

    public function test_contact_has_messaging_fields()
    {
        $contact = Contact::factory()->create([
            'subject' => 'Inquiry about video production',
            'message' => 'I need a promotional video for my business.',
        ]);

        $this->assertEquals('Inquiry about video production', $contact->subject);
        $this->assertEquals('I need a promotional video for my business.', $contact->message);
    }

    public function test_unread_scope()
    {
        Contact::factory()->create(['is_read' => false]);
        Contact::factory()->create(['is_read' => true]);

        $this->assertEquals(1, Contact::unread()->count());
    }

    public function test_mark_as_read()
    {
        $contact = Contact::factory()->create(['is_read' => false]);

        $contact->markAsRead();

        $this->assertTrue($contact->fresh()->is_read);
    }

    public function test_mark_as_replied()
    {
        $contact = Contact::factory()->create(['is_read' => false]);

        $contact->markAsReplied();

        $this->assertTrue($contact->fresh()->is_read);
        $this->assertNotNull($contact->fresh()->replied_at);
    }

    public function test_has_replies()
    {
        $contact = Contact::factory()->create();
        $this->assertFalse($contact->has_quotation);

        ContactReply::factory()->for($contact)->create();
        $this->assertFalse($contact->fresh()->has_quotation);

        ContactReply::factory()->for($contact)->withQuotation()->create();
        $this->assertTrue($contact->fresh()->has_quotation);
    }

    public function test_replied_at_is_datetime()
    {
        $contact = Contact::factory()->create();
        $contact->markAsReplied();

        $this->assertInstanceOf(\Carbon\Carbon::class, $contact->fresh()->replied_at);
    }

    public function test_is_read_cast()
    {
        $contact = Contact::factory()->create(['is_read' => false]);

        $this->assertIsBool($contact->is_read);
    }

    public function test_contact_has_ip_address()
    {
        $contact = Contact::factory()->create([
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0 TestBrowser',
        ]);

        $this->assertEquals('192.168.1.1', $contact->ip_address);
        $this->assertEquals('Mozilla/5.0 TestBrowser', $contact->user_agent);
    }

    public function test_ip_address_is_nullable()
    {
        $contact = Contact::factory()->create(['ip_address' => null]);

        $this->assertNull($contact->ip_address);
    }
}
