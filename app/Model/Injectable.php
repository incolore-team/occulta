<?php

namespace App\Model;

/**
 * 本类使得继承他的类能够直接实现 $obj->$var 调用函数，也就是能够调用注入变量的匿名函数。
 */
class Injectable
{
    public function __call($method, $args)
    {
        if (isset($this->$method)) {
            $func = $this->$method;
            $call =  call_user_func_array($func, $args);
            if ($call) return $call;
        }
    }
}
