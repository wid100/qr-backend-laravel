<?php

namespace App\Support;

use App\Models\Qrgen;
use Illuminate\Http\Request;

class SocialLinksHelper
{
    public const LEGACY_KEYS = [
        'facebook', 'twitter', 'instagram', 'youtube', 'github', 'behance', 'linkedin',
        'spotify', 'tumblr', 'telegram', 'pinterest', 'snapchat', 'reddit', 'google',
        'apple', 'figma', 'discord', 'tiktok', 'whatsapp', 'skype', 'google_scholar',
        'medium', 'wechat',
    ];

    public static function hydrateQrgen(Qrgen $qrgen, Request $request): void
    {
        if (! $request->filled('social_links')) {
            return;
        }

        $raw = $request->input('social_links');
        $links = is_string($raw) ? json_decode($raw, true) : $raw;

        if (! is_array($links)) {
            return;
        }

        $normalized = [];

        foreach ($links as $link) {
            $url = trim((string) ($link['url'] ?? ''));
            if ($url === '') {
                continue;
            }

            $platform = strtolower((string) ($link['platform'] ?? ''));

            $normalized[] = [
                'id' => (string) ($link['id'] ?? uniqid('sl_', true)),
                'platform' => $platform,
                'url' => $url,
                'label' => trim((string) ($link['label'] ?? '')),
            ];

            if ($platform !== '' && empty($qrgen->{$platform})) {
                $qrgen->{$platform} = $url;
            }
        }

        $qrgen->social_links = $normalized;
    }
}
