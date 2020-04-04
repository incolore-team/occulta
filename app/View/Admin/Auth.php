<?php

namespace App\View\Admin;

use App\Service\Option;
use App\Service\Site;
use App\Service\Auth as Service;
use App\Service\View;
use Core;
use Core\Helper\Cookie;
use flight\util\Collection;

class Auth
{
    /**
     * @api {get} /admin/login 欢迎界面
     * @apiName Welcome
     * @apiGroup Welcome
     */
    public function login()
    {
        View::getDispatcher()->handle("admin/login", View::getSharedData());
    }

    /**
     * @api {post} /admin/login 欢迎界面
     * @apiName Welcome
     * @apiParam {string} username
     * @apiParam {string} password
     * @apiGroup Welcome
     */
    public function _login()
    {
        $req = Core::$api->request()->data;
        $username = trim($req->username);
        $password = $req->password;

        if(strlen($username) == 0 || strlen($password) == 0){
            View::getDispatcher()->handle(
                "admin/login",
                array_merge(View::getSharedData(), ["error" => "用户名或密码为空！"])
            );
            return;
        }

        $token = Service::login($username, $password);
        if ($token) {
            Cookie::set('token', $token, Option::get("auth.tokenExpire"));
            Core::$api->redirect("/admin");
        } else {            
            log_dump("$username 登录失败");
            View::getDispatcher()->handle(
                "admin/login",
                array_merge(View::getSharedData(), ["error" => "用户名或密码错误！", "username" => $username])
            );
        }
    }
}
