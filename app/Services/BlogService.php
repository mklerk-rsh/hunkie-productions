<?php

namespace App\Services;

use App\Events\BlogPostPublished;
use App\Models\BlogPost;

class BlogService
{
    public function create(array $data): BlogPost
    {
        $post = BlogPost::create($data);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post;
    }

    public function update(BlogPost $blogPost, array $data): BlogPost
    {
        $blogPost->update($data);

        if (isset($data['tags'])) {
            $blogPost->tags()->sync($data['tags']);
        }

        return $blogPost;
    }

    public function publish(BlogPost $blogPost): BlogPost
    {
        $blogPost->update([
            'is_published' => true,
            'published_at' => now(),
        ]);

        event(new BlogPostPublished($blogPost));

        return $blogPost;
    }

    public function unpublish(BlogPost $blogPost): BlogPost
    {
        $blogPost->update([
            'is_published' => false,
            'published_at' => null,
        ]);

        return $blogPost;
    }

    public function getPublishedPosts(int $perPage = 9)
    {
        return BlogPost::published()
            ->with(['category', 'author', 'tags'])
            ->orderByDesc('published_at')
            ->paginate($perPage);
    }

    public function getPostsByCategory(string $slug, int $perPage = 9)
    {
        return BlogPost::published()
            ->whereHas('category', fn ($q) => $q->where('slug', $slug))
            ->with(['category', 'author', 'tags'])
            ->orderByDesc('published_at')
            ->paginate($perPage);
    }

    public function getRelatedPosts(BlogPost $post, int $limit = 3)
    {
        return BlogPost::published()
            ->where('id', '!=', $post->id)
            ->where('blog_category_id', $post->blog_category_id)
            ->limit($limit)
            ->get();
    }
}
