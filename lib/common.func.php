<?php
/**
 * Created by PhpStorm.
 * User: qiaoer
 * Date: 16/9/17
 * Time: 10:56
 */
function alertMessageAndRedirection($message, $url)
{
    echo "<script>alert('$message');</script>";
    echo "<script>window.location.href='$url';</script>";
}