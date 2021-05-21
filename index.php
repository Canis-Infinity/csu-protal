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
    <title>首頁｜正修訊息網</title>
    <?php include_once "head.html"; ?>
    <link rel="stylesheet" href="assets/css/description.css">
  </head>
  <?php include_once "head.html"; ?>
  <body>
    <?php include_once "sidebar.php"; ?>
    <div class="home_content">
      <header>
        <img src="images/logo_white2.svg">正修訊息網
      </header>
      <div class="text">
        <div class="table_title"><i class="fas fa-bullhorn"></i>最新公告</div>
        <div class="description">
          <div class="header">推廣</div>
          <div class="content">
            手機可以將訊息網<span>加入主畫面</span>喔！這樣可以做為<span>簡易 App</span> 使用！<br>
            <table>
              <tr>
                <td><span>蘋果使用者</span></td>
                <td>在 <i class="fab fa-safari"></i> Safari 開啟網站，並點選下方功能列之<img src="images/share-outline.svg" class="icon">圖示，選擇「加到主畫面」即可。</td>
              </tr>
              <tr>
                <td><span>安卓使用者</span></td>
                <td>在 <i class="fab fa-chrome"></i> Chrome 開啟網站，並點選右上方功能列之 <i class="fas fa-bars"></i> 圖示，選擇「加到主畫面」即可。</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="table_title"><i class="fas fa-file-alt"></i>近五筆曠課紀錄</div>
        <div class="table">
          <table>
            <thead>
              <tr>
                <th><i class="fas fa-calendar-alt"></i>日期</th>
                <th><i class="fas fa-list-ul"></i>節次</th>
                <th><i class="fas fa-info-circle"></i>狀態</th>
                <th><i class="fas fa-info-circle"></i>課程編號</th>
                <th><i class="fas fa-info-circle"></i>課程名稱</th>
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
                $sql2 = "SELECT * FROM `rollcall` WHERE `id` = '{$id}' AND `name` = '{$name}' AND `status` = '曠課' ORDER BY `time` DESC LIMIT 5";
                $result2 = execute_sql($link, "csu_portal", $sql2);
                if (mysqli_num_rows($result2) != 0) {
                  while ($row = mysqli_fetch_assoc($result2)) {
                    $date1 = $row["date"];
                    $showDate = date("Y/m/d", strtotime($date1));
                    echo '<tr>';
                    echo '<td>'.$showDate.'</td>';
                    echo '<td style="text-align: right;">'.$row["period"].'</td>';
                    echo '<td>'.$row["status"].'</td>';
                    echo '<td>'.$row["course_id"].'</td>';
                    echo '<td>'.$row["course"].'</td>';
                    echo '</tr>';
                  }
                } else {
                  echo '<tr>';
                  echo '<td colspan="5">無缺課紀錄</td>';
                  echo '</tr>';
                }
                mysqli_free_result($result);
                mysqli_free_result($result2);
                mysqli_close($link);
              ?>
            </tbody>
          </table>
        </div>
        <div class="table_title"><i class="fas fa-file-alt"></i>缺課紀錄</div>
        <?php
          require_once("dbtools.inc.php");
          $link = create_connection();
          $id = $_COOKIE["user"];
          $sql = "SELECT * FROM `students` WHERE `id` = '{$id}'";
          $result = execute_sql($link, "csu_portal", $sql);
          $row = mysqli_fetch_assoc($result);
          $name = $row["name"];
          //曠課
          $sql2 = "SELECT COUNT(`status`) FROM `rollcall` WHERE `id` = '{$id}' AND `name` = '{$name}' AND `status` = '曠課'";
          $result2 = execute_sql($link, "csu_portal", $sql2);
          $cut = mysqli_fetch_array($result2);
          //病假
          $sql3 = "SELECT COUNT(`status`) FROM `rollcall` WHERE `id` = '{$id}' AND `name` = '{$name}' AND `status` = '病假'";
          $result3 = execute_sql($link, "csu_portal", $sql3);
          $sick = mysqli_fetch_array($result3);
          //事假
          $sql4 = "SELECT COUNT(`status`) FROM `rollcall` WHERE `id` = '{$id}' AND `name` = '{$name}' AND `status` = '事假'";
          $result4 = execute_sql($link, "csu_portal", $sql4);
          $absence = mysqli_fetch_array($result4);
          //公假
          $sql5 = "SELECT COUNT(`status`) FROM `rollcall` WHERE `id` = '{$id}' AND `name` = '{$name}' AND `status` = '公假'";
          $result5 = execute_sql($link, "csu_portal", $sql5);
          $official = mysqli_fetch_array($result5);
          //喪假
          $sql6 = "SELECT COUNT(`status`) FROM `rollcall` WHERE `id` = '{$id}' AND `name` = '{$name}' AND `status` = '喪假'";
          $result6 = execute_sql($link, "csu_portal", $sql6);
          $funeral = mysqli_fetch_array($result6);
          //生理假
          $sql7 = "SELECT COUNT(`status`) FROM `rollcall` WHERE `id` = '{$id}' AND `name` = '{$name}' AND `status` = '生理假'";
          $result7 = execute_sql($link, "csu_portal", $sql7);
          $menstrual = mysqli_fetch_array($result7);
          //產假
          $sql8 = "SELECT COUNT(`status`) FROM `rollcall` WHERE `id` = '{$id}' AND `name` = '{$name}' AND `status` = '產假'";
          $result8 = execute_sql($link, "csu_portal", $sql8);
          $maternity = mysqli_fetch_array($result8);
          mysqli_free_result($result);
          mysqli_free_result($result2);
          mysqli_free_result($result3);
          mysqli_free_result($result4);
          mysqli_free_result($result5);
          mysqli_free_result($result6);
          mysqli_free_result($result7);
          mysqli_free_result($result8);
          mysqli_close($link);
        ?>
        <div class="wrapper">
          <div class="section">
            <div class="num"><?php echo $cut[0]; ?></div>
            <div class="type">曠課</div>
          </div>
          <div class="section">
            <div class="num"><?php echo $sick[0]; ?></div>
            <div class="type">病假</div>
          </div>
          <div class="section">
            <div class="num"><?php echo $absence[0]; ?></div>
            <div class="type">事假</div>
          </div>
          <div class="section">
            <div class="num"><?php echo $official[0]; ?></div>
            <div class="type">公假</div>
          </div>
          <div class="section">
            <div class="num"><?php echo $funeral[0]; ?></div>
            <div class="type">喪假</div>
          </div>
          <div class="section">
            <div class="num"><?php echo $menstrual[0]; ?></div>
            <div class="type">生理假</div>
          </div>
          <div class="section">
            <div class="num"><?php echo $maternity[0]; ?></div>
            <div class="type">產假</div>
          </div>
        </div>
        <div class="table_title"><i class="fas fa-link"></i>熱門連結</div>
        <div class="hot">
          <table>
            <thead>
              <tr>
                <th>編號</th>
                <th>項目</th>
                <th>類型</th>
                <th>動作</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>學校首頁</td>
                <td>外部</td>
                <td><i class="fas fa-external-link-alt" target="_blank" onclick="window.open('https://www.csu.edu.tw/wSite/mp?mp=10001')"></i></td>
              </tr>
              <tr>
                <td>2</td>
                <td>修課成績</td>
                <td>內部</td>
                <td><i class="fas fa-external-link-alt" onclick="location.href='credit.php'"></i></td>
              </tr>
              <tr>
                <td>3</td>
                <td>缺曠獎懲</td>
                <td>內部</td>
                <td><i class="fas fa-external-link-alt" onclick="location.href='absence.php'"></i></td>
              </tr>
              <tr>
                <td>4</td>
                <td>個人課表</td>
                <td>內部</td>
                <td><i class="fas fa-external-link-alt" onclick="location.href='timetable.php'"></i></td>
              </tr>
              <tr>
                <td>5</td>
                <td>歷年學分</td>
                <td>內部</td>
                <td><i class="fas fa-external-link-alt" onclick="location.href='credits.php'"></i></td>
              </tr>
              <tr>
                <td>6</td>
                <td>選課系統</td>
                <td>外部</td>
                <td><i class="fas fa-external-link-alt" target="_blank" onclick="window.open('')"></i></td>
              </tr>
              <tr>
                <td>7</td>
                <td>線上請假系統</td>
                <td>外部</td>
                <td><i class="fas fa-external-link-alt" target="_blank" onclick="window.open('http://notice.csu.edu.tw/Main/stuLeaveDay/Student/StuAbsAppForm.aspx')"></i></td>
              </tr>
              <tr>
                <td>8</td>
                <td>Eclass 2.0</td>
                <td>外部</td>
                <td><i class="fas fa-external-link-alt" target="_blank" onclick="window.open('https://eclass2.csu.edu.tw/')"></i></td>
              </tr>
              <tr>
                <td>9</td>
                <td>ilms</td>
                <td>外部</td>
                <td><i class="fas fa-external-link-alt" target="_blank" onclick="window.open('https://ilms.csu.edu.tw/')"></i></td>
              </tr>
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
