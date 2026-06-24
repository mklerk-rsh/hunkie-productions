<?php

namespace App\Events;

use App\Models\BlogPost;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BlogPostPublished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public BlogPost $blogPost;

    public function __construct(BlogPost $blogPost)
    {
        $this->blogPost = $blogPost;
    }
}
