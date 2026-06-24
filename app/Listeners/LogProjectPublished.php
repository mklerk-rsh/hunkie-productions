<?php

namespace App\Listeners;

use App\Events\ProjectPublished;
use Illuminate\Support\Facades\Log;

class LogProjectPublished
{
    public function handle(ProjectPublished $event): void
    {
        Log::info('Project published', [
            'project_id' => $event->project->id,
            'title' => $event->project->title,
        ]);
    }
}
