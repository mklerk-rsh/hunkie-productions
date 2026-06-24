<?php

namespace App\Services\Contracts;

interface GeolocationService
{
    public function locate(string $ip): ?array;
}
