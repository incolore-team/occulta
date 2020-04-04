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

class Article
{
    /**
     * @api {get} /admin/article/write(/@id) 写文章
     * @apiPermission admin.article.write
     * @apiName Write Article
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
            Service::getDispatcher()->handle("admin/article/write", array_merge(View::getSharedData(),[
                'article' => $content
            ]));
        }else{
            Service::getDispatcher()->handle("admin/article/write", array_merge(View::getSharedData(),[
                'article' => null
            ]));
        }
    }
    /**
     * @api {get} /admin/article/manage 管理文章
     * @apiPermission admin.article.manage
     * @apiName Mange Articles
     * @apiGroup Admin
     */
    public function manage($page = null, $perpage = null)
    {
        if (is_null($page)) $page = 1;
        if (is_null($perpage)) $perpage = 10;
        $articles = new Collection(Content::list("article", $page, $perpage));
        $total = $articles->total;
        $rows = $articles->data;

        $contents = [];
        foreach ($rows as &$row) {
            $contents[] =  Factory::CreateContent($row, true);
        }
        Service::getDispatcher()->handle("admin/article/manage", array_merge(
            Service::getSharedData(),
            [
                "articles" => $contents,
                "page" => $page,
                "perpage" => $perpage,
                "total" => $total,
            ]
        ));
    }
    /**
     * @api {get} /admin/article/manage/page/@page 管理文章（分页）
     * @apiName Welcome
     * @apiGroup Welcome
     */
    public function managePage($page)
    {
        $this->manage($page);
    }
}
