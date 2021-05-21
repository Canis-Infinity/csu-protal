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
    <title>個人資料｜正修訊息網</title>
    <?php include_once "head.html"; ?>
    <link rel="stylesheet" href="assets/css/st_profile.css">
    <link rel="stylesheet" href="assets/css/description.css">
  </head>
  <body>
    <?php include_once "sidebar.php"; ?>
    <div class="home_content">
      <header>
        <i class="fas fa-file-alt"></i>個人資料
      </header>
      <?php
        error_reporting(0);
        $new_pwd = $_POST["new_pwd"];
        $pwd_confirm = $_POST["pwd_confirm"];
        $pwdErr = $pwdErr2 = $pwdErr3 = $pwdErr4 = $pwdErr5 = "";
        $icon1 = $icon2 = $icon3 = $icon4 = $icon5 = "";
        $count_check = 0;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          require_once("dbtools.inc.php");
          $link = create_connection();
          $sql1 = "SELECT * FROM `users` WHERE `id` = '{$id}'";
          $result1 = execute_sql($link, "csu_portal", $sql1);
          //新密碼
          if (empty($new_pwd)) {
            $pwdErr = "請輸入新密碼";
            $icon1 = '<i class="fas fa-exclamation-triangle"></i> ';
          } else if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)..{5,}$/",$new_pwd)) {
            $pwdErr2 = "必須為英文字母大小寫、數字，且最少 6 字";
            $icon2 = '<i class="fas fa-exclamation-triangle"></i> ';
          } else if (strcmp($new_pwd, $password) == 0) {
            $pwdErr5 = "不可與當前密碼相同";
            $icon5 = '<i class="fas fa-exclamation-triangle"></i> ';
          } else {
            $new_pwd = $_POST["new_pwd"];
            $count_check++;
          }
          //密碼確認
          if (empty($pwd_confirm)) {
            $pwdErr3 = "請確認密碼";
            $icon3 = '<i class="fas fa-exclamation-triangle"></i> ';
          } else if (strcmp($new_pwd, $pwd_confirm) != 0) {
            $pwdErr4 = "密碼不相符";
            $icon4 = '<i class="fas fa-exclamation-triangle"></i> ';
          } else {
            $pwd_confirm = $_POST["pwd_confirm"];
            $count_check++;
          }
        }
        if ($count_check == 2) {
          require_once("new_pwd.php");
        }
      ?>
      <div class="text">
        <div class="table_title"><i class="fas fa-user"></i>帳戶資料</div>
        <section class="form">
          <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <?php
              if (!empty($pwdErr)) {
                echo '<div class="error-text">'.$icon1.$pwdErr.'</div>';
              }
              if (!empty($pwdErr2)) {
                echo '<div class="error-text">'.$icon2.$pwdErr2.'</div>';
              }
              if (!empty($pwdErr3)) {
                echo '<div class="error-text">'.$icon3.$pwdErr3.'</div>';
              }
              if (!empty($pwdErr4)) {
                echo '<div class="error-text">'.$icon4.$pwdErr4.'</div>';
              }
              if (!empty($pwdErr5)) {
                echo '<div class="error-text">'.$icon5.$pwdErr5.'</div>';
              }
            ?>
            <div class="field">
              <label class="item">學號</label>
              <input type="text" name="id" value="<?php echo $id; ?>" readonly>
            </div>
            <div class="field input">
              <label class="item">當前密碼</label>
              <input type="password" name="password" value="<?php echo $password; ?>" readonly>
              <i class="fas fa-eye"></i>
            </div>
            <div class="field input">
              <label class="item">新密碼</label>
              <input type="password" name="new_pwd" value="" style="ime-mode: disabled">
            </div>
            <div class="field input">
              <label class="item">確認密碼</label>
              <input type="password" name="pwd_confirm" value="" style="ime-mode: disabled">
            </div>
            <div class="field button">
              <input type="submit" name="submit" value="密碼變更">
            </div>
          </form>
        </section>
      </div>
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
        <div class="table_title"><i class="fas fa-user"></i>基本資料 <button class="modify" onclick="location.href='modify.php'">變更資料</button></div>
        <form class="" action="#" method="post">
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
            <form class="" action="mobile_update.php" method="post">
              <div class="item">手機</div>
              <div class="content"><?php echo $mobile ?></div>
            </form>
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
            <div class="content"><?php echo $email_p ?></div>
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
        </form>
        <div class="description">
          1. 銀行資料若有誤或需更改，請攜帶存摺影本與身份證明文件至出納組（行政大樓二樓）辦理。<br>
          2. 其他資料有誤請攜帶身份證明文件依部別至以下單位辦理：<br>
          (1) 日間部至註冊及課務組辦理（行政大樓三樓）；<br>
          (2) 進修部至進修部教務組辦理（圖科大樓一樓）；<br>
          (3) 院校（假日班）至進修院校教務組辦理（圖科大樓一樓）。
        </div>
      </div>
      <?php
        require_once("dbtools.inc.php");
        $id = $_COOKIE["user"];
        $link = create_connection();
        $sql2 = "SELECT * FROM `military` WHERE `id` = '{$id}'";
        $result2 = execute_sql($link, "csu_portal", $sql2);
        while ($row = mysqli_fetch_assoc($result2)) {
          $name = $row["name"];
          $status = $row["status"];
          $deadline = $row["deadline"];
          $unit = $row["unit"];
          $date = $row["date"];
          $document = $row["document"];
        }
        mysqli_free_result($result2);
        mysqli_close($link);
      ?>
      <div class="text">
        <div class="table_title"><i class="fas fa-file-alt"></i>緩徵與儘召核准文號</div>
        <div class="field">
          <div class="item">學號</div>
          <div class="content"><?php echo $id ?></div>
        </div>
        <div class="field">
          <div class="item">姓名</div>
          <div class="content"><?php echo $name ?></div>
        </div>
        <div class="field">
          <div class="item">狀態</div>
          <div class="content"><?php echo $status ?></div>
        </div>
        <div class="field">
          <div class="item">期限</div>
          <div class="content"><?php echo $deadline ?></div>
        </div>
        <div class="field">
          <div class="item">核定單位</div>
          <div class="content"><?php echo $unit ?></div>
        </div>
        <div class="field">
          <div class="item">核定日期</div>
          <div class="content"><?php echo $date ?></div>
        </div>
        <div class="field">
          <div class="item">核定文號</div>
          <div class="content"><?php echo $document ?></div>
        </div>
      </div>
      <div class="text">
        <div class="table_title"><i class="fas fa-map-marker-alt"></i>歷史登入紀錄</div>
        <div class="table ip">
          <table>
            <thead>
              <tr>
                <th><i class="fas fa-map-marker-alt"></i>IP 位址</th>
                <th><i class="fas fa-clock"></i>時間</th>
              </tr>
            </thead>
            <tbody>
              <?php
              require_once("dbtools.inc.php");
              $id = $_COOKIE["user"];
              $link = create_connection();
              $sql3 = "SELECT * FROM `login_history` WHERE `id` = '{$id}' ORDER BY `time` DESC";
              $result3 = execute_sql($link, "csu_portal", $sql3);
                if (mysqli_num_rows($result3) != 0) {
                  while ($row = mysqli_fetch_assoc($result3)) {
                    echo '<tr>';
                    echo '<td>'.$row["ip"].'</td>';
                    echo '<td>'.$row["time"].'</td>';
                    echo '</tr>';
                  }
                } else {
                  echo '<tr>';
                  echo '<td colspan="2">無登入紀錄</td>';
                  echo '</tr>';
                }
                mysqli_free_result($result3);
                mysqli_close($link);
              ?>
            </tbody>
          </table>
        </div>
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
