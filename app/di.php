<?php

use App\Service\Option;
use App\Service\TemplateExtension;

$themeDir = SYSTEM_USER_THEMES . "/" . Option::get("site.theme");
Core::$view = \League\Plates\Engine::create($themeDir, 'php');
Core::$view->register(new TemplateExtension());

