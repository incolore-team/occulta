<?php

namespace App\View\Admin;

use App\Model\Factory;
use App\Service\Content;
use App\Service\Option;
use App\Service\Site;
use App\Service\View as Service;
use App\Service\View;
use Core;
use Core\Helper\Cookie;
use Core\Type\Exception\BadRequestException;
use flight\util\Collection;

class Page
{
    /**
     * @api {get} /admin/page/write(/@id) 写文章
     * @apiPermission admin.page.write
     * @apiName Write page
     * @apiGroup Admin
     */
    public function write($id = null)
    {
        if($id!=null){
            $raw = Content::get($id);
            if (!$raw) {
                throw new BadRequestException("Not found", 404, 404);
            }
            $content = Factory::CreateContent($raw);
            Service::getDispatcher()->handle("admin/page/write", array_merge(View::getSharedData(),[
                'page' => $content
            ]));
        }else{
            Service::getDispatcher()->handle("admin/page/write", array_merge(View::getSharedData(),[
                'page' => null
            ]));
        }
    }
    /**
     * @api {get} /admin/page/manage 管理文章
     * @apiPermission admin.page.manage
     * @apiName Mange pages
     * @apiGroup Admin
     */
    public function manage($page = null, $perpage = null)
    {
        if (is_null($page)) $page = 1;
        if (is_null($perpage)) $perpage = 10;
        $pages = new Collection(Content::list("page", $page, $perpage));
        $total = $pages->total;
        $rows = $pages->data;

        $contents = [];
        foreach ($rows as &$row) {
            $contents[] =  Factory::CreateContent($row, true);
        }
        Service::getDispatcher()->handle("admin/page/manage", array_merge(
            Service::getSharedData(),
            [
                "pages" => $contents,
                "page" => $page,
                "perpage" => $perpage,
                "total" => $total,
            ]
        ));
    }
    /**
     * @api {get} /admin/page/manage/page/@page 管理文章（分页）
     * @apiName Welcome
     * @apiGroup Welcome
     */
    public function managePage($page)
    {
        $this->manage($page);
    }
}
