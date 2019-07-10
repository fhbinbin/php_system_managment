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
        $username=addslashes($username);
        $query="SELECT id FROM {$table} WHERE username='{$username}' AND password='{$password}'";
        $row=fetchOne($link, $query);
        if($row){
            alertMes('登陆成功，跳转到首页','student/layout-index.php');
// 			if($row['status']==0){
// 				alertMes('请先到邮箱激活再来登陆','index.php');
// 			}else{
// 				alertMes('登陆成功，跳转到首页','student/layout-index.php');
// 			}
        }else{
            alertMes('用户名或密码错误，重新登陆','index.php');
        }
        break;
}


