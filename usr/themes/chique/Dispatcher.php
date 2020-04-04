<?php

namespace App\Theme\Chique\Dispatcher;

use App\Service\TemplateExtension;
use App\Service\View;
use Core;

/**
 * @package Chique 主题
 * @link https://www.pluvet.com
 * @author Pluveto
 * @email i@pluvet.com
 * @cover images/screenshot.png
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
      // 如果本文件没有处理这个 routeType，就交给默认模板处理
      if (!is_file(View::getThemeDir() . "/$routeType.php")) {
         View::getDefaultDispatcher()->handle($routeType, $data);
         return;
      }

      // render 函数会把数据渲染到模板，模板是第一个参数。
      // 比如这里：如果 $routeType 是 "admin/home"，就会使用 "admin/home.php" 进行渲染
      echo Core::$view->render("$routeType.php", array_merge($data, [
         "route" => $routeType
      ]));
      return true;
   }
}
