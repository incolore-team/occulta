<?php

namespace App\Service;

use \Core;

class Option
{
    public const table = "option";
    public static $cache = [];

    /**
     * 获取配置项
     *
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        if ($ret = array_get_if_key_exists(self::$cache, $key, false)) {
            return $ret;
        }
        $row = Core::$db->get(self::table, "*", ["key" => $key]);
        $ret = self::convert($row);
        self::$cache[$key]  = $ret;
        return $ret;
    }

    /**
     * 自动转换类型
     *
     * @param array $row
     * @return mixed
     */
    public static function convert($row)
    {
        $type = $row["type"];
        $val = $row["value"];

        if ($type == "int")     return intval($val);
        if ($type == "float")   return floatval($val);
        if ($type == "double")  return doubleval($val);
        if ($type == "json")    return json_decode($val, true);
        
        return $val;
    }
}
