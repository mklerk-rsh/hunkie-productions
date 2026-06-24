<?php

namespace App\Listeners;

use App\Events\ContactSubscribed;
use Illuminate\Support\Facades\Log;

class LogContactSubscription
{
    public function handle(ContactSubscribed $event): void
    {
        Log::info('New contact subscribed', [
            'contact_id' => $event->contact->id,
            'email' => $event->contact->email,
        ]);
    }
}
