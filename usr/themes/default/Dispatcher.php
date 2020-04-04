<?php

namespace App\Theme\DefaultTheme;

use App\Service\TemplateExtension;
use App\Service\View;
use Core;

/**
 * @package 默认主题
 * @link www.pluvet.com
 * @author Pluveto
 * @email i@pluvet.com
 * @version 1.0
 */
class Dispatcher
{
   public function init()
   {
      //echo "init";
   }

   /**
    * 本函数处理从博客 View 层发送来的信息
    *
    * @param string $routeType 路由类型，比如 "home" 是主页, "admin/home" 是后台主页
    * @param array $data 随路由发来的数据，可以在模板中直接利用。
    * @return bool
    */
   public function handle($routeType, $data)
   {
      require_once 'admin/functions.php';
      Core::$view = \League\Plates\Engine::create(View::getDefaultThemeDir(), 'php');
      Core::$view->register(new TemplateExtension());
      echo Core::$view->render("$routeType.php", array_merge($data, [
         "route" => $routeType
      ]));
      return true;
   }
}
