<?php

namespace App\View\Admin;

use App\Service\Option;
use App\Service\Site;
use App\Service\View;
use Core;
use Core\Helper\Cookie;

class Collection
{
    /**
     * @api {get} /admin/collection/manage 管理文章
     * @apiPermission admin.collection.manage
     * @apiName Mange Articles
     * @apiGroup Admin
     */
    public function manage($page = null, $perpage = null)
    {
        View::getDispatcher()->handle("admin/collection/manage", array_merge(View::getSharedData(), [
        //    "collections" => $metasRaw,
        ]));
    }
}
