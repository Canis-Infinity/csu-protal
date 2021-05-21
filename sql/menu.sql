-- --------------------------------------------------------
-- 主機:                           127.0.0.1
-- 伺服器版本:                        10.4.11-MariaDB - mariadb.org binary distribution
-- 伺服器作業系統:                      Win64
-- HeidiSQL 版本:                  11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- 傾印  資料表 csu_portal.menu 結構
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `href` varchar(200) NOT NULL DEFAULT '#',
  `target` varchar(50) NOT NULL,
  `icon` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 正在傾印表格  csu_portal.menu 的資料：~34 rows (近似值)
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
REPLACE INTO `menu` (`id`, `parent_id`, `name`, `href`, `target`, `icon`) VALUES
	(100, 0, '熱門服務', '#', '', '<i class="fas fa-chevron-down"></i>'),
	(101, 100, '個人課表', 'timetable.php', '', '<i class="fas fa-calendar-alt"></i>'),
	(102, 100, '修課成績', 'credit.php', '', '<i class="fas fa-graduation-cap"></i>'),
	(103, 100, '缺曠獎懲', 'absence.php', '', '<i class="far fa-file"></i>'),
	(104, 100, '歷年學分', 'credits.php', '', '<i class="fas fa-graduation-cap"></i>'),
	(105, 100, '線上請假系統', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(106, 100, 'Eclass 2.0', 'https://eclass2.csu.edu.tw/', '_blank', '<i class="fas fa-graduation-cap"></i>'),
	(107, 100, 'ilms', 'https://ilms.csu.edu.tw/', '_blank', '<i class="fas fa-graduation-cap"></i>'),
	(200, 0, '教務資訊', '#', '', '<i class="fas fa-chevron-down"></i>'),
	(201, 200, '選課系統', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(202, 200, '學分抵免系統', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(203, 200, '課程大綱查詢', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(204, 200, '教學日誌填報', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(205, 200, '期末教學評量', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(206, 200, '課程地圖規劃', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(207, 200, '學分學程申請', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(208, 200, '暑修選課', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(300, 0, '學務資訊', '#', '', '<i class="fas fa-chevron-down"></i>'),
	(301, 300, '個人資料', 'st_profile.php', '', '<i class="fas fa-user"></i>'),
	(302, 300, '導師回饋問卷', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(303, 300, 'GPS 學生檔案', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(304, 300, 'GPS 學生學習歷程檔案', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(305, 300, 'UCAN 職能測驗', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(306, 300, 'UCAN 平台官網', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(307, 300, '預警通知系統', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(308, 300, '服務學習系統', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(309, 300, '勞作教育系統', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(310, 300, '校外實習適應量表', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(311, 300, '學雜費減免系統', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(312, 300, '宿舍管理系統', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(313, 300, '居住現況調查', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(314, 300, '弱勢助學申請系統', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(315, 300, '學生宿舍資訊網', '#', '', '<i class="fas fa-graduation-cap"></i>'),
	(316, 300, '學生會官網', '#', '', '<i class="fas fa-graduation-cap"></i>');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
