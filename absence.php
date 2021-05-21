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
    <title>缺曠獎懲｜正修訊息網</title>
    <?php include_once "head.html"; ?>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/absence.css">
  </head>
  <?php include_once "head.html"; ?>
  <body>
    <?php include_once "sidebar.php"; ?>
    <div class="home_content">
      <header>
        <i class="fas fa-file-alt"></i>缺曠紀錄
      </header>
      <div class="text">
        <div class="table_title"><i class="fas fa-file-alt"></i>扣分說明</div>
        <div class="notice">
          <div class="field">
            <div class="item">曠課</div>
            <div class="content">1 小時，扣操行成績 0.5 分</div>
          </div>
          <div class="field">
            <div class="item">事假</div>
            <div class="content">1 小時，扣操行成績 0.1 分</div>
          </div>
          <div class="field">
            <div class="item">病假</div>
            <div class="content">1 小時，扣操行成績 0.05 分</div>
          </div>
          <div class="field">
            <div class="item">公假</div>
            <div class="content">不扣分</div>
          </div>
          <div class="field">
            <div class="item">喪假</div>
            <div class="content">不扣分</div>
          </div>
          <div class="field">
            <div class="item">分娩假</div>
            <div class="content">不扣分</div>
          </div>
          <div class="field">
            <div class="item">生理假</div>
            <div class="content">不扣分</div>
          </div>
        </div>
        <div class="table_title"><i class="fas fa-file-alt"></i>缺曠概況</div>
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
        <div class="table">
          <table class="absence">
            <thead>
              <tr>
                <th><i class="fas fa-list-ul"></i>假別</th>
                <th><i class="fas fa-info-circle"></i>數量</th>
                <th><i class="fas fa-list-ul"></i>假別</th>
                <th><i class="fas fa-info-circle"></i>數量</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>曠課</td>
                <td><?php echo $cut[0]; ?></td>
                <td>病假</td>
                <td><?php echo $sick[0]; ?></td>
              </tr>
              <tr>
                <td>事假</td>
                <td><?php echo $absence[0]; ?></td>
                <td>公假</td>
                <td><?php echo $official[0]; ?></td>
              </tr>
              <tr>
                <td>喪假</td>
                <td><?php echo $funeral[0]; ?></td>
                <td>生理假</td>
                <td><?php echo $menstrual[0]; ?></td>
              </tr>
              <tr>
                <td>產假</td>
                <td><?php echo $maternity[0]; ?></td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="table_title"><i class="fas fa-file-alt"></i>缺曠紀錄</div>
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
                $sql2 = "SELECT * FROM `rollcall` WHERE `id` = '{$id}' AND `name` = '{$name}' AND `status` = '曠課' ORDER BY `time` DESC";
                $result2 = execute_sql($link, "csu_portal", $sql2);
                if (mysqli_num_rows($result2) != 0) {
                  while ($row = mysqli_fetch_assoc($result2)) {
                    $date1 = $row["date"];
                    $showDate = date("Y/m/d", strtotime($date1));
                    echo '<tr>';
                    echo '<td>'.$showDate.'</td>';
                    echo '<td>'.$row["period"].'</td>';
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
      </div>
      <?php include_once "footer.html"; ?>
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
