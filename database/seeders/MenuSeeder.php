<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $mainMenu = Menu::create([
            'name' => 'Main Navigation',
            'handle' => 'main_navigation',
            'description' => 'Primary website navigation menu.',
        ]);

        $items = [
            ['title' => 'Home', 'url' => '/', 'display_order' => 0],
            ['title' => 'Portfolio', 'url' => '/portfolio', 'display_order' => 1],
            ['title' => 'Services', 'url' => '/services', 'display_order' => 2],
            ['title' => 'About', 'url' => '/about', 'display_order' => 3],
            ['title' => 'Blog', 'url' => '/blog', 'display_order' => 4],
            ['title' => 'Contact', 'url' => '/contact', 'display_order' => 5],
        ];

        foreach ($items as $item) {
            MenuItem::create(array_merge($item, [
                'menu_id' => $mainMenu->id,
                'target' => '_self',
                'is_active' => true,
            ]));
        }

        $footerMenu = Menu::create([
            'name' => 'Footer Menu',
            'handle' => 'footer_menu',
            'description' => 'Footer navigation links.',
        ]);

        $footerItems = [
            ['title' => 'About Us', 'url' => '/about', 'display_order' => 0],
            ['title' => 'Privacy Policy', 'url' => '/privacy', 'display_order' => 1],
            ['title' => 'Terms of Service', 'url' => '/terms', 'display_order' => 2],
            ['title' => 'Contact', 'url' => '/contact', 'display_order' => 3],
        ];

        foreach ($footerItems as $item) {
            MenuItem::create(array_merge($item, [
                'menu_id' => $footerMenu->id,
                'target' => '_self',
                'is_active' => true,
            ]));
        }
    }
}
