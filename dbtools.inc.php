<?php
    function create_connection() {
        // $link = mysqli_connect("103.200.113.92","csu_portal","ZzptxZNlB2NCAcQ8", "csu_portal") or die("無法連接資料庫：".mysqli_connect_error());
        $link = mysqli_connect("localhost","root","", "csu_portal") or die("無法連接資料庫：".mysqli_connect_error());
        mysqli_query($link, "SET NAMES utf8");
        return $link;
    }

    function execute_sql($link, $database, $sql) {
        mysqli_select_db($link, $database) or die("開啟資料庫失敗：".mysqli_error($link));
        $result = mysqli_query($link, $sql);
        return $result;
        mysqli_close($link);
    }
?>
