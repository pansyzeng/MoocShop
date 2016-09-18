<?php
/**
 * @param int $type 想得到的字符串的类型:1代表数字字符串,2代表字母字符串,3代表数字字母字符串
 * @param int $length 想得到的字符串的长度
 * @return string 返回一个指定长度的随机字符串
 */
function buildRandomString($type = 1, $length = 4)
{
    switch ($type) {
        case 1:
            $chars = join("", range(0, 9));
            break;
        case 2:
            $chars = join("", array_merge(range("a", "z"), range("A", "Z")));
            break;
        case 3:
            $chars = join("", array_merge(range("a", "z"), range("A", "Z"), range(0, 9)));
            break;
        default:
            $chars = join("", range(0, 9));
            break;
    }

    if ($length > strlen($chars)) {
        exit("字符串长度不够");
    }
    $chars = str_shuffle($chars);
    return substr($chars, 0, $length);

}

//echo buildRandomString(3,4);