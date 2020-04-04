<?php


// if(substr($_SERVER['REQUEST_URI'], 0, strlen("/public")) === "/public"){
//     http_response_code(404);
//     die();
// }

$t1  = doubleval(microtime());
// 引入composer
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/definition.php';
require_once SYSTEM_CORE . "/functions.php";



\Core::init();
\Core::start();

//file_put_contents(SYSTEM_ROOT . "/log/".time().".myapplication.xhprof", serialize(tideways_xhprof_disable()));

$t2 = doubleval(microtime());
$pattern = Core::$api->router()->route(Core::$api->request())->pattern;
if (!starts_with($pattern, "/api")) : ?>
    <script>
        console.log("[DEBUG] Server rendered in <?= $t2 - $t1; ?>ms");
    </script>
<? endif; ?>