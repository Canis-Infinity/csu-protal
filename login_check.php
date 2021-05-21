<?php
  error_reporting(0);
  require_once("dbtools.inc.php");
  header("Content-type: text/html; charset=utf-8");

  $id = $_POST["id"];
  $password = $_POST["password"];
  $remember = $_POST["remember"];
  $ip = $_SERVER["REMOTE_ADDR"];
  $r_p = "1";
  $r_n = "0";

  $link = create_connection();

  $sql = "UPDATE `users` SET `remember` = '{$remember}' WHERE `id` = '{$id}' and `password` = '{$password}'";
  $result = execute_sql($link, "csu_portal", $sql);
  mysqli_free_result($result);

  $sql2 = "INSERT INTO `login_history` (`id`, `ip`) VALUES ('{$id}', '{$ip}')";
  $result2 = execute_sql($link, "csu_portal", $sql2);
  mysqli_free_result($result2);

  session_start();
  if (strcmp($remember, $r_p) == 0) {
    setcookie("id", $id, time() + (10 * 365 * 24 * 60 * 60));
    setcookie("password", $password, time() + (10 * 365 * 24 * 60 * 60));
    $_SESSION["remember"] = "1";
    setcookie("user", $id);
  } else {
    if (isset($_COOKIE["id"])) {
      setcookie("id", $id);
    }
    setcookie("id", "");
    setcookie("password", $password);
    setcookie("user", $id);
    $_SESSION["remember"] = "";
  }

  mysqli_close($link);
  header("location: index.php");
?>
