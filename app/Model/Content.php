<?php

namespace App\Model;

/**
 * 本类是所有内容（文章、页面等）的模型类。其中有些字段存在数据库，有些需要通过工厂类生成。
 */
class Content extends Injectable
{
    public $id;
    public $uuid;
    public $title;
    public $slug;
    public $createdAt;
    public $updatedAt;
    public $text;
    public $authorId;
    public $visible;
    public $type;
    public $cover;
    public $summary;
    public $views;
    public $cache;
    public $cachedAt;

    public $html;
    public $url;
    public $author;
    public $comment;
    public $fields;
}
