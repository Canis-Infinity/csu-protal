<?php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  require_once("dbtools.inc.php");

  $id = $_POST["id"];
  $email = $_POST["email"];
  $from = "suiprevention@gmail.com";
  $to = $email;

  $link = create_connection();

  $sql = "SELECT * FROM `students` WHERE `id` = '{$id}' AND `email_p` = '{$email}'";
  $result = execute_sql($link, "csu_portal", $sql);

  while ($rows = mysqli_fetch_object($result)) {
    $id = $rows->id;
    $name = $rows->name;
  }

  $sql2 = "SELECT * FROM `users` WHERE `id` = '{$id}'";
  $result2 = execute_sql($link, "csu_portal", $sql2);

  while ($rows = mysqli_fetch_object($result2)) {
    $pwd = $rows->password;
  }

  $subject = "=?utf-8?B?".base64_encode("【正修訊息網】密碼查詢通知")."?=";
  $message = '<!DOCTYPE html>
<html>
  <head>
    <meta charset = "utf-8">
  </head>
  <body style="color: #333;">
    <div style="width: 100%; height: auto; display: flex; display: -webkit-flex; justify-content: center; -webkit-justify-content: center; align-items: center; -webkit-align-items: center; font-size: 120%;">
      <div style="width: 100%; background-color: #f7f7f7; border-radius: 1em;">
        <img src="https://csu-portal.bdrip.org/images/email.png" width="100%" style="border-top-right-radius: 1em; border-top-left-radius: 1em;">
        <br>
        <div style="width: 100%; padding: 2%;">
          <h1>帳號資料</h1>
          <p><span style="text-decoration: bold;">'."$name".'</span> 您好，這是您的帳戶資料：</p>
          <br>
          <table style="width: 96%;">
            <thead style="background: #D0D0D0; border-bottom: solid 1px rgba(144, 144, 144, 0.5);">
              <tr>
                <th>學號</th>
                <th>姓名</th>
                <th>密碼</th>
              </tr>
            </thead>
            <tbody>
              <tr style="background: #E8E8E8; border-left: 0; border-right: 0;">
                <td style="padding: 0.75em 0.75em;">'."$id".'</td>
                <td style="padding: 0.75em 0.75em;">'."$name".'</td>
                <td style="padding: 0.75em 0.75em;">'."$pwd".'</td>
              </tr>
            </tbody>
          </table>
          <br>
          <div style="width: 100%; text-align: center;">
            <button style="width: 50%; padding: 1%; border: none; border-radius: 5em; font-size: 120%; background: #333; color: #fff;"><a href="https://csu-portal.bdrip.org/login.php" style="color: inherit; text-decoration: none;">點此登入網站</a></button>
          </div>
          <br>
        </div>
      </div>
    </div>
  </body>
</html>
';
  $headers = "From: $from\r\n"."MIME-Version: 1.0\r\n"."Content-type: text/html; charset=utf-8\r\n";
  mail($to,$subject,$message, $headers);
  header('Location: login.php');
  mysqli_free_result($result);
  mysqli_free_result($result2);
  mysqli_close($link);
?>
