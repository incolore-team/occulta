<?php

namespace App\Api;

use Core;

class Content
{

    /**
     * @api {post} /api/content/ 欢迎界面
     *
     * @apiSuccess {string} firstname Firstname of the User.
     * @apiSuccess {string} lastname  Lastname of the User.
     */
    public function index()
    {
        $ret = [
            "name" => "Memori Api",
            "version" => "0.2"
        ];
        \Flight::json($ret);
        return;
    }
}
