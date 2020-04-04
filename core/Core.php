<?php

use App\Service\Option;

/**
 * Core 静态类
 * 
 * @author ZhangZijing <i@pluvet.com>
 * 
 */
class Core
{
    /**
     * @var \Medoo\Medoo
     */
    public static $db;
    /**
     * @var \Flight
     */
    public static $api;
    /**
     * @var \League\Plates\Engine
     */
    public static $view;
    /**
     * Config
     *
     * @var \Core\Helper\FileConfig
     */
    public static $config;

    /**
     * Permission Inspector Midddleware
     *
     * @var \Core\Middleware\IMiddleware[]
     */
    public static $middlewares;

    public static function init()
    {


        date_default_timezone_set('Asia/Shanghai');
        Core::$middlewares[] = new \Core\Middleware\CORSHandler();
        Core::$middlewares[] = new \Core\Middleware\RequestDataMapper();
        Core::$middlewares[] = new \Core\Middleware\PermissionFilter();
        Core::$middlewares[] = new \Core\Middleware\ExceptionHandler();
        Core::$api = \Flight::app();
        Core::$config = new \Core\Helper\FileConfig(SYSTEM_APP . "/common/config");
        Core::$db = new Medoo\Medoo(@include(SYSTEM_APP . "/common/config/db.php"));
        Core::$api->set('flight.base_url', rtrim(Option::get("site.url"), "/"));
        require_once SYSTEM_APP . "/common/route.php";
    }

    public static function start()
    {
        foreach (self::$middlewares as $middleware) {
            $middleware->init();
        }
        require_once SYSTEM_APP . "/di.php";

        self::$api->start();
        
    }

    public static function getMiddleware($className)
    {
        foreach (self::$middlewares as $middleware) {
            if (get_class($middleware) === $className) {
                return $middleware;
            }
        }
        return NULL;
    }
}
