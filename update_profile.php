<?php
	require_once("dbtools.inc.php");

	$id = $_COOKIE["user"];
  $new_mobile = $_POST["mobile"];
  $new_email = $_POST["email"];

  $link = create_connection();

  $sql = "UPDATE `students` SET  `mobile` = '$new_mobile', `email_p` = '$new_email' WHERE `id` = '$id'";
  $result = execute_sql($link, "csu_portal", $sql);

  mysqli_free_result($result);
  mysqli_close($link);
  echo "<script>window.location.href='st_profile.php';</script>";
?>
