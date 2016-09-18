<?php
/**
 * Created by PhpStorm.
 * User: qiaoer
 * Date: 16/9/17
 * Time: 10:56
 */
//session_start();
require_once "string.func.php";

/**
 * @param int $width 图像宽,默认80px
 * @param int $height 图像高,默认30px
 * @param int $type 验证码类型:1代表数字字符串,2代表字母字符串,3代表数字字母字符串,默认为3
 * @param int $length 验证码长度,默认为4
 * @param string $sess_name SESSION键名,默认为verify
 * @param bool $haspixel 是否需要噪点,默认需要
 * @param bool $hasline 是否需要干扰线段,默认需要
 */
function verifyImage($width = 80, $height = 30, $type = 3, $length = 4, $sess_name = "verify", $haspixel = true, $hasline = true)
{
    $img = imagecreatetruecolor($width, $height);
    $grey = imagecolorallocate($img, 0x99, 0x99, 0x99);
    $white = imagecolorallocate($img, 0xff, 0xff, 0xff);
    imagefill($img, 0, 0, $grey);
    imagefilledrectangle($img, 1, 1, $width - 2, $height - 2, $white);


    $chars = buildRandomString($type, $length);

    $_SESSION[$sess_name] = $chars;
//    echo $_SESSION[$sess_name];

    $fonts = array("AppleMyungjo.ttf", "Chalkduster.ttf", "DIN Condensed Bold.ttf", "Gungseouche.ttf", "Luminari.ttf", "Silom.ttf");
    for ($i = 0; $i < $length; $i++) {
        $size = rand(14, 18);
        $angle = rand(-18, 18);
        $x = 5 + $size * $i;
        $y = rand(20, 26);
        $color = imagecolorallocate($img, rand(10, 160), rand(50, 190), rand(100, 210));
        $fontfile = "../fonts/" . $fonts[rand(0, count($fonts) - 1)];
        $text = $chars[$i];
        imagettftext($img, $size, $angle, $x, $y, $color, $fontfile, $text);
    }

    if ($haspixel) {
        $point_count = rand(40, 60);
        for ($i = 0; $i < $point_count; $i++) {
            $x = rand(1, $width - 2);
            $y = rand(1, $height - 2);
            $color = imagecolorallocate($img, rand(0, 255), rand(0, 255), rand(0, 255));
            imagesetpixel($img, $x, $y, $color);
        }
    }

    if ($hasline) {
        $line_count = rand(2, 5);
        for ($i = 0; $i < $line_count; $i++) {
            $x1 = rand(1, $width - 2);
            $y1 = rand(1, $height - 2);
            $x2 = rand(1, $width - 2);
            $y2 = rand(1, $height - 2);
            $color = imagecolorallocate($img, rand(0, 255), rand(0, 255), rand(0, 255));
            imageline($img, $x1, $y1, $x2, $y2, $color);
        }
    }

    header("content-type:image/gif");
    imagegif($img);
    imagedestroy($img);
}

//verifyImage();