<?php

namespace Core\Middleware;

use App\Service\Auth;
use Core;
use Core\Helper\Cookie;
use Core\Helper\Crypto;
use Core\Type\Exception\BadRequestException;

/**
 * 权限过滤中间件
 */
class PermissionFilter implements IMiddleware
{

    /**
     * 当前的用户. 在 roleCheck() 函数里进行的赋值.
     *
     * @var array|object
     */
    public static $currentUser = null;
    /**
     * 路由参数规则表
     *
     * @var array
     */
    public static $ruleMap = [];
    /**
     * 权限过滤中间件的初始化方法
     * 
     * 1. 本函数将为此中间件的各个属性赋值
     * 2. 在所有 API 具体函数执行前会执行过滤器挂载的方法
     * 3. 将会检查参数是否符合规则要求 (规则文件: src/common/config/rule.php, 由生成器(generator.php)生成)
     * 4. 将会检查用户权限是否能够访问想要访问的路由 (规则文件: src/common/config/permission.php, 由生成器(generator.php)生成)
     *
     * @return void
     */
    public function init()
    {

        self::$ruleMap = Core::$config->get("rule", ['none' => 0]);

        /**
         * 挂载过滤器到 API
         */
        Core::$api->before(
            'start',
            function (&$params, &$output) {

                // 如果路由不存在, 直接报错
                $route = Core::$api->router()->route(Core::$api->request());
                if (!$route) {
                    throw new BadRequestException("未找到请求的 API: " . Core::$api->request()->url, 404);
                }
                $pattern = $route->pattern; // such as string(15) "/auth/nonce/@as"

                $this->roleCheck($pattern);
                
                if (starts_with($pattern, "/api")) {
                    $this->paramCheck($pattern);
                }
                
            }
        );
    }
    /**
     * 参数基础静态检查, 检查输入的参数是否缺失, 长度是否在范围内等等.
     * 如果遇到任何问题, 就抛出相应错误
     * 
     * TODO: 上传文件检查
     * 
     * @param string $pattern 用户请求的 api 的路由 
     * @return void
     */
    private function paramCheck($pattern)
    {

        // 注：此前已经经过了 RequestDataMapper, 所以对于 DELETE, PATCH 等请求,
        //    可以直接访问 request()->data 获取请求体

        $method = Core::$api->request()->method;
        $form =
            $method == "GET" ?
            Core::$api->request()->query :
            Core::$api->request()->data;

        // 如果没有给该路由设置规则, 就直接放行
        if (!array_key_exists($pattern, self::$ruleMap)) {
            return;
        }
        // 依次检查各条规则
        $ruleAll = self::$ruleMap[$pattern];
        $ruleList = array_get_if_key_exists($ruleAll, $method, []);

        foreach ($ruleList as $param => $rules) {


            if (starts_with($param, "__")) {
                continue;
            }
            /**
             * 首先可基本分为四种情况:
             * 
             *  1. 参数必要, 表单有 -> 继续处理
             *  2. 参数非必要, 表单有 -> 继续处理
             *  3. 参数必要, 表单无 -> 跳过
             *  3. 参数非必要, 表单无 -> 跳过
             * 
             *  注: 不考虑参数必要但有默认值这种情况. 有默认值就当作参数非必要处理
             * 
             * 因此下面先写跳过的两种情况
             */

            // 检查是否缺少必要参数
            if (array_get_if_key_exists($rules, "required", false)) {
                if (!isset($form->$param)) {
                    throw new BadRequestException("缺少必要参数 " . (SYSTEM_DEBUG ? " `$param`."  : "."), 400, 400);
                }
                // if (empty($form->$param)) {
                //     throw new BadRequestException("提交的必要参数 `$param` 为空值.");
                // }
            }

            // 如果参数是非必要参数, 且提交的表单没有这个参数, 那么就跳过
            if (!array_get_if_key_exists($rules, "required", false) && !isset($form->$param)) {
                // 如果有默认值就赋予一个默认值
                if ($default = array_get_if_key_exists($rules, "default", false)) {
                    $method == "GET" ?
                        Core::$api->request()->query[$param] = $default :
                        Core::$api->request()->data[$param] = $default;
                }
                continue;
            }
            /**
             * --> options 检查
             */
            $options = array_get_if_key_exists($rules, "options", []);
            if (count($options)) {
                if (in_array($form->$param, $options)) continue;
                throw new BadRequestException("参数 `$param` 值无效, 应在枚举范围内. ");
            }
            /**
             * --> type 检查
             */
            if (!$type = array_get_if_key_exists($rules, "type", false)) {
                continue;
            }
            switch ($type) {
                case 'integer':
                    if (!is_numeric($form->$param)) {
                        throw new BadRequestException("参数 `$param` 应当为整数. ");
                    }
                    $number = intval($form->$param);
                    $min = array_get_if_key_exists($rules, "min", 0);
                    $max = array_get_if_key_exists($rules, "max", 0);
                    if ($min && $number < $min) {
                        throw new BadRequestException("参数 `$param` 应当大于 $min. ");
                    }
                    if ($max && $number > $max) {
                        throw new BadRequestException("参数 `$param` 应当小于 $max. ");
                    }
                    $method == "GET" ?
                        Core::$api->request()->query[$param] = $number :
                        Core::$api->request()->data[$param] = $number;
                    break;
                case 'string':
                    $min = array_get_if_key_exists($rules, "min", 0);
                    $max = array_get_if_key_exists($rules, "max", 0);
                    if (!is_string($form->$param)) {
                        throw new BadRequestException("参数 `$param` 应当为字符串. ");
                    }
                    $strLength = mb_strlen($form->$param);
                    if ($min && $strLength < $min) {
                        throw new BadRequestException("参数 `$param` 长度应当大于 $min. ");
                    }
                    if ($max && $strLength > $max) {
                        throw new BadRequestException("参数 `$param` 长度应当小于 $max. ");
                    }
                    break;
                case 'boolean':
                    if (strtolower($form->$param) === "true") {
                        $form->$param = true;
                    }
                    if (strtolower($form->$param) === "false") {
                        $form->$param = false;
                    }
                    if (!is_bool($form->$param)) {
                        throw new BadRequestException("参数 `$param` 应当为布尔值 (true/false). ");
                    }
                    $method == "GET" ?
                        Core::$api->request()->query[$param] = $form->$param :
                        Core::$api->request()->data[$param] = $form->$param;
                    break;
                case 'array':
                    if (!is_array($form->$param)) {
                        throw new BadRequestException("参数 `$param` 应当为数组. ");
                    }
                    break;
                default:
                    break;
            }
        }
    }
    /**
     * 用户角色检查. 检查用户是否有调用期望 API 的权限, 
     * 如果没有权限就抛出异常结束请求, 如果有权限就设置好当前用户并放行.
     *
     * @param string $pattern 用户请求的 api 的路由
     * @return void
     */
    private function roleCheck($pattern)
    {

        if (!isset(self::$ruleMap[$pattern])) return false;

        $apiMode = starts_with($pattern,  "/api");
        $method = Core::$api->request()->method;
        $permission = array_get_if_key_exists(self::$ruleMap[$pattern][$method], "__permission", false);


        if (!$permission || $permission == "none") {
            if ($apiMode) {
                return true;
            }
            $token = Cookie::get("token");
            if (!$token) {
                return true;
            }


            $user = Auth::getUserByToken($token);
            if (!$user) {
                return true;
            }
            self::$currentUser = $user;
            return true;
        }

        $token = Cookie::get("token");
        if ($apiMode && !$token) {
            $token = $_SERVER["HTTP_AUTHORIZATION"];
        }

        if (!isset($token)) {
            if ($apiMode) {
                throw new BadRequestException("Token missing", 403, 403);
            } else {
                Core::$api->redirect("/admin/login");
            }
        }
        $user = Auth::getUserByToken($token);
        if (!$user) {
            if ($apiMode) {
                throw new BadRequestException("Token invalid or user not existing", 403, 403);
            } else {
                Core::$api->redirect("/admin/login");
            }
        }
        self::$currentUser = $user;

        if (!Auth::hasPermission($user["id"], $permission)) {

            throw new BadRequestException("No permission!", 403, 403, SYSTEM_DEBUG ? $permission : null);
        }

        return true;
    }
}
