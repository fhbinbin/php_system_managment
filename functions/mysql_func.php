<?php

/**
 * 连接
 * @param string $host
 * @param string $user
 * @param string $password
 * @param string $charset
 * @param string $database
 * @return object 连接标识符
 */


function connect3(){
    $link = mysqli_connect ( DB_HOST, DB_USER, DB_PWD ) or die ( '数据库连接失败<br/>ERROR ' . mysqli_connect_errno () . ':' . mysqli_connect_error () );
    mysqli_set_charset ( $link, DB_CHARSET );
    mysqli_select_db ( $link, DB_DBNAME ) or die ( '指定数据库打开失败<br/>ERROR ' . mysqli_errno ( $link ) . ':' . mysqli_error ( $link ) );
    return $link;
};

function insert($link,$data,$table){
    $keys = join ( ',', array_keys ( $data ) );
    $vals = "'" . join ( "','", array_values ( $data ) ) . "'";
    $query = "INSERT {$table}({$keys}) VALUES({$vals})";
    $res = mysqli_query ( $link, $query );
    if ($res) {
        return mysqli_insert_id ( $link );
    } else {
        return false;
    }
}