<?php

namespace App\Util;

class Date
{
    /**
     * 词义化时间
     *
     * @access public
     * @param string $from 起始时间
     * @param string $now 终止时间
     * @return string
     */
    public static function dateWord($from, $now)
    {
        $between = $now - $from;
        /** 如果是一天 */
        if ($between >= 0 && $between < 86400 && date('d', $from) == date('d', $now)) {
            /** 如果是一小时 */
            if ($between < 3600) {
                /** 如果是一分钟 */
                if ($between < 60) {
                    if (0 == $between) {
                        return '刚刚';
                    } else {
                        return str_replace('%d', $between, '%d秒前', $between);
                    }
                }
                $min = floor($between / 60);
                return str_replace('%d', $min,  '%d分钟前', $min);
            }
            $hour = floor($between / 3600);
            return str_replace('%d', $hour,  '%d小时前', $hour);
        }
        /** 如果是昨天 */
        if (
            $between > 0 && $between < 172800
            && (date('z', $from) + 1 == date('z', $now) // 在同一年的情况 
                || date('z', $from) + 1 == date('L') + 365 + date('z', $now))
        ) { // 跨年的情况
            return '昨天 ' . date('H:i', $from);
        }
        /** 如果是一个星期 */
        if ($between > 0 && $between < 604800) {
            $day = floor($between / 86400);
            return str_replace('%d', $day, '%d 天前');
        }
        /** 如果是 */
        if (date('Y', $from) == date('Y', $now)) {
            return date('Y年n月j日', $from);
        }
        return date('Y年m月d日', $from);
    }
}
