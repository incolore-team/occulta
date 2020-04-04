<?php

namespace App\Service;

use \Core;
use Core\Middleware\PermissionFilter;
use flight\util\Collection;

class Theme
{
    public static function listThemes()
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