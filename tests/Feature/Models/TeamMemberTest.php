<?php

namespace Tests\Feature\Models;

use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamMemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_scope()
    {
        TeamMember::factory()->create(['is_active' => true]);
        TeamMember::factory()->inactive()->create();

        $this->assertEquals(1, TeamMember::active()->count());
    }

    public function test_ordered_scope()
    {
        TeamMember::factory()->create(['display_order' => 2]);
        TeamMember::factory()->create(['display_order' => 0]);
        TeamMember::factory()->create(['display_order' => 1]);

        $ordered = TeamMember::ordered()->get();
        $this->assertEquals(0, $ordered->first()->display_order);
    }

    public function test_social_links_is_array()
    {
        $member = TeamMember::factory()->create();

        $this->assertIsArray($member->social_links);
        $this->assertArrayHasKey('instagram', $member->social_links);
    }
}
