<?php

namespace App\Api;

use App\Service\Auth as ServiceAuth;
use App\Service\Option;
use \Core;
use Core\Helper\Crypto;
use Core\Middleware\PermissionFilter;
use Core\Type\Exception\BadRequestException;

class Auth
{
    /**
     * @api {post} /api/auth/login 登录接口
     * @apiPermission none
     * @apiParam {string} username
     * @apiParam {string} password
     */
    public function login()
    {
        $req = Core::$api->request()->data;
        $username = $req->username;
        $password = $req->password;

        $token = ServiceAuth::login($username, $password);
        if(!$token){
            throw new BadRequestException("用户名或密码错误！");
        }

        $user = ServiceAuth::getUserByToken($token);
        Core::$api->json([
            "token" => $token,
            "createdAt" => time(),
            "userInfo" => ServiceAuth::getUserInfo($user["id"])
        ]);
    }
    /**
     * @api {post} /api/auth/logout
     * @apiPermission api.auth.logout
     */
    public function logout()
    {
        ServiceAuth::logout();

        Core::$api->json([]);
    }

    /**
     * @api {get} /api/auth.info
     * @apiPermission api.auth.info
     */
    public function getInfo()
    {

        Core::$api->json(
            ServiceAuth::getUserInfo()
        );
    }
}
