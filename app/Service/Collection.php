<?php

namespace App\Service;

use \Core;
use Core\Middleware\PermissionFilter;
class Collection
{
    public static function list()
    {
        $themes = [];
        $dirs = array_filter(glob(SYSTEM_USER_THEMES.'/*'), 'is_dir');
        foreach($dirs as $dir){
            if(is_file($dir . "/Dispatcher.php")){
                $themes[] = View::getThemeInfo($dir);
            }
        }
        return $themes;
    }
}