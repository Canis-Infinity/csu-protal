<?php
	require_once("dbtools.inc.php");

	$id = $_COOKIE["user"];
  $password = $_POST["new_pwd"];

  $link = create_connection();

  $sql = "UPDATE `users` SET  `password` = '$password' WHERE `id` = '$id'";
  $result = execute_sql($link, "csu_portal", $sql);

	mysqli_free_result($result);
  mysqli_close($link);
	echo "<script>window.location.href='login.php';</script>";
?>
