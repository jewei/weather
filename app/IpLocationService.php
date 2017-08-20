<?php

namespace App;

use Exception;

class IpLocationService {

    public function handle($ip_address) {

        if (! filter_var($ip_address, FILTER_VALIDATE_IP)) {
            throw new Exception('Invalid IP address');
        }

        if (! filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            throw new Exception('IPv4 support only');
        }

        $location = IpLocation::where('ip_to', '<=', ip2long($ip_address))
            ->orderBy('ip_to', 'desc')
            ->first();

        $url = sprintf(
            'https://api.darksky.net/forecast/%s/%s,%s?exclude=hourly,daily,flags&units=auto',
            config('services.darksky.secret'),
            $location->latitude,
            $location->longitude
        );

        $response = app(\GuzzleHttp\Client::class)->request('GET', $url);

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Error calling api service');
        }

        $data = json_decode($response->getBody(), true);

        return $data;
    }
}
