<?php

namespace Tests\Feature\Models;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_post_belongs_to_category()
    {
        $category = BlogCategory::factory()->create();
        $post = BlogPost::factory()->create(['blog_category_id' => $category->id]);

        $this->assertInstanceOf(BlogCategory::class, $post->category);
        $this->assertEquals($category->id, $post->category->id);
    }

    public function test_blog_post_belongs_to_author()
    {
        $author = User::factory()->create();
        $post = BlogPost::factory()->create(['author_id' => $author->id]);

        $this->assertInstanceOf(User::class, $post->author);
        $this->assertEquals($author->id, $post->author->id);
    }

    public function test_blog_post_belongs_to_many_tags()
    {
        $post = BlogPost::factory()->create();
        $tags = Tag::factory()->count(3)->create();
        $post->tags()->attach($tags);

        $this->assertCount(3, $post->tags);
        $this->assertInstanceOf(Tag::class, $post->tags->first());
    }

    public function test_published_scope()
    {
        BlogPost::factory()->published()->create();
        BlogPost::factory()->create(['is_published' => false]);

        $this->assertEquals(1, BlogPost::published()->count());
    }

    public function test_blog_post_has_seo()
    {
        $post = BlogPost::factory()->published()->create();
        $post->seoMetadata()->create([
            'meta_title' => 'Blog SEO Title',
        ]);

        $this->assertNotNull($post->seoMetadata);
    }
}
