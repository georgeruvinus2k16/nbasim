/*
SQLyog Enterprise - MySQL GUI v6.07
Host - 5.5.5-10.1.13-MariaDB : Database - season_db
*********************************************************************
Server version : 5.5.5-10.1.13-MariaDB
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `season_db`;

USE `season_db`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `playoff_head` */

DROP TABLE IF EXISTS `playoff_head`;

CREATE TABLE `playoff_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playoff_yr` year(4) DEFAULT NULL,
  `season_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `playoff_head` */

/*Table structure for table `playoff_match` */

DROP TABLE IF EXISTS `playoff_match`;

CREATE TABLE `playoff_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pl_id` int(11) DEFAULT NULL,
  `ea1f` int(11) DEFAULT NULL,
  `ea1` varchar(3) DEFAULT NULL,
  `ea1d` int(11) DEFAULT NULL,
  `eb1f` int(11) DEFAULT NULL,
  `eb1` varchar(3) DEFAULT NULL,
  `eb1d` int(11) DEFAULT NULL,
  `ec1f` int(11) DEFAULT NULL,
  `ec1` varchar(3) DEFAULT NULL,
  `ec1d` int(11) DEFAULT NULL,
  `ed1f` int(11) DEFAULT NULL,
  `ed1` varchar(3) DEFAULT NULL,
  `ed1d` int(11) DEFAULT NULL,
  `ea2` int(11) DEFAULT NULL,
  `esfa2` varchar(3) DEFAULT NULL,
  `eb2` int(11) DEFAULT NULL,
  `ec2` int(11) DEFAULT NULL,
  `esfb2` varchar(3) DEFAULT NULL,
  `ed2` int(11) DEFAULT NULL,
  `esfa` int(11) DEFAULT NULL,
  `esf` varchar(3) DEFAULT NULL,
  `esfb` int(11) DEFAULT NULL,
  `ecp` int(11) DEFAULT NULL,
  `nbafc` int(11) DEFAULT NULL,
  `nbafs` varchar(3) DEFAULT NULL,
  `wcp` int(11) DEFAULT NULL,
  `wsfa` int(11) DEFAULT NULL,
  `wsf` varchar(3) DEFAULT NULL,
  `wsfb` int(11) DEFAULT NULL,
  `wa2` int(11) DEFAULT NULL,
  `wsfa2` varchar(3) DEFAULT NULL,
  `wb2` int(11) DEFAULT NULL,
  `wc2` int(11) DEFAULT NULL,
  `wsfb2` varchar(3) DEFAULT NULL,
  `wd2` int(11) DEFAULT NULL,
  `wa1f` int(11) DEFAULT NULL,
  `wa1` varchar(3) DEFAULT NULL,
  `wa1d` int(11) DEFAULT NULL,
  `wb1f` int(11) DEFAULT NULL,
  `wb1` varchar(3) DEFAULT NULL,
  `wb1d` int(11) DEFAULT NULL,
  `wc1f` int(11) DEFAULT NULL,
  `wc1` varchar(3) DEFAULT NULL,
  `wc1d` int(11) DEFAULT NULL,
  `wd1f` int(11) DEFAULT NULL,
  `wd1` varchar(3) DEFAULT NULL,
  `wd1d` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `playoff_match` */

/*Table structure for table `playoff_matchups` */

DROP TABLE IF EXISTS `playoff_matchups`;

CREATE TABLE `playoff_matchups` (
  `pl_id` int(11) DEFAULT NULL,
  `match_code` varchar(8) DEFAULT NULL,
  `fav` int(11) DEFAULT NULL,
  `dog` int(11) DEFAULT NULL,
  `matchups` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `playoff_matchups` */

/*Table structure for table `playoff_teams` */

DROP TABLE IF EXISTS `playoff_teams`;

CREATE TABLE `playoff_teams` (
  `pl_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `seed` int(11) DEFAULT NULL,
  `record` varchar(5) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `finish` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `playoff_teams` */

/*Table structure for table `season_cards` */

DROP TABLE IF EXISTS `season_cards`;

CREATE TABLE `season_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `season_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `wins` float DEFAULT NULL,
  `losses` float DEFAULT NULL,
  `games_left` float DEFAULT NULL,
  `team_rating` float DEFAULT NULL,
  `draft` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `season_cards` */

/*Table structure for table `season_games` */

DROP TABLE IF EXISTS `season_games`;

CREATE TABLE `season_games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `season_id` int(11) DEFAULT NULL,
  `home_team` int(11) DEFAULT NULL,
  `road_team` int(11) DEFAULT NULL,
  `winner` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `season_games` */

/*Table structure for table `seasons` */

DROP TABLE IF EXISTS `seasons`;

CREATE TABLE `seasons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `season_yr` year(4) DEFAULT NULL,
  `gamestoplay` float DEFAULT NULL,
  `eastchamp` int(11) DEFAULT NULL,
  `westchamp` int(11) DEFAULT NULL,
  `nbachamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `seasons` */

/*Table structure for table `teams` */

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `division` varchar(20) DEFAULT NULL,
  `cities` varchar(50) DEFAULT NULL,
  `names` varchar(50) DEFAULT NULL,
  `abbs` varchar(3) DEFAULT NULL,
  `bg_color` varchar(7) DEFAULT NULL,
  `font_color` varchar(7) DEFAULT NULL,
  `conf` enum('east','west') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

/*Data for the table `teams` */

insert  into `teams`(`id`,`division`,`cities`,`names`,`abbs`,`bg_color`,`font_color`,`conf`) values (1,'ATLANTIC','BOSTON','CELTICS','BOS','#339933','#FFFFFF','east'),(2,'ATLANTIC','BROOKLYN','NETS','BKN','#000033','#FFFFFF','east'),(3,'ATLANTIC','NEW YORK','KNICKS','NYK','#3333CC','#FFCC33','east'),(4,'ATLANTIC','PHILADELPHIA','76ers','PHI','#FF0033','#3399FF','east'),(5,'ATLANTIC','TORONTO','RAPTORS','TOR','#FF0033','#FFFFFF','east'),(6,'CENTRAL','CLEVELAND','CAVALIERS','CLE','#FF0033','#CCFF00','east'),(7,'CENTRAL','CHICAGO','BULLS','CHI','#FF0000','#000000','east'),(8,'CENTRAL','DETROIT','PISTONS','DET','#3366FF','#990000','east'),(9,'CENTRAL','INDIANA','PACERS','IND','#CCFF00','#000066','east'),(10,'CENTRAL','MILWAUKEE','BUCKS','MIL','#336633','#FFFFFF','east'),(11,'SOUTHEAST','MIAMI','HEAT','MIA','#CC0000','#FFFFFF','east'),(12,'SOUTHEAST','ATLANTA','HAWKS','ATL','#000099','#FF3333','east'),(13,'SOUTHEAST','CHARLOTTE','HORNETS','CHA','#000099','#00CCFF','east'),(14,'SOUTHEAST','ORLANDO','MAGIC','ORL','#6600FF','#FFFFFF','east'),(15,'SOUTHEAST','WASHINGTON','WIZARDS','WAS','#FF0033','#000099','east'),(16,'PACIFIC','SACRAMENTO','KINGS','SAC','#0033CC','#FFFFFF','west'),(17,'PACIFIC','PHOENIX','SUNS','PHX','#FF9933','#330099','west'),(18,'PACIFIC','LOS ANGELES','LAKERS','LAL','#CCFF33','#6600CC','west'),(19,'PACIFIC','LOS ANGELES','CLIPPERS','LAC','#3300CC','#FF6699','west'),(20,'PACIFIC','GOLDEN STATE','WARRIORS','GSW','#0000CC','#CCFF33','west'),(21,'NORTHWEST','UTAH','JAZZ','UTA','#333300','#99FF00','west'),(22,'NORTHWEST','OKCLAHOMA CITY','THUNDER','OKC','#3366FF','#FFFFFF','west'),(23,'NORTHWEST','PORTLAND','TRAILBLAZERS','POR','#000000','#FF0000','west'),(24,'NORTHWEST','MINNESOTA','TIMBERWOLVES','MIN','#003366','#FFFFFF','west'),(25,'NORTHWEST','DENVER','NUGGETS','DEN','#3399FF','#FFFF33','west'),(26,'SOUTHWEST','SAN ANTONIO','SPURS','SAS','#000000','#CCFFFF','west'),(27,'SOUTHWEST','NEW ORLEANS','PELICANS','NOP','#000066','#CCFF99','west'),(28,'SOUTHWEST','MEMPHIS','GRIZZLIES','MEM','#0033CC','#99CCFF','west'),(29,'SOUTHWEST','HOUSTON','ROCKETS','HOU','#FF0033','#00FFFF','west'),(30,'SOUTHWEST','DALLAS','MAVERICKS','DAL','#000066','#00FFFF','west');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
