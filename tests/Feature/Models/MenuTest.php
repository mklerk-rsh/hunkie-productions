<?php

namespace Tests\Feature\Models;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_has_many_menu_items()
    {
        $menu = Menu::factory()->create();
        MenuItem::factory()->count(3)->create(['menu_id' => $menu->id]);

        $this->assertCount(3, $menu->menuItems);
        $this->assertInstanceOf(MenuItem::class, $menu->menuItems->first());
    }

    public function test_menu_item_belongs_to_parent()
    {
        $menu = Menu::factory()->create();
        $parent = MenuItem::factory()->create(['menu_id' => $menu->id]);
        $child = MenuItem::factory()->create(['menu_id' => $menu->id, 'parent_id' => $parent->id]);

        $this->assertEquals($parent->id, $child->parent->id);
        $this->assertTrue($parent->children->contains($child));
    }

    public function test_active_menu_items_scope()
    {
        $menu = Menu::factory()->create();
        MenuItem::factory()->create(['menu_id' => $menu->id, 'is_active' => true]);
        MenuItem::factory()->create(['menu_id' => $menu->id, 'is_active' => false]);

        $this->assertEquals(1, $menu->activeMenuItems->count());
    }
}
