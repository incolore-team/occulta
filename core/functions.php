<?php

/**
 * 如果存在 key 就返回对应 value, 否则返回默认值
 *
 * @param array $array
 * @param string $key
 * @param object $default
 * @return mixed
 */
function array_get_if_key_exists($array, $key, $default)
{
    return array_key_exists($key, $array) ? $array[$key] : $default;
}
function array_keys_exists($keys, $array)
{
    foreach ($keys as $key) {
        if (!array_key_exists($key, $array)) {
            return false;
        }
    }
    return true;
}
function array_val_conflict($array, $key)
{
    for ($i = 0; $i < count($array); $i++) {
        for ($j = $i + 1; $j < count($array); $j++) {
            if ("" != trim($array[$i][$key]) && trim($array[$i][$key]) === trim($array[$j][$key])) {
                return true;
            }
        }
    }
    return false;
}

function array_key_exists_r($array, $keySearch)
{
    foreach ($array as $key => $item) {
        if ($key == $keySearch) {
            return true;
        } elseif (is_array($item) && array_key_exists_r($item, $keySearch)) {
            return true;
        }
    }
    return false;
}

function array_key_contains_r($array, $search)
{
    foreach ($array as $key => $item) {
        if (strpos($search, $key)) {
            return true;
        } elseif (is_array($item) && array_key_exists_r($item, $search)) {
            return true;
        }
    }
    return false;
}

// 查找 obs 的任何一个 item 的 item['key'] 是否包含 value
function in_any_item_of($value, $key, $obs)
{
    foreach ($obs as $ob) {
        if ($ob[$key] === $value) {
            return true;
        }
    }
    return false;
}

function tick()
{
    return (round(microtime(true) * 1000) - 1000 * strtotime(date('Y-m-d')));
}

function log_dump($str)
{
    if (!SYSTEM_DEBUG) {
        return;
    }
    if (gettype($str) != "string") {
        $str = print_r($str, true);
    }
    $log_filename = SYSTEM_ROOT . "/log";
    if (!file_exists($log_filename)) {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename . '/log_' . date('Y-m-d') . '.log';
    file_put_contents($log_file_data, date("H:i:s ") . $str . "\n", FILE_APPEND);
}



function sanitize($string, $force_lowercase = true, $anal = false)
{
    $strip = array(
        "~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ".", ">", "/", "?"
    );
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean) :
        $clean;
}

function starts_with($_this, $string)
{
    return (substr($_this, 0, strlen($string)) === $string);
}

function ends_with($_this, $string)
{
    $len = strlen($string);
    if ($len == 0) {
        return true;
    }
    return (substr($_this, -$len) === $string);
}

function extension($file)
{
    return strtolower(pathinfo(parse_url($file, PHP_URL_PATH), PATHINFO_EXTENSION));
}

function get_mime_by_extension($extension)
{
    $mimes = [
        'bmp'   => 'image/bmp',
        'css'   => 'text/css',
        'eot'   => 'application/vnd.ms-fontobject"',
        'gif'   => 'image/gif',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpeg',
        'js'    => 'application/x-javascript',
        'json'  => 'application/json',
        'html'  => 'text/html',
        'otf'   => 'application/x-font-opentype',
        'png'   => 'image/png',
        'svg'   => 'image/svg+xml',
        'swf'   => 'application/x-shockwave-flash',
        'ttf'   => 'application/x-font-ttf',
        'woff'  => 'application/x-font-woff',
        'woff2' => 'application/font-woff2',
        'zip'   => 'application/zip'
    ];
    if (!array_key_exists($extension, $mimes)) {
        return "application/txt";
    }
    return $mimes[$extension];
}

function array_remove_all(&$array, $key)
{
    foreach ($array as $k => $v) {
        if ($v ==  $key) {
            unset($array[$k]);
        }
    }
}

function array_2d_select($array, $where)
{
    $ret = [];
    foreach ($array as $line) {
        $retmark = true;
        foreach ($where as $key => $value) {
            if ($line[$key] != $value) {
                $retmark = false;
            }
        }
        if ($retmark) {
            $ret[] = $line;
        }
    }
    return $ret;
}

function array_2d_get($array, $where)
{
    foreach ($array as $line) {
        $retmark = true;
        foreach ($where as $key => $value) {
            if ($line[$key] != $value) {
                $retmark = false;
            }
        }
        if ($retmark) {
            return $line;
        }
    }
    return false;
}
function array_2d_has($array, $where)
{
    return boolval(array_2d_get($array, $where));
}

/**
 * 生成缩略名。本函数来自 typecho 的源码。
 *
 * @param string $str
 * @param string $default
 * @param integer $maxLength
 * @return string
 */
function slug_name($str, $default = NULL, $maxLength = 128)
{
    $str = trim($str);

    if (!strlen($str)) {
        return $default;
    }

    if (function_exists('mb_get_info') && function_exists('mb_regex_encoding')) {
        mb_regex_encoding("utf-8");
        mb_ereg_search_init($str, "[\w" . preg_quote('_-') . "]+");
        $result = mb_ereg_search();
        $return = '';

        if ($result) {
            $regs = mb_ereg_search_getregs();
            $pos = 0;
            do {
                $return .= ($pos > 0 ? '-' : '') . $regs[0];
                $pos++;
            } while ($regs = mb_ereg_search_regs());
        }

        $str = $return;
    } else {
        if (preg_match_all("/[\w" . preg_quote('_-') . "]+/u", $str, $matches)) {
            $str = implode('-', $matches[0]);
        }
    }

    $str = trim($str, '-_');
    $str = !strlen($str) ? $default : $str;
    return substr($str, 0, $maxLength);
}
