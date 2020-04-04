<?php

define('SYSTEM_DEBUG',true);
define('SYSTEM_ROOT', realpath(__DIR__ . '/../'));
define('SYSTEM_APP', realpath(__DIR__ . '/../app'));
define('SYSTEM_CORE', realpath(__DIR__ . '/../core'));
define('SYSTEM_PUBLIC', realpath(__DIR__ . '/../public'));
define('SYSTEM_USER_THEMES', realpath(__DIR__ . '/../usr/themes'));
define('SYSTEM_USER_PLUGINS', realpath(__DIR__ . '/../usr/plugins'));
define('SYSTEM_USER_UPLOADS', realpath(__DIR__ . '/../usr/uploads'));
define('SYSTEM_USER_DATABASE', realpath(__DIR__ . '/../usr/data.sqlite'));


if (SYSTEM_DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}