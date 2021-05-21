<?php
  session_start();
  unset($_SESSION["remember"]);
  unset($_cookie["id"]);
  unset($_cookie["password"]);
  header("location: login.php");
?>
