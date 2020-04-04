<?php

namespace App\Service;

use \Core;
use Core\Helper\Crypto;
use Core\Middleware\PermissionFilter;
use flight\util\Collection;

class Field
{
    public const tableMeta = "field_meta";
    public const table = "field";

    public static function addMeta($name, $option, $slug, $param)
    {
        Core::$db->insert(self::tableMeta, [
            'name' => $name,
            'option' => $option,
            'slug' => $slug,
            'param' => $param,
        ]);
        return Core::$db->id();
    }
    public static function removeMeta($id)
    {
        Core::$db->delete(
            self::tableMeta,
            ['id' => $id]
        );
    }
    public static function updateMeta($id, $option, $slug, $param)
    {
        Core::$db->update(self::tableMeta, [
            'option' => $option,
            'slug' => $slug,
            'param' => $slug,
        ], ["id" => $id]);
    }
    public static function listMeta($name = null)
    {
        if ($name == null) {
            return Core::$db->select(self::tableMeta, "*");
        }
        return Core::$db->select(self::tableMeta, "*", [
            'name' => $name,
        ]);
    }
    public static function removePropByMetaId($id)
    {
        return Core::$db->delete(self::table, ["metaFieldId" => $id]);
    }
    public static function getProperties($contentId, $full = false)
    {
        $cluster = [];
        $tableMeta = self::tableMeta;
        $table = self::table;
        $rows = (Core::$db->select(
            self::table,
            [
                "[>]$tableMeta" => ['metaFieldId' => "id"]
            ],
            [
                "$tableMeta.id",
                "$tableMeta.name",
                "$tableMeta.option",
                "$table.value"
            ],
            [
                "contentId" => $contentId
            ]
        ));
        if ($full) return $rows;
        foreach ($rows as $row) {
            $type = $row["name"];
            if (!array_key_exists($type, $cluster)) {
                $cluster[$type] = [];
            }
            $cluster[$type][] = [
                "id" => intval($row["id"]),
                "name" => $row["option"],
                "value" =>  $row["value"]
            ];
        }
        return $cluster;
    }
    /**
     * 设置文章的属性。自动增减
     * $properties 输入：数组，每个元素都拥有 id, value 字段
     */
    public static function setProperties($contentId, $properties)
    {
        $tableMeta = self::tableMeta;
        $table = self::table;
        // 该内容的所有属性
        $allProps = Core::$db->select(self::table, ["contentId", "metaFieldId", "value"], ["contentId" => $contentId]);
        // 本函数判断属性集合中是否有某个 meta 项
        $hasProp = function ($set, $metaId) {
            foreach ($set as $item) {
                var_dump($item);
                if (intval($item["metaFieldId"]) == $metaId) return true;
            }
            return false;
        };
        // 遍历需要设置的所有属性值
        foreach ($properties as $prop) {

            $metaId = $prop["metaFieldId"];
            $value = isset($prop["value"]) ? $prop["value"] : null;

            // 若内容item没有这个属性，则添加
            if (!$hasProp($allProps, $metaId)) {
                Core::$db->insert(self::table, ["contentId" => $contentId, "metaFieldId" => $metaId, "value" => $value]);
            } else {
                //否则就更新原有的属性
                Core::$db->update(
                    self::table,
                    ["value" => $value],
                    [
                        "contentId" => $contentId,
                        "metaFieldId" => $metaId
                    ]
                );
            }
        }
        // 删除没有提及的属性
        foreach ($allProps as $prop) {
            // 如果这个属性在 properties 参数中被提到，则保留
            if ($hasProp($properties, $prop)) continue;
            $metaId = $prop["metaFieldId"];
            Core::$db->delete(self::table, [
                "contentId" => $contentId,
                "metaFieldId" => $metaId
            ]);
        }
    }
}
