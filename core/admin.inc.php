<?php
/**
 * Created by PhpStorm.
 * User: qiaoer
 * Date: 16/9/18
 * Time: 09:25
 */
require_once "../include.php";
function checkAdmin($link, $sql)
{
    return fetchSingleRow($link, $sql);
}