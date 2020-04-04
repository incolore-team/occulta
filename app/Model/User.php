<?php

namespace App\Model;

/**
 * 本类是用户模型类。
 */
class User extends Injectable
{
    public $id;    
    public $username;
    public $password; 
    public $email;
    public $url; 
    public $screenName; 
    public $createdAt; 
    public $updatedAt; 
}