<?php

namespace Core\Middleware;

use Core;

class CORSHandler
{
    public function init()
    {
        Core::$api->before('start', function () {
            header("Access-Control-Allow-Origin: " . "*");
            header("Access-Control-Allow-Methods: " . "OPTIONS, GET, POST, PUT, DELETE");
            header("Access-Control-Allow-Headers: " . "*");
            if(Core::$api->request()->method === "OPTIONS"){
                Core::$api->halt(200);
            }
            
        });
    }
}
