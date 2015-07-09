-- --------------------------------------------------------
-- 主機:                           127.0.0.1
-- 服務器版本:                        10.0.17-MariaDB - mariadb.org binary distribution
-- 服務器操作系統:                      Win64
-- HeidiSQL 版本:                  9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 導出 final_empire 的資料庫結構
CREATE DATABASE IF NOT EXISTS `final_empire` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `final_empire`;


-- 導出  表 final_empire.arena 結構
DROP TABLE IF EXISTS `arena`;
CREATE TABLE IF NOT EXISTS `arena` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `offensive_id` int(10) unsigned NOT NULL COMMENT '進攻方player id',
  `defender_id` int(10) unsigned NOT NULL COMMENT '防禦方player id',
  `winner_id` int(10) unsigned NOT NULL COMMENT '勝利方player id',
  `created_at` datetime NOT NULL COMMENT '進攻時間',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='兢技場';

-- 正在導出表  final_empire.arena 的資料：~2 rows (大約)
/*!40000 ALTER TABLE `arena` DISABLE KEYS */;
INSERT INTO `arena` (`id`, `offensive_id`, `defender_id`, `winner_id`, `created_at`) VALUES
	(1, 1, 1, 0, '2015-05-11 00:38:42'),
	(2, 1, 1, 0, '2015-05-11 00:38:58');
/*!40000 ALTER TABLE `arena` ENABLE KEYS */;


-- 導出  表 final_empire.arena_character_rel 結構
DROP TABLE IF EXISTS `arena_character_rel`;
CREATE TABLE IF NOT EXISTS `arena_character_rel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `arena_id` int(10) unsigned NOT NULL,
  `char_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='兢技場使用角色的關連table';

-- 正在導出表  final_empire.arena_character_rel 的資料：~0 rows (大約)
/*!40000 ALTER TABLE `arena_character_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `arena_character_rel` ENABLE KEYS */;


-- 導出  表 final_empire.arena_defender_team 結構
DROP TABLE IF EXISTS `arena_defender_team`;
CREATE TABLE IF NOT EXISTS `arena_defender_team` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(10) unsigned NOT NULL,
  `char_id` int(10) unsigned NOT NULL,
  `position` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `player_id_char_id_position` (`player_id`,`char_id`),
  UNIQUE KEY `player_id_position` (`player_id`,`position`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='兢技場防守隊伍';

-- 正在導出表  final_empire.arena_defender_team 的資料：~6 rows (大約)
/*!40000 ALTER TABLE `arena_defender_team` DISABLE KEYS */;
INSERT INTO `arena_defender_team` (`id`, `player_id`, `char_id`, `position`) VALUES
	(1, 1, 1, 1),
	(2, 1, 2, 2),
	(3, 2, 4, 1),
	(4, 2, 5, 2),
	(5, 2, 6, 3),
	(6, 2, 8, 4);
/*!40000 ALTER TABLE `arena_defender_team` ENABLE KEYS */;


-- 導出  表 final_empire.army 結構
DROP TABLE IF EXISTS `army`;
CREATE TABLE IF NOT EXISTS `army` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- 正在導出表  final_empire.army 的資料：~4 rows (大約)
/*!40000 ALTER TABLE `army` DISABLE KEYS */;
INSERT INTO `army` (`id`, `name`) VALUES
	(1, '戰士'),
	(2, '盜賊'),
	(3, '鏢槍手'),
	(4, '弓箭手');
/*!40000 ALTER TABLE `army` ENABLE KEYS */;


-- 導出  表 final_empire.buff 結構
DROP TABLE IF EXISTS `buff`;
CREATE TABLE IF NOT EXISTS `buff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(127) NOT NULL,
  `desc` tinytext,
  `duration` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='增益效果';

-- 正在導出表  final_empire.buff 的資料：~6 rows (大約)
/*!40000 ALTER TABLE `buff` DISABLE KEYS */;
INSERT INTO `buff` (`id`, `title`, `desc`, `duration`) VALUES
	(1, '亞馬遜之力', '提高20%造成的傷害，持續三回合', 3),
	(2, '盾牆', '減少50%受到的傷害，持續二回合', 2),
	(3, '防禦姿態', '減少10%受到的傷害', -1),
	(4, '狂暴', '提高100%傷害，持續五回合', 5),
	(5, '戒備戰吼', '護甲值提高20%', 3),
	(6, '戰爭怒吼', '攻擊力提高15%', 3),
	(7, '復仇', '反彈受到傷害的20%傷害', -1),
	(8, '勢不可擋', '受到暈眩時，在回合開始的階段恢復20%生命', -1);
/*!40000 ALTER TABLE `buff` ENABLE KEYS */;


-- 導出  表 final_empire.character 結構
DROP TABLE IF EXISTS `character`;
CREATE TABLE IF NOT EXISTS `character` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `class` tinyint(4) NOT NULL DEFAULT '1' COMMENT '職業階級',
  `type` enum('str','dex','int') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- 正在導出表  final_empire.character 的資料：~10 rows (大約)
/*!40000 ALTER TABLE `character` DISABLE KEYS */;
INSERT INTO `character` (`id`, `name`, `title`, `class`, `type`) VALUES
	(1, '霍克', NULL, 1, 'dex'),
	(2, '杜蘭', NULL, 1, 'str'),
	(3, '安琪拉', NULL, 1, 'int'),
	(4, '夏洛特', NULL, 1, 'int'),
	(5, '莉絲', NULL, 1, 'dex'),
	(6, '凱恩', NULL, 1, 'str'),
	(7, '格羅姆', NULL, 1, 'str'),
	(8, '格羅姆', '武器戰士', 2, 'str'),
	(9, '格羅姆', '守護戰士', 2, 'str'),
	(10, '格羅姆', '狂戰士', 3, 'str'),
	(11, '格羅姆', '百夫長', 3, 'str'),
	(12, '格羅姆', '戰場督軍', 3, 'str'),
	(13, '格羅姆', '巨盾勇士', 3, 'str');
/*!40000 ALTER TABLE `character` ENABLE KEYS */;


-- 導出  表 final_empire.debuff 結構
DROP TABLE IF EXISTS `debuff`;
CREATE TABLE IF NOT EXISTS `debuff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(127) NOT NULL,
  `desc` tinytext,
  `duration` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='減益狀態';

-- 正在導出表  final_empire.debuff 的資料：~6 rows (大約)
/*!40000 ALTER TABLE `debuff` DISABLE KEYS */;
INSERT INTO `debuff` (`id`, `title`, `desc`, `duration`) VALUES
	(1, '暈眩', '昏迷一回合', 1),
	(2, '燃燒', '受到70%的魔法傷害，持續三回合', 3),
	(3, '破甲', '減少護甲30%，持續三回合', 3),
	(4, '流血', '受到80%的物理傷害，持續二回合', 2),
	(5, '致死打擊', '減少50%恢復量', 3),
	(6, '狂暴', '增加50%受到的傷害', 5),
	(7, '挫志怒吼', '減少造成的傷害30%', 1);
/*!40000 ALTER TABLE `debuff` ENABLE KEYS */;


-- 導出  表 final_empire.player 結構
DROP TABLE IF EXISTS `player`;
CREATE TABLE IF NOT EXISTS `player` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 正在導出表  final_empire.player 的資料：~0 rows (大約)
/*!40000 ALTER TABLE `player` DISABLE KEYS */;
INSERT INTO `player` (`id`, `user_id`, `name`) VALUES
	(1, 1, 'odin');
/*!40000 ALTER TABLE `player` ENABLE KEYS */;


-- 導出  表 final_empire.user 結構
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `login_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 正在導出表  final_empire.user 的資料：~0 rows (大約)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `account`, `password`, `nickname`, `login_at`) VALUES
	(1, 'odin0528', 'perfect3', '李奧丁', '2015-05-09 19:03:56');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;


-- 導出  表 final_empire.user_character 結構
DROP TABLE IF EXISTS `user_character`;
CREATE TABLE IF NOT EXISTS `user_character` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(10) unsigned NOT NULL,
  `char_id` int(10) unsigned NOT NULL,
  `army_id` int(10) unsigned NOT NULL,
  `lv` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `player_id` (`player_id`,`char_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- 正在導出表  final_empire.user_character 的資料：~8 rows (大約)
/*!40000 ALTER TABLE `user_character` DISABLE KEYS */;
INSERT INTO `user_character` (`id`, `player_id`, `char_id`, `army_id`, `lv`) VALUES
	(1, 1, 1, 2, 50),
	(2, 1, 2, 1, 48),
	(3, 1, 3, 3, 47),
	(4, 2, 1, 2, 50),
	(5, 2, 2, 1, 50),
	(6, 2, 4, 4, 48),
	(7, 1, 5, 4, 49),
	(8, 2, 5, 1, 46);
/*!40000 ALTER TABLE `user_character` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
