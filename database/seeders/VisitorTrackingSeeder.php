<?php

namespace Database\Seeders;

use App\Enums\LeadSource;
use App\Enums\LeadStatus;
use App\Models\Lead;
use Illuminate\Database\Seeder;

class VisitorTrackingSeeder extends Seeder
{
    private array $countries = [
        ['lat' => 40.7128, 'lng' => -74.0060, 'city' => 'New York'],
        ['lat' => 34.0522, 'lng' => -118.2437, 'city' => 'Los Angeles'],
        ['lat' => 41.8781, 'lng' => -87.6298, 'city' => 'Chicago'],
        ['lat' => 29.7604, 'lng' => -95.3698, 'city' => 'Houston'],
        ['lat' => 33.4484, 'lng' => -112.0740, 'city' => 'Phoenix'],
        ['lat' => 51.5074, 'lng' => -0.1278, 'city' => 'London'],
        ['lat' => 48.8566, 'lng' => 2.3522, 'city' => 'Paris'],
        ['lat' => 52.5200, 'lng' => 13.4050, 'city' => 'Berlin'],
        ['lat' => 35.6762, 'lng' => 139.6503, 'city' => 'Tokyo'],
        ['lat' => -33.8688, 'lng' => 151.2093, 'city' => 'Sydney'],
    ];

    private array $referrers = [
        null,
        'https://www.google.com/search?q=video+production',
        'https://www.google.com/search?q=hunkie+productions',
        'https://www.googleadservices.com/pagead/aclk?ad=456',
        'https://www.facebook.com/some-business-page',
        'https://www.instagram.com/p/CxYZ123/',
        'https://www.linkedin.com/feed/',
        'https://twitter.com/someuser/status/123456',
        'https://www.youtube.com/watch?v=abc123',
        'https://random-blog.com/article',
    ];

    private array $userAgents = [
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/119.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 Safari/605.1.15',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0',
        'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36',
        'Mozilla/5.0 (iPhone; CPU iPhone OS 17_2 like Mac OS X) AppleWebKit/605.1.15 Mobile/15E148',
        'Mozilla/5.0 (iPad; CPU OS 17_2 like Mac OS X) AppleWebKit/605.1.15 Mobile/15E148',
        'Mozilla/5.0 (Linux; Android 14; Pixel 8) AppleWebKit/537.36 Chrome/120.0.0.0 Mobile Safari/537.36',
        'Mozilla/5.0 (Linux; Android 13; Samsung Galaxy S23) AppleWebKit/537.36 Chrome/119.0.0.0 Mobile Safari/537.36',
    ];

    private array $landingPages = [
        '/', '/about', '/services', '/portfolio', '/contact',
        '/services/film-production', '/services/video-editing',
        '/portfolio/project-1', '/blog', '/blog/video-production-tips',
    ];

    public function run(): void
    {
        $totalDays = 30;
        $avgVisitorsPerDay = 15;

        for ($day = 0; $day < $totalDays; $day++) {
            $date = now()->subDays($totalDays - $day)->startOfDay();
            $visitorCount = fake()->numberBetween(
                (int) ($avgVisitorsPerDay * 0.6),
                (int) ($avgVisitorsPerDay * 1.4),
            );

            for ($i = 0; $i < $visitorCount; $i++) {
                $this->createVisitor($date);
            }
        }

        // Create some identified leads mixed in
        $identifiedCount = 40;
        for ($i = 0; $i < $identifiedCount; $i++) {
            $this->createIdentifiedLead();
        }
    }

    private function createVisitor(\Carbon\Carbon $date): void
    {
        $geo = fake()->randomElement($this->countries);
        $referrer = fake()->randomElement($this->referrers);
        $ua = fake()->randomElement($this->userAgents);
        $pageViews = fake()->numberBetween(1, 12);
        $timeSpent = fake()->numberBetween(5, 900);

        $source = LeadSource::fromReferrer($referrer);

        $visitTime = $date->copy()->addMinutes(fake()->numberBetween(0, 1439));

        Lead::factory()->anonymous()->tracked()->create([
            'ip_address' => fake()->ipv4(),
            'latitude' => $geo['lat'] + fake()->randomFloat(3, -0.5, 0.5),
            'longitude' => $geo['lng'] + fake()->randomFloat(3, -0.5, 0.5),
            'user_agent' => $ua,
            'referrer_url' => $referrer,
            'landing_page' => fake()->randomElement($this->landingPages),
            'time_spent_seconds' => $timeSpent,
            'page_views_count' => $pageViews,
            'device_type' => str_contains($ua, 'iPhone') || str_contains($ua, 'Android') ? 'mobile' : (str_contains($ua, 'iPad') ? 'tablet' : 'desktop'),
            'browser' => str_contains($ua, 'Chrome') ? 'Chrome' : (str_contains($ua, 'Firefox') ? 'Firefox' : (str_contains($ua, 'Safari') ? 'Safari' : 'Edge')),
            'os' => str_contains($ua, 'Windows') ? 'Windows' : (str_contains($ua, 'Mac') ? 'macOS' : (str_contains($ua, 'Linux') ? 'Linux' : (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad') ? 'iOS' : 'Android'))),
            'source' => $source->value,
            'session_id' => fake()->uuid(),
            'created_at' => $visitTime,
            'updated_at' => $visitTime,
        ]);
    }

    private function createIdentifiedLead(): void
    {
        $geo = fake()->randomElement($this->countries);
        $ua = fake()->randomElement($this->userAgents);
        $pageViews = fake()->numberBetween(3, 25);
        $timeSpent = fake()->numberBetween(60, 1800);

        $lead = Lead::factory()->tracked()->create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company' => fake()->company(),
            'message' => fake()->paragraph(2),
            'service_interest' => fake()->randomElement([
                'Film Production', 'Video Editing', 'Animation', 'Photography',
            ]),
            'ip_address' => fake()->ipv4(),
            'latitude' => $geo['lat'] + fake()->randomFloat(3, -0.5, 0.5),
            'longitude' => $geo['lng'] + fake()->randomFloat(3, -0.5, 0.5),
            'user_agent' => $ua,
            'referrer_url' => fake()->randomElement($this->referrers),
            'landing_page' => '/contact',
            'time_spent_seconds' => $timeSpent,
            'page_views_count' => $pageViews,
            'device_type' => 'desktop',
            'browser' => 'Chrome',
            'os' => 'Windows',
            'source' => fake()->randomElement(['google_organic', 'direct', 'facebook', 'linkedin', 'referral']),
            'session_id' => fake()->uuid(),
            'status' => fake()->randomElement(['new', 'contacted', 'qualified']),
            'lead_score' => fake()->numberBetween(5, 40),
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ]);

        // Add some page activities for this lead
        $pages = ['/', '/about', '/services', '/portfolio', '/contact'];
        $visited = array_slice($pages, 0, fake()->numberBetween(1, 4));
        foreach ($visited as $page) {
            $lead->pageActivities()->create([
                'url' => $page,
                'page_title' => ucfirst(trim($page, '/')) ?: 'Home',
                'action_type' => 'page_view',
                'created_at' => $lead->created_at->addMinutes(fake()->numberBetween(1, 10)),
            ]);
        }
    }
}
