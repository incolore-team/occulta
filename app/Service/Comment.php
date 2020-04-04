<?php

namespace App\Service;

use App\Model\Content as ModelContent;
use Core;
use Core\Helper\Crypto;
use flight\util\Collection;

class Comment
{
    public const table = "comment";
    public static function create($contentId, $text, $createdAt, $status, $repliedId, $likes, $userId = null, $userEmail = null, $userDisplayName = null, $userUrl = null)
    {
        Core::$db->insert(self::table, [
            'contentId' => $contentId,
            'text' => $text,
            'createdAt' => $createdAt,
            'status' => $status,
            'repliedId' => $repliedId,
            'likes' => $likes,
            'userId' => $userId,
            'userEmail' => $userEmail,
            'userDisplayName' => $userDisplayName,
            'userUrl' => $userUrl,
            'createdAt' => time(),
        ]);
        return Core::$db->id();
    }

    public static function list($page = 1, $perpage = 5, $columns = null, $where = null)
    {
        if (is_null($where) || !is_array($where)) {
            $where = [];
        }
        if (is_null($where) || !is_array($columns)) {
            $columns = "*";
        }

        $offset = ($page - 1) * $perpage;
        $where["LIMIT"] = [$offset, $offset + $perpage];

        $data = Core::$db->select(self::table, $columns, $where);
        $total = Core::$db->count(self::table, "*", $where);
        return [
            "page" => $page,
            "perpage" => $perpage,
            "total" => $total,
            "data" => $data
        ];
    }
    public static function count($where)
    {
        return Core::$db->count(self::table, "*", $where);
    }
    public static function get($type, $id)
    {
        return Core::$db->get(self::table, "*", ["id" => $id]);
    }

}
