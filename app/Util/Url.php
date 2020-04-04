<?php

namespace App\Util;

use App\Service\Site;

class Url
{
    public static function search($page = 1)
    {
       return Site::url("search/page/$page");
    }
}