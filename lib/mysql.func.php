<?php
require_once "../include.php";

/**
 * 连接数据库
 * @return mysqli 返回数据库连接link
 */
function connect()
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS) or die("connect Error:" . mysqli_connect_error());
    mysqli_select_db($link, "my_test") or die("指定数据库打开失败");
    mysqli_set_charset($link, DB_CHARSET);
    return $link;
}

/**
 * 向数据库中插入数据
 * @param mysqli $link 数据库连接对象
 * @param string $table 目标数据表名称
 * @param array $array 包含待插入数据的关联数组
 * @return bool|int|string 插入成功,返回id,失败返回false
 */
function insert($link, $table, $array)
{
    $keys = join(",", array_keys($array));
    $values = join(",", array_values($array));
    $sql = "INSERT INTO $table ($keys) VALUES ($values)";
    if (mysqli_query($sql)) {
        return mysqli_insert_id($link);
    } else {
        return false;
    }
}

/**
 * 更新数据库中的数据
 * @param mysqli $link 数据库连接对象
 * @param string $table 要更新的数据表
 * @param array $array 包含待更新数据的关联数组
 * @param string $where 更新的条件
 * @return bool|int 更新成功返回影响的记录行数,失败返回false
 */
function update($link, $table, $array, $where = null)
{
    $str = null;
    foreach ($array as $key => $value) {
        if ($str == null) {
            $sep = "";
        } else {
            $sep = ",";
        }
        $str .= $sep . $key . '=' . "'$value'";
    }

    if (mysqli_query($link, "UPDATE $table SET $str" . ($where == null ? null : " where " . $where))) {
        return mysqli_affected_rows($link);
    } else {
        return false;
    }
}

/**删除数据库中指定的数据行
 * @param mysqli $link 数据库连接对象
 * @param string $table 待删除的表名
 * @param string|null $where 删除的条件
 * @return bool|int 删除成功,返回影响的行数,失败返回false
 */
function delete($link, $table, $where = null)
{
    $where = $where == null ? null : " where " . $where;
    $sql = "DELETE FROM $table $where";
    if (mysqli_query($link, $sql)) {
        return mysqli_affected_rows($link);
    } else {
        return false;
    }
}

/**获取单个记录行
 * @param mysqli $link 数据库连接对象
 * @param string $sql 查询语句
 * @param int $result_type 返回查询结果的类型:MYSQLI_ASSOC代表关联数组,MYSQLI_NUM代表数字索引数组,MYSQLI_BOTH代表关联和数字索引具有.默认为MYSQLI_ASSOC.
 * @return array|bool|null 查询成功返回指定行的数组,失败返回false
 */
function fetchSingleRow($link, $sql, $result_type = MYSQLI_ASSOC)
{
    if (!empty($sql) && trim($sql) != '') {
        $mysqli_result = mysqli_query($link, $sql);
        if ($mysqli_result && mysqli_num_rows($mysqli_result) > 0) {
            $row = mysqli_fetch_array($mysqli_result, $result_type);
            return $row;
        } else {
            return false;
        }
    } else {
        die("查询语句不能为空");
    }
}

/**获取所有记录行
 * @param mysqli $link 数据库连接对象
 * @param string $sql 查询语句
 * @param int $result_type 返回查询结果的类型:MYSQLI_ASSOC代表关联数组,MYSQLI_NUM代表数字索引数组,MYSQLI_BOTH代表关联和数字索引具有.默认为MYSQLI_ASSOC.
 * @return array|bool 查询成功返回所有结果行的数组(二维数组),失败返回false
 */
function fetchAllRows($link, $sql, $result_type = MYSQLI_ASSOC)
{
    if (!empty($sql) && trim($sql) != '') {
        $mysqli_result = mysqli_query($link, $sql);
        if ($mysqli_result && mysqli_num_rows($mysqli_result) > 0) {
            $rows = [];
            while ($row = mysqli_fetch_array($mysqli_result, $result_type)) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return false;
        }
    } else {
        die("查询语句不能为空");
    }
}

/**获取结果集的行数
 * @param $link 数据库连接对象
 * @param $sql 查询语句
 * @return int 返回结果集的行数
 */
function getResultRows($link, $sql)
{
    if (!empty($sql) && trim($sql) != '') {
        $mysqli_result = mysqli_query($link, $sql);
        if ($mysqli_result) {
            return mysqli_num_rows($mysqli_result);
        } else {
            return 0;
        }
    } else {
        die("查询语句不能为空");
    }


}
