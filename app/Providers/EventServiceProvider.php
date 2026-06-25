<?php

namespace App\Providers;

use App\Events\BlogPostPublished;
use App\Events\ContactSubscribed;
use App\Events\LeadCaptured;
use App\Events\ProjectPublished;
use App\Listeners\LogBlogPostPublished;
use App\Listeners\LogContactSubscription;
use App\Listeners\LogLeadCapture;
use App\Listeners\LogProjectPublished;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        LeadCaptured::class => [
            LogLeadCapture::class,
        ],
        ProjectPublished::class => [
            LogProjectPublished::class,
        ],
        BlogPostPublished::class => [
            LogBlogPostPublished::class,
        ],
        ContactSubscribed::class => [
            LogContactSubscription::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
