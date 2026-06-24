<?php

namespace App\Services;

use App\Events\ContactSubscribed;
use App\Models\Contact;

class ContactService
{
    public function subscribe(array $data): Contact
    {
        $contact = Contact::updateOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'] ?? null,
                'phone' => $data['phone'] ?? null,
                'source' => $data['source'] ?? 'website',
                'subscribed' => true,
                'opted_in' => true,
            ]
        );

        event(new ContactSubscribed($contact));

        return $contact;
    }

    public function unsubscribe(string $email): void
    {
        Contact::where('email', $email)->update(['subscribed' => false]);
    }

    public function getSubscribedContacts()
    {
        return Contact::subscribed()->latest()->paginate(20);
    }
}
