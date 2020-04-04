<?php
namespace Core\Middleware;

use App\Service\View;
use Core;
use Core\Type\Exception\BadRequestException;

class ExceptionHandler
{
    public function init()
    {
        \Core::$api->map('error', function ($ex) {
            if ($ex instanceof BadRequestException) {
                if(starts_with(Core::$api->request()->url, "/api")){
                    \Core::$api->json($ex->toArray(), $ex->statusCode);
                }else{
                    http_response_code(404);
                    View::getDispatcher()->handle("error", ["error"=>$ex->toArray()]);                    
                }
                
            }
            // Handle error
            else {                
               var_dump($ex->getMessage());
               var_dump($ex->getTraceAsString());
            }
        });
        \Flight::map('notFound', function () {
            throw new BadRequestException("API 不存在", 404);
        });
    }
}
