<?php

namespace Core\Helper;

class Crypto
{
    public static function UrlDecode($input)
    {
        return (strtr($input, '-_.', '+/='));
    }
    public static function UrlEncode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_.');
    }


    public static function encode($data, $key, $iv)
    {
        // 加密
        $cryptText = openssl_encrypt($data, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($cryptText);
    }

    public static function decode($data, $key, $iv)
    {
        // 解密
        $cryptText = base64_decode($data);
        return trim(openssl_decrypt($cryptText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv));
    }

    public static function randomString($length = 16)
    {
        $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . '0123456789';

        $str = '';
        $max = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++)
            $str .= $chars[random_int(0, $max)];

        return $str;
    }
    public static function randomNumber($length = 16)
    {
        $chars =
            '0123456789';

        $str = '';
        $max = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++)
            $str .= $chars[random_int(0, $max)];

        return $str;
    }
    public static function jsonDecode($jsonRaw)
    {
        return json_decode($jsonRaw, true);
    }
    public static function jsonGbkDecode($jsonRaw)
    {
        return json_decode(mb_convert_encoding($jsonRaw, "UTF-8", "GBK"), true);
    }
    public static function gbkDecode($gbk)
    {
        return mb_convert_encoding($gbk, "UTF-8", "GBK");
    }
    public static function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }
        return strtolower(sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535)));
    }
    public static function formId()
    {
        return strtolower(sprintf('%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535)));
    }
}
