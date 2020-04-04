<?php

namespace App\Service;

use \Core;
use Core\Helper\Crypto;
use Core\Middleware\PermissionFilter;

class Auth
{
    public const table = "user";
    public const tokenTable = "token";
    public const permTable = "permission";

    /**
     * 登录，成功返回 token
     */
    public static function login($username, $password)
    {
        $salt = Option::get("auth.salt");
        $passwordHashed = hash("sha256", $salt . $password);
        $row = Core::$db->get(self::table, ["password", "id"], ["username" => $username]);
        if ($row["password"] == $passwordHashed) {
            return self::createToken($row["id"]);
        } else {
            return false;
        }
        
    }
    /**
     * 为用户创建 token
     * @return string token
     */
    public static function createToken($userId)
    {
        self::clearExpiredToken($userId);
        if (Core::$db->count(self::tokenTable, ["id"], ["userId" => $userId]) > Option::get("auth.tokenLimit")) {
            $ret = Core::$db->get(self::tokenTable, ["id"], ["userId" => $userId, "ORDER" => ["id" => "ASC"]]);
            Core::$db->delete(self::tokenTable, ["id" => $ret["id"]]);
        }
        $token = Crypto::GUID();
        Core::$db->insert(self::tokenTable, ["userId" => $userId, "value" => $token, "createdAt" => time()]);
        return $token;
    }
    /**
     * 清理某个用户的过期 token
     *
     * @param int|string $userId
     * @return void
     */
    public static function clearExpiredToken($userId)
    {
        Core::$db->delete(self::tokenTable, ["userId" => $userId, "createdAt[>]" => time() + 3600 * 24 * Option::get("auth.tokenExpire")]);
    }
    /**
     * 通过 token 获取用户。本函数会自动清理无效的 token。成功返回用户，失败返回 false。
     *
     * @param string $token
     * @return array|bool
     */
    public static function getUserByToken($token)
    {

        $row = Core::$db->get(self::tokenTable, ["userId", "createdAt"], ["value" => $token]);

        if (!$row) return false;

        if (intval($row["createdAt"]) >  time() + 3600 * 24 * Option::get("auth.tokenExpire")) {
            Core::$db->delete(self::tokenTable, ["value" => $token]);
            return false;
        }

        Core::$db->update(self::table, ["updatedAt" => time()], ["id" => $row["userId"]]);
        $user = Core::$db->get(self::table, "*", ["id" => $row["userId"]]);
        return $user;
    }
    
    /**
     * 通过 id 获取用户。成功返回用户，失败返回 false。
     *
     * @param int $id
     * @return array|bool
     */
    public static function getUser($id)
    {
       $row = Core::$db->get(self::table, "*", ["id"=>$id]);
       return $row;
    }
    /**
     * 检查用户是否拥有某权限
     *
     * @param int $userId 用户 id
     * @param string $permissionToCheck 权限节点。
     * @return boolean
     */
    public static function hasPermission($userId, $permissionToCheck)
    {
        $userPerms = self::getUserPerms($userId);
        
        return in_array(trim($permissionToCheck), $userPerms);
    }
    /**
     * 获取用户的所有权限（展开通配符*）
     *
     * @param int $userId
     * @return array
     */
    public static function getUserPerms($userId)
    {
        $allPerms = PermissionFilter::$ruleMap['__permissions']; // 站点所有的权限        
        $userPermsRaw = Core::$db->select(
            self::permTable,
            ["permission", "modifier"],
            ["userId" => $userId, "ORDER" => ["order" => "ASC"]]
        );
        $userPerms = [];
        foreach ($userPermsRaw as $rawPerm) {
            if($rawPerm["permission"] == "*"){
                foreach ($allPerms as $perm) {
                    if ($rawPerm["modifier"] == "+") {
                        $userPerms[] = $perm;
                    } else {
                        array_remove_all($userPerms, $perm);
                    }
                }
                continue;
            }
            $parts = explode(".", $rawPerm["permission"]);
            // 如果规则中没有通配符，则直接增减权限
            if (end($parts) != "*") {
                if ($rawPerm["modifier"] == "+") {
                    $userPerms[] = $rawPerm["permission"];
                } else {
                    array_remove_all($userPerms, $rawPerm["permission"]);
                }
                continue;
            }
            // 对于有通配符的
            $prefix = substr($rawPerm["permission"], 0, -strlen(".*"));
            foreach ($allPerms as $perm) {
                if (!starts_with($perm, $prefix)) {
                    continue;
                }
                if ($rawPerm["modifier"] == "+") {
                    $userPerms[] = $perm;
                } else {
                    array_remove_all($userPerms, $perm);
                }
            }
        }
        return array_values(array_unique($userPerms));
    }

    /**
     * 退出当前用户
     *
     * @return void
     */
    public static function logout()
    {
       
    }
    /**
     * 获取用户信息。如果 user id 为 null，则获取当前用户信息。
     *
     * @param int $userId
     * @return array
     */
    public static function getUserInfo($userId = null)
    {
        if($userId){
            $user = Core::$db->get(self::table, "*", ["id"=>$userId]);
        }else{
            $user = PermissionFilter::$currentUser;
        }        
        return [
            "id"=> $user["id"],
            "username" =>  $user['username'],
            "email" =>  $user['email'],
            "url"  =>  $user['url'],
            "avatar" => Option::get("site.avatar") . md5($user["email"]),
            "permissions" => self::getUserPerms($user["id"])
        ];
    }
}
