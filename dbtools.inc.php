<?php
    function create_connection() {
        $link = mysqli_connect("localhost","root","canis1227", "csu_portal") or die("無法連接資料庫：".mysqli_connect_error());
        mysqli_query($link, "SET NAMES utf8");
        return $link;
    }

    function execute_sql($link, $database, $sql) {
        mysqli_select_db($link, $database) or die("開啟資料庫失敗：".mysqli_error($link));
        $result = mysqli_query($link, $sql);
        return $result;
    }
?>