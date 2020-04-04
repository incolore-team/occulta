<?php

namespace App\View;

use App\Model\Factory;
use App\Service\Content;
use App\Service\Option;
use App\Service\Site;
use App\Service\View as Service;
use Core;
use flight\util\Collection;

class Home
{
    /**
     * @api {get} / 欢迎界面
     * @apiName Welcome
     * @apiGroup Welcome
     */
    public function index($page = null)
    {
        if (is_null($page)) $page = 1;
        $articles = new Collection(Content::list("article", $page));
        $total = $articles->total;
        $rows = $articles->data;

        $contents = [];
        foreach ($rows as &$row) {
            $contents[] =  Factory::CreateContent($row);
        }
        Service::getDispatcher()->handle("home", array_merge(
            Service::getSharedData(),
            [
                "articles" => $contents,
                "page" => $page,
                "perpage" => 5,
                "total" => $total,
            ]
        ));
    }
    /**
     * @api {get} /page/@page 欢迎界面
     * @apiName Welcome
     * @apiGroup Welcome
     */
    public function page($page)
    {
        $this->index($page);
    }


    /**
     * @api {get} /search 搜索
     * @apiName Welcome
     * @apiGroup Welcome
     * @apiParam {string{2..}} s
     */
    public function search($page = null)
    {
        if (is_null($page)) $page = 1;
        $req = Core::$api->request()->query;
        $str = trim($req->s);

        $articles = new Collection(Content::search("article", $str, $page));
        $total = $articles->total;
        $rows = $articles->data;

        $contents = [];
        foreach ($rows as &$row) {
            $contents[] =  Factory::CreateContent($row);
        }
        Service::getDispatcher()->handle("search", array_merge(
            Service::getSharedData(),
            [
                "str" => htmlspecialchars($str),
                "articles" => $contents,
                "page" => $page,
                "perpage" => 5,
                "total" => $total,
            ]
        ));
    }

    /**
     * @api {get} /search/page/@page 欢迎界面
     * @apiName Welcome
     * @apiGroup Welcome
     * @apiParam {string{2..}} s
     */
    public function searchPage($page)
    {
        $this->search($page);
    }
}
