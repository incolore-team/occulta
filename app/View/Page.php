<?php

namespace App\View;

use App\Model\Factory;
use App\Service\Content as ServiceContent;
use App\Service\Option;
use App\Service\Site;
use App\Service\View as Service;
use Core;
use Core\Type\Exception\BadRequestException;
use flight\util\Collection;

class Page
{
    /**
     * @api {get} /@slug:.*\.html 欢迎界面
     * @apiName Welcome
     * @apiGroup Welcome
     */
    public function index($slug)
    {
        $slug = substr($slug, 0, strlen($slug) - strlen(".html"));

        $raw = ServiceContent::getBySlug($slug);
        if (!$raw) {
            throw new BadRequestException("Not found", 404, 404);
        }
        $content = Factory::CreateContent($raw);
        Service::getDispatcher()->handle("page", array_merge(
            Service::getSharedData(),
            [
                "page" => $content
            ]
        ));
    }
}
