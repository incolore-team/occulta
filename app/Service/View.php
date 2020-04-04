<?php

namespace App\Service;

use App\Util\View as UtilView;
use \Core;
use Core\Middleware\PermissionFilter;
use flight\util\Collection;

class View
{
    private static $dispatcher = null;
    private static $defaultDispatcher = null;
    /**
     * 获取调配器
     *
     * @return void
     */
    public static function getDispatcher()
    {
        if (self::$dispatcher) return self::$dispatcher;

        $type = "Dispatcher";
        require_once(self::getThemeDir()  . "/$type.php");
        $namespace = self::getThemeInfo(self::getThemeDir())['namespace'];
        $type = "$namespace\\$type";

        $dispatcher = new $type;
        $dispatcher->init();
        self::$dispatcher = $dispatcher;
        return $dispatcher;
    }
    public static function getDefaultDispatcher()
    {
        if (self::$defaultDispatcher) return self::$defaultDispatcher;
        $type = "Dispatcher";
        require_once(self::getDefaultThemeDir()  . "/$type.php");
        $namespace = self::getThemeInfo(self::getDefaultThemeDir())['namespace'];
        $type = "$namespace\\$type";
        $dispatcher = new $type;
        $dispatcher->init();
        self::$defaultDispatcher = $dispatcher;
        return $dispatcher;
    }
    public static function getThemeInfo($themeDir)
    {
        $filename = $themeDir  . "/Dispatcher.php";
        $file = fopen($filename, "r");
        $ret = [];

        while ($line = fgets($file)) {
            $line = ltrim($line, " \t/*");
            $props = ['@package', '@link', '@author', 'namespace', '@email', '@cover', '@version'];
            foreach ($props as  $value) {
                if (starts_with($line, $value)) {
                    $ret[$value] = trim(substr($line, strlen($value)), " \t\n\r;");
                    if ($value == "@email") {
                        $ret["avatar"] = Option::get("site.avatar") . md5($ret[$value]);
                    }
                }
            }
            if (count($ret) == count($props)) {
                fclose($file);
                return $ret;
            }
        }
        fclose($file);
        return $ret;
    }
    /**
     * 获取当前主题的绝对路径
     *
     * @return string
     */
    public static function getThemeDir()
    {
        $themeDir = SYSTEM_USER_THEMES . "/" . Option::get("site.theme");
        return $themeDir;
    }
    /**
     * 获取默认主题绝对路径
     *
     * @return string
     */
    public static function getDefaultThemeDir()
    {
        $themeDir = SYSTEM_USER_THEMES . "/default";
        return $themeDir;
    }
    /**
     * 获取共享在所有模板之间的数据
     *
     * @return array
     */
    public static function getSharedData()
    {
        $site = Site::info();
        $user = PermissionFilter::$currentUser ? PermissionFilter::$currentUser : null;
        if ($user) $user["avatar"] = "https://sdn.geekzu.org/avatar/" . md5($user["email"]);
        $categories = Field::listMeta("category");
        foreach ($categories as &$category) {
            $category['name'] = $category['option'];
            $category = new Collection($category);
        }

        $tags = Field::listMeta("tag");
        foreach ($tags as &$tag) {
            $tag['name'] = $tag['option'];
            $tag = new Collection($tag);
        }
        return [
            "site" => new Collection($site),
            "meta" => new Collection([
                'categories' => $categories,
                'tags' => $tags
            ]),
            "user" => $user ? new Collection($user) : null,
            "util" => new UtilView(),
        ];
    }
}
