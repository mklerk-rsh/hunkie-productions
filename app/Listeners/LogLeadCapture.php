<?php

namespace App\Listeners;

use App\Events\LeadCaptured;
use Illuminate\Support\Facades\Log;

class LogLeadCapture
{
    public function handle(LeadCaptured $event): void
    {
        Log::info('New lead captured', [
            'lead_id' => $event->lead->id,
            'email' => $event->lead->email,
            'source' => $event->lead->source,
        ]);
    }
}
