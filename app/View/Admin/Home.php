<?php

namespace App\View\Admin;

use App\Service\Option;
use App\Service\Site;
use App\Service\View as Service;
use App\Service\View;
use Core;
use Core\Helper\Cookie;
use flight\util\Collection;

class Home
{
    /**
     * @api {get} /admin(/@page) 欢迎界面
     * @apiPermission admin.home.index
     * @apiName Welcome
     * @apiGroup Welcome
     */
    public function index($page = 1)
    {
        
        $site = Site::info();
        Service::getDispatcher()->handle("admin/home", View::getSharedData());
    }
}
