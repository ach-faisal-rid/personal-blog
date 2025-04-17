<?php

namespace Modules\Bookmarking\Helpers;

class BookmarkHelper
{
    public static function fetchTitle($url) {
        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: Mozilla/5.0\r\n"
            ]
        ]);

        $html = @file_get_contents($url, false, $context);

        if ($html) {
            preg_match("/<title>(.*?)<\/title>/i", $html, $matches);
            return $matches[1] ?? null;
        }

        return null;
    }
}
