<?php
  session_start();
  if (!isset($_COOKIE["user"])) {
    header("location: login.php");
  }
  $password = $_COOKIE["password"];
  require_once("dbtools.inc.php");
  $id = $_COOKIE["user"];
  $link = create_connection();
  $sql = "SELECT * FROM `users` WHERE `id` = '{$id}'";
  $result = execute_sql($link, "csu_portal", $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $current_password = $row["password"];
  }
  if (strcmp($password, $current_password) != 0) {
    require_once("logout.php");
    header("location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="zh-tw">
  <head>
    <title>歷年學分｜正修訊息網</title>
    <?php include_once "head.html"; ?>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/absence.css">
    <link rel="stylesheet" href="assets/css/description.css">
  </head>
  <?php include_once "head.html"; ?>
  <body>
    <?php include_once "sidebar.php"; ?>
    <div class="home_content">
      <header>
        <i class="fas fa-file-alt"></i>歷年學分
      </header>
      <div class="text">
        <div class="table_title"><i class="fas fa-file-alt"></i>學分概況</div>
        <?php
          require_once("dbtools.inc.php");
          $link = create_connection();
          $id = $_COOKIE["user"];
          $sql = "SELECT * FROM `students` WHERE `id` = '{$id}'";
          $result = execute_sql($link, "csu_portal", $sql);
          $row = mysqli_fetch_assoc($result);
          $name = $row["name"];
          //必修
          $sql2 = "SELECT `get_c` FROM `credits` WHERE `st_id` = '{$id}' AND `name` = '{$name}' AND `category` = '必修'";
          $result2 = execute_sql($link, "csu_portal", $sql2);
          $c1_a = array();
          while ($row = mysqli_fetch_assoc($result2)) {
            array_push($c1_a, $row["get_c"]);
          }
          $c1 = array_sum($c1_a);
          //選修
          $sql3 = "SELECT `get_c` FROM `credits` WHERE `st_id` = '{$id}' AND `name` = '{$name}' AND `category` = '選修'";
          $result3 = execute_sql($link, "csu_portal", $sql3);
          $c2_a = array();
          while ($row = mysqli_fetch_assoc($result3)) {
            array_push($c2_a, $row["get_c"]);
          }
          $c2 = array_sum($c2_a);
          //通識
          $sql4 = "SELECT `get_c` FROM `credits` WHERE `st_id` = '{$id}' AND `name` = '{$name}' AND `category` = '通識'";
          $result4 = execute_sql($link, "csu_portal", $sql4);
          $c3_a = array();
          while ($row = mysqli_fetch_assoc($result4)) {
            array_push($c3_a, $row["get_c"]);
          }
          $c3 = array_sum($c3_a);
          //體育
          $sql5 = "SELECT `get_c` FROM `credits` WHERE `st_id` = '{$id}' AND `name` = '{$name}' AND `category` = '體育'";
          $result5 = execute_sql($link, "csu_portal", $sql5);
          $c4_a = array();
          while ($row = mysqli_fetch_assoc($result5)) {
            array_push($c4_a, $row["get_c"]);
          }
          $c4 = array_sum($c4_a);
          mysqli_free_result($result);
          mysqli_free_result($result2);
          mysqli_free_result($result3);
          mysqli_free_result($result4);
          mysqli_free_result($result5);
          mysqli_close($link);
        ?>
        <div class="credit">
          <div class="field">
            <div class="item">實得必修學分</div>
            <div class="content"><?php echo $c1; ?></div>
          </div>
          <div class="field">
            <div class="item">實得選修學分</div>
            <div class="content"><?php echo $c2; ?></div>
          </div>
          <div class="field">
            <div class="item">實得通識學分</div>
            <div class="content"><?php echo $c3; ?></div>
          </div>
          <div class="field">
            <div class="item">實得體育學分</div>
            <div class="content"><?php echo $c4; ?></div>
          </div>
        </div>
      </div>
      <div class="text">
        <div class="table_title"><i class="fas fa-file-alt"></i>歷年學分</div>
        <div class="description">
          <div class="header">備註</div>
          <div class="content">
            本網頁僅供查詢參考，若成績或學分有任何錯誤，以註冊課務組登錄之資料為準，且本頁面不得做為何任證明之用！<br>
            成績欄如為空值或負值表示該次成績未登錄！
          </div>
        </div>
        <br>
        <div class="table">
          <table>
            <thead>
              <tr>
                <th><i class="fas fa-calendar-alt"></i>學期</th>
                <th><i class="fas fa-info-circle"></i>課程編號</th>
                <th><i class="fas fa-info-circle"></i>課程名稱</th>
                <th><i class="fas fa-check-circle"></i>學分</th>
                <th><i class="fas fa-info-circle"></i>類別</th>
                <th><i class="fas fa-check-circle"></i>期中成績</th>
                <th><i class="fas fa-check-circle"></i>學期成績</th>
                <th><i class="fas fa-info-circle"></i>狀態</th>
              </tr>
            </thead>
            <tbody>
              <?php
                require_once("dbtools.inc.php");
                $link = create_connection();
                $id = $_COOKIE["user"];
                $sql = "SELECT * FROM `students` WHERE `id` = '{$id}'";
                $result = execute_sql($link, "csu_portal", $sql);
                $row = mysqli_fetch_assoc($result);
                $name = $row["name"];
                $sql6 = "SELECT * FROM `credits` WHERE `st_id` = '{$id}' AND `name` = '{$name}' ORDER BY `id_n` DESC";
                $result6 = execute_sql($link, "csu_portal", $sql6);
                if (mysqli_num_rows($result6) != 0) {
                  while ($row = mysqli_fetch_assoc($result6)) {
                    echo '<tr>';
                    echo '<td>'.$row["year"].$row["semester"].'</td>';
                    echo '<td>'.$row["course_id"].'</td>';
                    echo '<td>'.$row["course"].'</td>';
                    echo '<td>'.$row["credit"].'</td>';
                    echo '<td>'.$row["category"].'</td>';
                    echo '<td>'.$row["midterm"].'</td>';
                    echo '<td>'.$row["score"].'</td>';
                    echo '<td>'.$row["status"].'</td>';
                    echo '</tr>';
                  }
                } else {
                  echo '<tr>';
                  echo '<td colspan="8">無歷年成績</td>';
                  echo '</tr>';
                }
                mysqli_free_result($result);
                mysqli_free_result($result6);
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
    <script src="assets/js/menu.js"></script>
  </body>
</html>
