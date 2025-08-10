<?php

namespace App\Services;

use App\Models\Admin\Visitor;
use Jenssegers\Agent\Agent;

class VisitorService
{
    /**
     * Get user information based on IP and User-Agent.
     *
     * @param string $ip
     * @param string $userAgent
     * @param object $resume
     * @return array
     */
    public function getUserInfo($ip, $userAgent, $dynamicFieldId, $dynamicFieldName = 'resume_id')
    {
        // Get location data using ipinfo.io
        $locationData = file_get_contents("http://ipinfo.io/{$ip}/json");
        $userLocation = json_decode($locationData);

        // Get browser, platform, and device details
        $agent = new Agent();
        $agent->setUserAgent($userAgent);
        $browser = $agent->browser();
        $platform = $agent->platform();
        $device = $agent->device();

        // Prepare user information array
        $userInfo = [
            $dynamicFieldName => $dynamicFieldId,
            'ip' => $userLocation->ip,
            'browser' => $browser,
            'platform' => $platform,
            'device' => $device,
            'hostname' => $userLocation->hostname ?? 'Unknown',
            'city' => $userLocation->city ?? 'Unknown',
            'region' => $userLocation->region ?? 'Unknown',
            'country' => $userLocation->country ?? 'Unknown',
            'loc' => $userLocation->loc ?? 'Unknown',
            'org' => $userLocation->org ?? 'Unknown',
            'postal' => $userLocation->postal ?? 'Unknown',
            'timezone' => $userLocation->timezone ?? 'Unknown',
        ];

        return $userInfo;
    }


    /**
     * Save visitor information in the database.
     *
     * @param array $userInfo
     * @return void
     */
    public function saveVisitorInfo(array $userInfo, string $dynamicFieldName = 'resume_id')
    {
        Visitor::firstOrCreate(
            [
                'ip' => $userInfo['ip'],
                $dynamicFieldName => $userInfo[$dynamicFieldName]
            ],
            $userInfo
        );
    }
}
