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
    <title>個人課表｜正修訊息網</title>
    <?php include_once "head.html"; ?>
    <link rel="stylesheet" href="assets/css/timetable.css">
  </head>
  <body>
    <?php include_once "sidebar.php"; ?>
    <div class="home_content">
      <header>
        <i class="fas fa-table"></i>個人課表
      </header>
      <div class="text">
        <!-- <div class="table_title"><i class="fas fa-table"></i>個人課表</div> -->
        <div class="time_table">
          <table>
            <thead>
              <tr>
                <th>時間</th>
                <th>一</th>
                <th>二</th>
                <th>三</th>
                <th>四</th>
                <th>五</th>
                <th>六</th>
                <th>日</th>
              </tr>
            </thead>
            <tbody>
              <?php
                require_once("dbtools.inc.php");
                $link = create_connection();
                $id = $_COOKIE["user"];
                $sql = "SELECT * FROM `choose` WHERE `st_id` = '{$id}'";
                $result = execute_sql($link, "csu_portal", $sql);
                $row = mysqli_fetch_assoc($result);
                $name = $row["name"];
                $s = 8;
                $e = 9;
                for ($p = 1; $p <= 9; $p++) {
                  echo '<tr>';
                  if ($s < 10 AND $e < 10) {
                    echo '<td>0'.$s.':10<br>-<br>0'.$e.':00</td>';
                  } else if ($s < 10 AND $e >= 10) {
                    echo '<td>0'.$s.':10<br>-<br>'.$e.':00</td>';
                  } else {
                    echo '<td>'.$s.':10<br>-<br>'.$e.':00</td>';
                  }
                  for ($w = 1; $w <= 7; $w++) {
                    //echo $i;
                    $sql2 = "SELECT * FROM `choose` WHERE `st_id` = '{$id}' AND `name` = '{$name}' AND `weekday` = '{$w}' AND `period` = '{$p}'";
                    $result2 = execute_sql($link, "csu_portal", $sql2);
                    $row = mysqli_fetch_assoc($result2);
                    if (mysqli_num_rows($result2) == 0) {
                      echo '<td></td>';
                    } else {
                      echo '<td>'.$row["course"].'<br>'.$row["course_id"].'<br>'.$row["teacher"].'<br>'.$row["location"].'</td>';
                    }
                  }
                  mysqli_free_result($result2);
                  echo '</tr>';
                  $s++;
                  $e++;
                }
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
