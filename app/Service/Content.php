<?php

namespace App\Service;

use App\Model\Content as ModelContent;
use Core;
use Core\Helper\Crypto;
use flight\util\Collection;

class Content
{
    public const table = "content";
    /**
     * 创建内容
     *
     * @param string $title 标题
     * @param string $slug slug
     * @param string $text 内容
     * @param string $type 类型
     * @param boolean $allowComment 是否允许评论
     * @param boolean $visible 是否可见 
     * @param string $summary 简介
     * @param string $cover 封面、配图链接
     * @return int 内容 id
     */
    public static function create($type, $title, $slug, $text, $status,  $authorId, $allowComment = true, $visible = true, $summary = null, $cover = null)
    {
        Core::$db->insert(self::table, [
            'title' => $title,
            'uuid' => Crypto::GUID(),
            'authorId' => $authorId,
            'slug' => $slug,
            'text' => $text,
            'status' => $status,
            'type' => $type,
            'allowComment' => $allowComment,
            'visible' => $visible,
            'summary' => $summary,
            'cover' => $cover,
            'createdAt' => time(),
            'updatedAt' => time()
        ]);
        return Core::$db->id();
    }
    public static function update($id, $type, $title, $slug, $text, $status, $authorId, $allowComment = true, $visible = true, $summary = null, $cover = null)
    {
        return Core::$db->update(
            self::table,
            [
                'title' => $title,
                'authorId' => $authorId,
                'slug' => $slug,
                'text' => $text,
                'status' => $status,
                'type' => $type,
                'allowComment' => $allowComment,
                'visible' => $visible,
                'summary' => $summary,
                'cover' => $cover,
                'updatedAt' => time()
            ],
            ["id" => $id]
        );
    }
    /**
     * 获取上一篇内容
     *
     * @param string $type
     * @param int $createdAt 此篇内容创建时间
     * @return void
     */
    public static function prev($type, $createdAt)
    {
        return Core::$db->get(self::table, "*", ["createdAt[<]" => $createdAt, "ORDER" => "DESC", "type" => $type]);
    }
    public static function next($type, $createdAt)
    {
        return Core::$db->get(self::table, "*", ["createdAt[>]" => $createdAt, "ORDER" => "DESC", "type" => $type]);
    }
    /**
     * 计算数量
     *
     * @param string $type
     * @param array $where 条件
     * @return void
     */
    public static function count($type, $where)
    {
        return Core::$db->count(self::table, "*", ["type" => $type]);
    }
    /**
     * 分页列出
     *
     * @param string $type
     * @param integer $page
     * @param integer $perpage
     * @param array $columns
     * @param array $where
     * @param string $order
     * @return array
     */
    public static function list($type, $page = 1, $perpage = 5, $columns = null, $where = null, $order = "DESC")
    {
        if (is_null($where) || !is_array($where)) {
            $where = [];
        }
        if (is_null($where) || !is_array($columns)) {
            $columns = "*";
        }

        $offset = ($page - 1) * $perpage;
        $where['type'] = $type;

        $total = Core::$db->count(self::table, "*", $where);
        $where["LIMIT"] = [$offset, $offset + $perpage];
        $where['ORDER'] = ["createdAt" => $order];
        $data = Core::$db->select(self::table, $columns, $where);
        return [
            "page" => $page,
            "perpage" => $perpage,
            "total" => $total,
            "data" => $data
        ];
    }
    /**
     * 在标题和正文搜索
     *
     * @param string $type
     * @param string $str
     * @param integer $page
     * @param integer $perpage
     * @param array $columns
     * @param array $where
     * @param string $order
     * @return array
     */
    public static function search($type, $str, $page = 1, $perpage = 5, $columns = null, $where = null, $order = "DESC")
    {
        $where["OR"] = ["title[~]" => $str, "text[~]" => $str];
        return self::list($type, $page, $perpage, $columns, $where, $order);
    }
    public static function get($id)
    {
        return Core::$db->get(self::table, "*", ["id" => $id]);
    }

    public static function getByUUID($uuid)
    {
        return Core::$db->get(self::table, "*", ["uuid" => $uuid]);
    }
    public static function getBySlug($slug)
    {
        return Core::$db->get(self::table, "*", ["slug" => $slug]);
    }
    public static function delete($id, $type)
    {
        $suc = Core::$db->delete(self::table, ["id" => $id, "type" => $type]);
        if ($suc) Core::$db->delete(Field::table, ["contentId" => $id]);
        return $suc;
    }

    private static $mdParser = null;
    /**
     * 获取 markdown 解析器
     *
     * @return object
     */
    public static function getParse()
    {
        if (self::$mdParser) return self::$mdParser;
        self::$mdParser = new \cebe\markdown\Markdown();
        return self::$mdParser;
    }

    public static function setStatus($id, $status)
    {
        return Core::$db->update(self::table, ["status" => $status], ["id" => $id]);
    }
}
