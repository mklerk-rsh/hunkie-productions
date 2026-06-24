<?php

namespace App\Services;

use App\Services\Contracts\GeolocationService;
use Illuminate\Support\Facades\Http;

class IpApiGeolocationService implements GeolocationService
{
    public function locate(string $ip): ?array
    {
        if ($this->isPrivateIp($ip)) {
            return null;
        }

        try {
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}");

            if ($response->successful() && $response->json('status') === 'success') {
                return [
                    'latitude' => (float) $response->json('lat'),
                    'longitude' => (float) $response->json('lon'),
                    'city' => $response->json('city'),
                    'country' => $response->json('country'),
                    'isp' => $response->json('isp'),
                ];
            }
        } catch (\Exception) {
        }

        return null;
    }

    private function isPrivateIp(string $ip): bool
    {
        $filtered = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);

        return $filtered === false;
    }
}
