<?php

namespace App\Services;

use App\Models\Menu;

class MenuService
{
    public function getMenu(string $handle)
    {
        return Menu::where('handle', $handle)
            ->with(['activeMenuItems' => function ($query) {
                $query->whereNull('parent_id')->with('children');
            }])
            ->first();
    }

    public function renderMenu(string $handle): array
    {
        $menu = $this->getMenu($handle);

        if (! $menu) {
            return [];
        }

        return $menu->activeMenuItems->toArray();
    }

    public function getAllMenus()
    {
        return Menu::withCount('menuItems')->get();
    }
}
