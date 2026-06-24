<?php

namespace Tests\Feature\Models;

use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactReplyTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_reply_belongs_to_contact()
    {
        $contact = Contact::factory()->create();
        $reply = ContactReply::factory()
            ->for($contact)
            ->create();

        $this->assertInstanceOf(Contact::class, $reply->contact);
        $this->assertEquals($contact->id, $reply->contact->id);
    }

    public function test_contact_reply_belongs_to_admin()
    {
        $admin = User::factory()->create();
        $reply = ContactReply::factory()
            ->for($admin, 'admin')
            ->create();

        $this->assertInstanceOf(User::class, $reply->admin);
        $this->assertEquals($admin->id, $reply->admin->id);
    }

    public function test_contact_has_many_replies()
    {
        $contact = Contact::factory()->create();
        ContactReply::factory()->count(3)->for($contact)->create();

        $this->assertEquals(3, $contact->replies()->count());
    }

    public function test_contact_reply_with_quotation()
    {
        $reply = ContactReply::factory()->withQuotation()->create();

        $this->assertNotNull($reply->quotation_path);
        $this->assertNotNull($reply->quotation_filename);
        $this->assertTrue($reply->hasQuotation());
    }

    public function test_contact_reply_without_quotation()
    {
        $reply = ContactReply::factory()->create();

        $this->assertNull($reply->quotation_path);
        $this->assertFalse($reply->hasQuotation());
    }
}
