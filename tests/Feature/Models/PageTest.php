<?php

namespace Tests\Feature\Models;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_scope()
    {
        Page::factory()->create(['is_published' => true]);
        Page::factory()->create(['is_published' => false]);

        $this->assertEquals(1, Page::published()->count());
    }

    public function test_page_has_seo()
    {
        $page = Page::factory()->create();
        $page->seoMetadata()->create([
            'meta_title' => 'Page SEO',
        ]);

        $this->assertNotNull($page->seoMetadata);
    }
}
