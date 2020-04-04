<?php

namespace App\View;

use App\Service\Option;
use App\Service\Site;
use App\Service\View as Service;
use App\Service\View;
use Core;
use flight\util\Collection;

class Resource
{
    /**
     * @api {get} /assets/* 欢迎界面
     * @apiName Welcome
     * @apiGroup Welcome
     */
    public function index()
    {        
        
     
        $route = Core::$api->router()->current();
        $location = View::getThemeDir() . "/" . $route->splat;
        // 去除 url 中的 ?=xxx 参数
        $location = preg_replace('/\?.*/', '', $location);
        if (!is_file($location)) {
            $location = View::getDefaultThemeDir() . "/" . $route->splat;
            $location = preg_replace('/\?.*/', '', $location);
        }        
        self::sendfile($location);
    }
    private static function sendfile($location)
    {
        if (!is_file($location)) {
            header("HTTP/1.0 404 Not Found");
            if (SYSTEM_DEBUG) {
                echo "not found:" . $location;
            }
            return;
        }
        
        $time = date('r', filemtime($location));

        header("Last-Modified: $time");
        header('Connection: close');
        header('Content-Type: ' . get_mime_by_extension(extension($location)));
        header('Content-Length: ' . filesize($location));

        readfile($location);
        die();
    }
}
