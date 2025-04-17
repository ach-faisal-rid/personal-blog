<?php

use Modules\Bookmarking\Helpers\BookmarkHelper;

if (! function_exists('fetch_bookmark_title')) {
    function fetch_bookmark_title($url)
    {
        return BookmarkHelper::fetchTitle($url);
    }
}
