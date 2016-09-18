<?php
/**
 * Created by PhpStorm.
 * User: qiaoer
 * Date: 16/9/17
 * Time: 20:12
 */
require_once "../include.php";
$username = $_POST['username'];
$password = md5($_POST['password']);
$user_verify = $_POST['verify'];//用户提交的验证码
$correct_verify = $_SESSION['verify'];


if (strtolower($user_verify) == strtolower($correct_verify)) {
    $mysqli_link = connect();
    $sql = "SELECT * FROM imooc_admin WHERE username='$username' AND password='$password'";

//    绑定参数
//    $mysqli_stmt = mysqli_prepare($mysqli_link, $sql);
//    if (mysqli_stmt_bind_param($mysqli_stmt, "ss", $username, $password)) {
//        if (mysqli_stmt_execute($mysqli_stmt)) {
//            mysqli_stmt_store_result($mysqli_stmt);
//            if (mysqli_stmt_num_rows($mysqli_stmt) > 0) {
//
//            }
//        }
//    }

    $res = checkAdmin($mysqli_link, $sql);
    if ($res) {
        $_SESSION['adminName'] = $res['username'];
        alertMessageAndRedirection("登陆成功", "index.php");
    } else {
        alertMessageAndRedirection("用户名或密码错误", "login.php?username=$username");
    }

} else {
    alertMessageAndRedirection("验证码错误", "login.php?username=$username");
}


//echo "用户名:" . $username . ',密码:' . $password . ',用户提交的验证码:' . $user_verify . ',正确的验证码:' . $correct_verify;