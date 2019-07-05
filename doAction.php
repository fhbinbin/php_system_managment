<?php
header('content-type:text/html;charset=utf-8');
require_once 'functions/mysql_func.php';
require_once 'config/config.php';
require_once 'functions/common.func.php';
$act=$_REQUEST['act'];
$link = connect3();   //连接数据库
$username=$_REQUEST['username'];
$password=md5($_POST['password']);
$table='51zxw_user';
switch ($act){
    case 'reg':
        echo 'reg';
        mysqli_autocommit($link, FALSE);
        $regTime=time();
        $token=md5($username.$password.$regTime);//生成token
        $token_exptime=$regTime+240*36000;//token过期时间
        $data=compact('username','password','regTime','token','token_exptime');
        $res=insert($link, $data, $table);
        mysqli_commit($link);
        mysqli_autocommit($link, TRUE);
        alertMes('注册成功，立即激活使用', 'index.php');
        break;
    case 'login':
        echo 'login';
        break;
}


