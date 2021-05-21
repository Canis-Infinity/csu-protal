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
    <meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.75, maximum-scale=0.75">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="icon" href="images/logo_white.svg">
    <title>忘記密碼｜正修訊息網</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="https://kit.fontawesome.com/c54cdabfa4.js"></script>
  </head>
  <body>
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
      $idErr = $emailErr = "";
      $idS = $emailS = "";
      $idErr2 = $emailErr2 = "";
      $idErr3 = $emailErr3 = "";
      $icon1 = $icon2 = $icon3 = $icon4 = $icon5 = $icon6 = "";
      $count_check = 0;
      $id = $_POST["id"];
      $email = $_POST["email"];
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once("dbtools.inc.php");
        $link = create_connection();
        $sql1 = "SELECT * FROM `students` WHERE `id` = '{$id}'";
        $result1 = execute_sql($link, "csu_portal", $sql1);
        $sql2 = "SELECT * FROM `students` WHERE `id` = '{$id}' and `email_p` = '{$email}'";
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
        if (empty($email)) {
          $emailErr = "error";
          $emailErr2 = "請輸入信箱";
          $icon3 = '<i class="fas fa-exclamation-triangle"></i> ';
        } else if (mysqli_num_rows($result2) == 0) {
          $emailErr = "error";
          $emailErr3 = "信箱錯誤";
          $icon4 = '<i class="fas fa-exclamation-triangle"></i> ';
        } else {
          $emailS = "信箱正確";
          $email = $_POST["email"];
          $icon6 = '<i class="fas fa-check"></i> ';
          $count_check++;
        }
      }
      if ($count_check == 2) {
        require_once("search_pwd.php");
      }
    ?>
    <div class="wrapper">
      <section class="form login">
        <header>PORTAL FORGOT PWD</header>
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
            if (!empty($emailErr2)) {
              echo '<div class="error-text">'.$icon3.$emailErr2.'</div>';
            }
            if (!empty($emailErr3)) {
              echo '<div class="error-text">'.$icon4.$emailErr3.'</div>';
            }
            if (!empty($emailS)) {
              echo '<div class="success-text">'.$icon6.$emailS.'</div>';
            }
          ?>
          <div class="field input">
            <label>帳號</label>
            <input type="text" name="id" placeholder="輸入帳號" value="">
          </div>
          <div class="field input">
            <label>信箱<small>（非校用）</small></label>
            <input type="email" name="email" placeholder="輸入信箱" value="">
          </div>
          <div class="field button">
            <input type="submit" name="submit" value="查詢">
          </div>
        </form>
        <div class="description">核對正確後，將發送 email 至填寫的 email。</div>
        <div class="link"><a href="javascript:" onclick="history.back();"><i class="fas fa-angle-left"></i> 返回上一頁</a></div>
      </section>
    </div>
  </body>
</html>
