<?php
  session_start();
  if (!isset($_COOKIE["user"])) {
    header("location: login.php");
  }
  require_once("dbtools.inc.php");
  $id = $_COOKIE["user"];
  $link = create_connection();
  $sql = "SELECT * FROM `users` WHERE `id` = '{$id}'";
  $result = execute_sql($link, "csu_portal", $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $password = $row["password"];
  }
  if (strcmp($password, $_COOKIE["password"]) != 0) {
    require_once("logout.php");
    header("location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="zh-tw">
  <head>
    <title>修改｜正修訊息網</title>
    <?php include_once "head.html"; ?>
    <link rel="stylesheet" href="assets/css/st_profile.css">
  </head>
  <body>
    <?php include_once "sidebar.php"; ?>
    <div class="home_content">
      <header>
        <i class="fas fa-edit"></i>修改個人資料
      </header>
      <?php
        error_reporting(0);
        $id = $_COOKIE["user"];
        $new_mobile = $_POST["mobile"];
        $new_email = $_POST["email"];
        $mobileErr = $emailErr = $emailErr2 = "";
        $icon1 = $icon2 = $icon3 = "";
        $count_check = 0;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          require_once("dbtools.inc.php");
          $link = create_connection();
          $sql = "SELECT * FROM `students` WHERE `id` = '{$id}'";
          $result = execute_sql($link, "csu_portal", $sql);
          //手機
          if (empty($new_mobile)) {
            $mobileErr = "請輸入手機號碼";
            $icon1 = '<i class="fas fa-exclamation-triangle"></i> ';
          } else {
            $mobile = $_POST["mobile"];
            $count_check++;
          }
          //信箱
          if (empty($new_email)) {
            $emailErr = "請輸入信箱";
            $icon2 = '<i class="fas fa-exclamation-triangle"></i> ';
          } else if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $emailErr2 = "信箱格式錯誤";
            $icon3 = '<i class="fas fa-exclamation-triangle"></i> ';
          } else {
            $email = $_POST["email"];
            $count_check++;
          }
        }
        if ($count_check == 2) {
          require_once("update_profile.php");
        }
      ?>
      <?php
        require_once("dbtools.inc.php");
        $id = $_COOKIE["user"];
        $link = create_connection();
        $sql = "SELECT * FROM `students` WHERE `id` = '{$id}'";
        $result = execute_sql($link, "csu_portal", $sql);
        while ($row = mysqli_fetch_assoc($result)) {
          $department1 = $row["department1"];
          $department2 = $row["department2"];
          $grade = $row["grade"];
          $class = $row["class"];
          $phone = $row["phone"];
          $mobile = $row["mobile"];
          $postal = $row["postal"];
          $address = $row["address"];
          $email_s = $row["email_s"];
          $email_p = $row["email_p"];
          $bank_id = $row["bank_id"];
          $bank_account = $row["bank_account"];
          $guardian = $row["guardian"];
          $g_mobile = $row["g_mobile"];
        }
        mysqli_free_result($result);
        mysqli_close($link);
      ?>
      <div class="text">
        <div class="table_title"><i class="fas fa-user"></i>基本資料</div>
        <?php
          if (!empty($mobileErr)) {
            echo '<div class="error-text">'.$icon1.$mobileErr.'</div>';
          }
          if (!empty($emailErr)) {
            echo '<div class="error-text">'.$icon2.$emailErr.'</div>';
          }
          if (!empty($emailErr2)) {
            echo '<div class="error-text">'.$icon3.$emailErr2.'</div>';
          }
        ?>
        <section class="form">
          <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="field">
              <div class="item">部別</div>
              <div class="content"><?php echo $department1 ?></div>
            </div>
            <div class="field">
              <div class="item">班級</div>
              <div class="content"><?php echo $department2.$grade.$class ?></div>
            </div>
            <div class="field">
              <div class="item">電話</div>
              <div class="content"><?php echo $phone ?></div>
            </div>
            <div class="field">
              <div class="item">手機</div>
              <div class="content"><input class="mobile" type="text" name="mobile" value="<?php echo $mobile ?>" inputmode="numeric"></div>
            </div>
            <div class="field">
              <div class="item">通訊地址</div>
              <div class="content"><?php echo $postal.$address ?></div>
            </div>
            <div class="field">
              <div class="item">校用信箱</div>
              <div class="content"><?php echo $email_s ?></div>
            </div>
            <div class="field">
              <div class="item">救援信箱</div>
              <div class="content"><input class="email" type="email" name="email" value="<?php echo $email_p ?>" style="ime-mode: disabled"></div>
            </div>
            <div class="field">
              <div class="item">監護人</div>
              <div class="content"><?php echo $guardian ?></div>
            </div>
            <div class="field">
              <div class="item">監護人手機</div>
              <div class="content"><?php echo $g_mobile ?></div>
            </div>
            <div class="field">
              <div class="item">銀行代碼</div>
              <div class="content"><?php echo $bank_id ?></div>
            </div>
            <div class="field">
              <div class="item">銀行帳號</div>
              <div class="content"><?php echo $bank_account ?></div>
            </div>
            <div class="field button">
              <input type="submit" name="submit" value="更改">
            </div>
          </form>
        </section>
      </div>
      <div class="footer">
        <a target="_blank" href="https://www.csu.edu.tw/wSite/mp?mp=10001">正修學校財團法人正修科技大學</a>｜Copyright © 2021 Infinity資訊. All rights reserved.
      </div>
    </div>
    <script type="text/javascript">
      let btn = document.querySelector('#btn');
      let sidebar = document.querySelector('.sidebar');
      btn.onclick = function() {
        sidebar.classList.toggle("active");
        dropl.classList.remove("active");
        down.classList.remove("active");
        drop2l.classList.remove("active");
        down2.classList.remove("active");
        drop3l.classList.remove("active");
        down3.classList.remove("active");
        drop4l.classList.remove("active");
        down4.classList.remove("active");
        drop5l.classList.remove("active");
        down5.classList.remove("active");
        drop6l.classList.remove("active");
        down6.classList.remove("active");
        drop7l.classList.remove("active");
        down7.classList.remove("active");
        drop8l.classList.remove("active");
        down8.classList.remove("active");
        drop9l.classList.remove("active");
        down9.classList.remove("active");
      }
    </script>
    <script src="assets/js/pass-show-hide.js"></script>
    <script src="assets/js/menu.js"></script>
  </body>
</html>
