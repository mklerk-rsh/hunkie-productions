<?php

namespace App\Listeners;

use App\Events\BlogPostPublished;
use Illuminate\Support\Facades\Log;

class LogBlogPostPublished
{
    public function handle(BlogPostPublished $event): void
    {
        Log::info('Blog post published', [
            'blog_post_id' => $event->blogPost->id,
            'title' => $event->blogPost->title,
        ]);
    }
}
