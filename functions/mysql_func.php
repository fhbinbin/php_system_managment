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
/**
 * 查询指定记录
 * @param object $link
 * @param string $query
 * @param string $result_type
 * @return array|boolean
 */
function fetchOne($link, $query, $result_type = MYSQLI_ASSOC) {
    $result = mysqli_query ( $link, $query );
    if ($result && mysqli_num_rows ( $result ) > 0) {
        $row = mysqli_fetch_array ( $result, $result_type );
        print_r($row);
        return $row;
    } else {
        return false;
    }
}

/**
 * 得到表中的记录数
 * @param object $link
 * @param string $table
 * @return number|boolean
 */
function getTotalRows($link, $table) {
    $query = "SELECT COUNT(*) AS totalRows FROM {$table}";
    $result = mysqli_query ( $link, $query );
    if ($result && mysqli_num_rows ( $result ) == 1) {
        $row = mysqli_fetch_assoc ( $result );
        return $row ['totalRows'];
    } else {
        return false;
    }
}
/**
 * 查询所有记录
 * @param object $link
 * @param string $query
 * @param string $result_type
 * @return array|boolean
 */
function fetchAll($link, $query, $result_type = MYSQLI_ASSOC) {
    $result = mysqli_query ( $link, $query );
    if ($result && mysqli_num_rows ( $result ) > 0) {
        while ( $row = mysqli_fetch_array ( $result, $result_type ) ) {
            $rows [] = $row;
        }
        return $rows;
    } else {
        return false;
    }
}

//DELETE FROM user WHERE id=
/**
 * 删除操作
 * @param object $link
 * @param string $table
 * @param string $where
 * @return boolean
 */
function delete($link, $table, $where = null) {
    $where = $where ? ' WHERE ' . $where : '';
    $query = "DELETE FROM {$table} {$where}";
    $res = mysqli_query ( $link, $query );
    if ($res) {
        return mysqli_affected_rows ( $link );
    } else {
        return false;
    }
}