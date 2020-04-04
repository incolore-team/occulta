<?php

namespace App\Service;

use Dispatcher;
use flight\util\Collection;

class Site
{

    /**
     * 获取站点基础信息
     *
     * @return array
     */
    public static function info()
    {
        return [
            'name' => Option::get("site.name"),
            'url' => Option::get("site.url"),
            'description' => Option::get("site.description"),
        ];
    }
    /**
     * 获取站点链接
     *
     * @param string $append 追加在尾部的字符串
     * @return string
     */
    public static function url($append = '')
    {
        return rtrim(Option::get("site.url"), "/") . "/" . $append;
    }
}
