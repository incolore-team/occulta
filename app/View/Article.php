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

class Article
{
    /**
     * @api {get} /archive/@uuid 欢迎界面
     * @apiName Welcome
     * @apiGroup Welcome
     */
    public function index($uuid)
    {
        $raw = ServiceContent::getByUUID($uuid);
        if (!$raw) {
            throw new BadRequestException("Not found", 404, 404);
        }
        $content = Factory::CreateContent($raw);
        Service::getDispatcher()->handle("article", array_merge(
            Service::getSharedData(),
            [
                "article" => $content
            ]
        ));
    }
}
