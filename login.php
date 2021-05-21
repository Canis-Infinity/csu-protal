<?php
  session_start();
  if (isset($_SESSION["remember"])) {
    header("location: index.php");
  }
?>
<!DOCTYPE html>
<html lang="zh-tw">
  <head>
    <meta charset="utf-8">
    <link rel="apple-touch-startup-image" href="images/loading.png">
    <link rel="manifest" href="manifest.json">
    <meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.75, maximum-scale=0.75">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="icon" href="images/app-icon.png">
    <title>登入｜正修訊息網</title>
    <link rel="stylesheet/scss" type="text/css" href="assets/scss/start.scss">
    <link rel="stylesheet" href="assets/css/splash.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="https://kit.fontawesome.com/c54cdabfa4.js"></script>
    <link rel="apple-touch-icon-precomposed" href="images/app-icon.png">
  </head>
  <body>
    <div class="splash"></div>
    <div class="background">
      <img src="images/moon.svg" class="moon">
      <img src="images/cloud.svg" class="cloud">
      <img src="images/tree1.svg" class="tree1">
      <img src="images/tree2.svg" class="tree2">
      <img src="images/tree3.svg" class="tree3">
      <img src="images/mountain1.svg" class="mountain1">
      <img src="images/mountain2.svg" class="mountain2">
      <img src="images/stars.svg" class="stars">
    </div>
    <?php
      error_reporting(0);
      $idErr = $pwdErr = "";
      $idS = $pwdS = "";
      $idErr2 = $pwdErr2 = "";
      $idErr3 = $pwdErr3 = "";
      $icon1 = $icon2 = $icon3 = $icon4 = $icon5 = $icon6 = "";
      $count_check = 0;
      $id = $_POST["id"];
      $password = $_POST["password"];
      $remember = $_POST["remember"];
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once("dbtools.inc.php");
        $link = create_connection();
        $sql1 = "SELECT * FROM `users` WHERE `id` = '{$id}'";
        $result1 = execute_sql($link, "csu_portal", $sql1);
        $sql2 = "SELECT * FROM `users` WHERE `id` = '{$id}' AND BINARY `password` = '{$password}'";
        $result2 = execute_sql($link, "csu_portal", $sql2);
        //帳號
        if (empty($id)) {
          $idErr = "error";
          $idErr2 = "請輸入帳號";
          $icon1 = '<i class="fas fa-exclamation-triangle"></i> ';
        } else if (mysqli_num_rows($result1) == 0) {
          $idErr = "error";
          $idErr3 = "查無此帳號";
          $icon2 = '<i class="fas fa-exclamation-triangle"></i> ';
        } else if (mysqli_num_rows($result1) != 0) {
          $idS = "帳號正確";
          $name = $_POST["name"];
          $icon5 = '<i class="fas fa-check"></i> ';
          $count_check++;
        }
        //密碼
        if (empty($password)) {
          $pwdErr = "error";
          $pwdErr2 = "請輸入密碼";
          $icon3 = '<i class="fas fa-exclamation-triangle"></i> ';
        } else if (mysqli_num_rows($result2) == 0) {
          $pwdErr = "error";
          $pwdErr3 = "密碼錯誤";
          $icon4 = '<i class="fas fa-exclamation-triangle"></i> ';
        } else {
          $pwdS = "密碼正確";
          $pwd = $_POST["password"];
          $icon6 = '<i class="fas fa-check"></i> ';
          $count_check++;
        }
        //記住我
        if (!empty($remember)) {
          $remember = $_POST["remember"];
        } else {
          $_POST["remember"] = "0";
          $remember = $_POST["remember"];
        }
      }
      if ($count_check == 2) {
        require_once("login_check.php");
      }
    ?>
    <div class="wrapper">
      <section class="form login">
        <header>PORTAL LOGIN</header>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" name="login_form">
          <?php
            if (!empty($idErr2)) {
              echo '<div class="error-text">'.$icon1.$idErr2.'</div>';
            }
            if (!empty($idErr3)) {
              echo '<div class="error-text">'.$icon2.$idErr3.'</div>';
            }
            if (!empty($idS)) {
              echo '<div class="success-text">'.$icon5.$idS.'</div>';
            }
            if (!empty($pwdErr2)) {
              echo '<div class="error-text">'.$icon3.$pwdErr2.'</div>';
            }
            if (!empty($pwdErr3)) {
              echo '<div class="error-text">'.$icon4.$pwdErr3.'</div>';
            }
            if (!empty($pwdS)) {
              echo '<div class="success-text">'.$icon6.$pwdS.'</div>';
            }
          ?>
          <div class="field input">
            <label>帳號</label>
            <input type="text" name="id" placeholder="輸入帳號" value="<?php if (isset($_COOKIE["id"])) {echo $_COOKIE["id"];} ?>" onKeyUp="value=value.replace(/[\W]/g,'')" style="ime-mode: disabled">
          </div>
          <div class="field input">
            <label>密碼</label>
            <input type="password" name="password" placeholder="輸入密碼" value="<?php if (isset($_COOKIE["id"])) {echo $_COOKIE["password"];} ?>" style="ime-mode: disabled">
            <i class="fas fa-eye"></i>
          </div>
          <div class="check">
            <input type="checkbox" name="remember" value="1" <?php if (isset($_COOKIE["id"])) {echo "checked"; } ?>/>
            <label>記住我</label>
          </div>
          <div class="field button">
            <input type="submit" name="submit" value="登入">
          </div>
        </form>
        <div class="link"><a href="search.php">忘記密碼</a></div>
      </section>
    </div>
    <script src="assets/js/pass-show-hide.js"></script>
    <script src="assets/js/start.js"></script>
  </body>
</html>
