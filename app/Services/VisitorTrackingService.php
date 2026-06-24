<?php

namespace App\Services;

use App\Enums\LeadSource;
use App\Enums\LeadStatus;
use App\Models\Lead;
use App\Models\PageActivity;
use App\Services\Contracts\GeolocationService;
use Illuminate\Http\Request;

class VisitorTrackingService
{
    public function __construct(
        private readonly GeolocationService $geolocation,
    ) {}

    public function identifyOrCreate(Request $request): Lead
    {
        $sessionId = $request->input('session_id');

        if ($sessionId) {
            $lead = Lead::where('session_id', $sessionId)->first();
            if ($lead) {
                return $this->updateExisting($lead, $request);
            }
        }

        return $this->createFromVisitor($request, $sessionId);
    }

    public function recordPageActivity(Lead $lead, array $data): PageActivity
    {
        $activity = $lead->pageActivities()->create([
            'url' => $data['url'] ?? request()->path(),
            'page_title' => $data['page_title'] ?? null,
            'action_type' => $data['action_type'] ?? 'page_view',
            'metadata' => $data['metadata'] ?? null,
        ]);

        $lead->increment('page_views_count');

        return $activity;
    }

    public function heartbeat(Lead $lead, int $additionalSeconds): Lead
    {
        $lead->increment('time_spent_seconds', $additionalSeconds);

        return $lead->fresh();
    }

    public function associateContact(Lead $lead, array $contactData): Lead
    {
        $lead->update([
            'name' => $contactData['name'] ?? $lead->name,
            'email' => $contactData['email'] ?? $lead->email,
            'phone' => $contactData['phone'] ?? $lead->phone,
            'company' => $contactData['company'] ?? $lead->company,
            'message' => $contactData['message'] ?? $lead->message,
            'service_interest' => $contactData['service_interest'] ?? $lead->service_interest,
            'source' => $contactData['source'] ?? $lead->source,
        ]);

        return $lead->fresh();
    }

    private function createFromVisitor(Request $request, ?string $sessionId): Lead
    {
        $ip = $request->ip();
        $geoData = $this->geolocation->locate($ip);
        $referrer = $request->input('referrer_url', $request->header('referer'));
        $userAgent = $request->header('User-Agent');
        $deviceInfo = $this->parseUserAgent($userAgent ?? '');

        $source = LeadSource::fromReferrer($referrer);

        $lead = Lead::create([
            'name' => null,
            'email' => null,
            'phone' => null,
            'company' => null,
            'message' => null,
            'service_interest' => null,
            'source' => $source->value,
            'utm_source' => $request->input('utm_source'),
            'utm_medium' => $request->input('utm_medium'),
            'utm_campaign' => $request->input('utm_campaign'),
            'status' => LeadStatus::New->value,
            'lead_score' => 0,
            'assigned_to' => null,
            'notes' => null,
            'ip_address' => $ip,
            'latitude' => $geoData['latitude'] ?? null,
            'longitude' => $geoData['longitude'] ?? null,
            'user_agent' => $userAgent,
            'referrer_url' => $referrer,
            'landing_page' => $request->input('landing_page', '/'),
            'time_spent_seconds' => 0,
            'page_views_count' => 0,
            'device_type' => $deviceInfo['device_type'] ?? null,
            'browser' => $deviceInfo['browser'] ?? null,
            'os' => $deviceInfo['os'] ?? null,
            'session_id' => $sessionId ?? (string) str()->uuid(),
        ]);

        return $lead;
    }

    private function updateExisting(Lead $lead, Request $request): Lead
    {
        $referrer = $request->input('referrer_url', $request->header('referer'));
        $userAgent = $request->header('User-Agent');
        $deviceInfo = $this->parseUserAgent($userAgent ?? '');

        if ($referrer && ! $lead->referrer_url) {
            $lead->referrer_url = $referrer;
        }

        if ($userAgent && ! $lead->user_agent) {
            $lead->user_agent = $userAgent;
        }

        if (! $lead->device_type && isset($deviceInfo['device_type'])) {
            $lead->device_type = $deviceInfo['device_type'];
        }

        if (! $lead->browser && isset($deviceInfo['browser'])) {
            $lead->browser = $deviceInfo['browser'];
        }

        if (! $lead->os && isset($deviceInfo['os'])) {
            $lead->os = $deviceInfo['os'];
        }

        $lead->ip_address = $request->ip();

        if (! $lead->latitude && ! $lead->longitude) {
            $geoData = $this->geolocation->locate($request->ip());
            if ($geoData) {
                $lead->latitude = $geoData['latitude'];
                $lead->longitude = $geoData['longitude'];
            }
        }

        $lead->save();

        return $lead;
    }

    private function parseUserAgent(string $ua): array
    {
        $browser = 'Unknown';
        $os = 'Unknown';
        $deviceType = 'desktop';

        if (preg_match('/Chrome\/(\d+)/', $ua)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Firefox\/(\d+)/', $ua)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Safari\/(\d+)/', $ua) && ! preg_match('/Chrome/', $ua)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edg\/(\d+)/', $ua)) {
            $browser = 'Edge';
        } elseif (preg_match('/MSIE|Trident/', $ua)) {
            $browser = 'Internet Explorer';
        }

        if (preg_match('/Windows NT/', $ua)) {
            $os = 'Windows';
        } elseif (preg_match('/Mac OS X/', $ua)) {
            $os = 'macOS';
        } elseif (preg_match('/Linux/', $ua) && ! preg_match('/Android/', $ua)) {
            $os = 'Linux';
        } elseif (preg_match('/Android/', $ua)) {
            $os = 'Android';
            $deviceType = 'mobile';
        } elseif (preg_match('/iPhone|iPad/', $ua)) {
            $os = preg_match('/iPad/', $ua) ? 'iOS' : 'iOS';
            $deviceType = preg_match('/iPad/', $ua) ? 'tablet' : 'mobile';
        }

        if (preg_match('/Tablet|iPad/', $ua)) {
            $deviceType = 'tablet';
        } elseif (preg_match('/Mobile/', $ua)) {
            $deviceType = 'mobile';
        }

        return [
            'browser' => $browser,
            'os' => $os,
            'device_type' => $deviceType,
        ];
    }
}
