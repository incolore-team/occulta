<?php

namespace App\Util;

class View
{
    public $url;
    public function __construct()
    {
        $this->url =  new Url();
    }
}
