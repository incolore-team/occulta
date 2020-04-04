<?php

namespace App\View\Admin;

use App\Service\Field as ServiceField;
use App\Service\Option;
use App\Service\Site;
use App\Service\View;
use Core;
use Core\Helper\Cookie;
use flight\util\Collection;

class Field
{
    /**
     * @api {get} /admin/field/manage 管理文章
     * @apiPermission admin.article.manage
     * @apiName Mange Articles
     * @apiGroup Admin
     */
    public function manage($page = null, $perpage = null)
    {
        $metasRaw = ServiceField::listMeta();
        $metas = [];
        foreach ($metasRaw as $value) {
            if (!array_key_exists($value["name"], $metas)) {
                $metas[$value["name"]] = [
                    "displayName"=>null,
                    "items"=>[]
                ];
            }
            $metas[$value["name"]]["items"][] = $value;
            if($value["displayName"]){
                $metas[$value["name"]]["displayName"] = $value["displayName"];
            }
        }
        View::getDispatcher()->handle("admin/field/manage", array_merge(View::getSharedData(), [
            "metasRaw" => $metasRaw,
            "metas" => $metas
        ]));
    }
}
