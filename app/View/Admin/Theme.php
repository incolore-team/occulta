<?php

namespace App\View\Admin;

use App\Service\Field as ServiceField;
use App\Service\Option;
use App\Service\Site;
use App\Service\Theme as ServiceTheme;
use App\Service\View;
use Core;
use Core\Helper\Cookie;
use flight\util\Collection;

class Theme
{
    /**
     * @api {get} /admin/theme/manage 管理主题
     * @apiPermission admin.theme.manage
     * @apiName Mange Articles
     * @apiGroup Admin
     */
    public function manage($page = null, $perpage = null)
    {
        $themes = ServiceTheme::listThemes();
        View::getDispatcher()->handle("admin/theme/manage", array_merge(View::getSharedData(), [
            "themes" => $themes
        ]));
    }
}
