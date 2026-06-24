<?php

namespace Tests\Feature\Models;

use App\Models\Contact;
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
}
