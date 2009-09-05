-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.36-community-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema attendance
--

CREATE DATABASE IF NOT EXISTS attendance;
USE attendance;

--
-- Temporary table structure for view `v_achievement_children`
--
DROP TABLE IF EXISTS `v_achievement_children`;
DROP VIEW IF EXISTS `v_achievement_children`;
CREATE TABLE `v_achievement_children` (
  `id` int(10) unsigned,
  `children` bigint(21)
);

--
-- Temporary table structure for view `v_achievements`
--
DROP TABLE IF EXISTS `v_achievements`;
DROP VIEW IF EXISTS `v_achievements`;
CREATE TABLE `v_achievements` (
  `id` int(10) unsigned,
  `category` varchar(50),
  `image` varchar(50),
  `name` varchar(50),
  `description` varchar(50),
  `goal` int(10) unsigned,
  `points` int(10) unsigned,
  `added` date,
  `lock` tinyint(1)
);

--
-- Temporary table structure for view `v_achievements_earned`
--
DROP TABLE IF EXISTS `v_achievements_earned`;
DROP VIEW IF EXISTS `v_achievements_earned`;
CREATE TABLE `v_achievements_earned` (
  `id` int(10) unsigned,
  `member_id` int(10) unsigned,
  `achievement` int(10) unsigned,
  `category_id` int(10) unsigned,
  `category` varchar(50),
  `name` varchar(50),
  `description` varchar(50),
  `image` varchar(50),
  `progress` int(10) unsigned,
  `points` int(10) unsigned,
  `updated` date,
  `member` varchar(100)
);

--
-- Temporary table structure for view `v_achievements_earned_all`
--
DROP TABLE IF EXISTS `v_achievements_earned_all`;
DROP VIEW IF EXISTS `v_achievements_earned_all`;
CREATE TABLE `v_achievements_earned_all` (
  `id` int(10) unsigned,
  `member_id` int(10) unsigned,
  `achievement` int(10) unsigned,
  `category_id` int(10) unsigned,
  `category` varchar(50),
  `name` varchar(50),
  `description` varchar(50),
  `image` varchar(50),
  `progress` int(10) unsigned,
  `points` int(10) unsigned,
  `updated` date,
  `member` varchar(100)
);

--
-- Temporary table structure for view `v_attendance`
--
DROP TABLE IF EXISTS `v_attendance`;
DROP VIEW IF EXISTS `v_attendance`;
CREATE TABLE `v_attendance` (
  `id` int(10) unsigned,
  `meeting` int(10) unsigned,
  `position_id` int(10) unsigned,
  `name` varchar(100),
  `position` varchar(45),
  `status` int(10) unsigned,
  `vote` tinyint(1),
  `present` tinyint(1),
  `quorum` int(4)
);

--
-- Temporary table structure for view `v_committee_children`
--
DROP TABLE IF EXISTS `v_committee_children`;
DROP VIEW IF EXISTS `v_committee_children`;
CREATE TABLE `v_committee_children` (
  `id` int(10) unsigned,
  `children` bigint(21)
);

--
-- Temporary table structure for view `v_committees`
--
DROP TABLE IF EXISTS `v_committees`;
DROP VIEW IF EXISTS `v_committees`;
CREATE TABLE `v_committees` (
  `id` int(10) unsigned,
  `manager` varchar(100),
  `name` varchar(50),
  `description` varchar(255),
  `members` bigint(21)
);

--
-- Temporary table structure for view `v_meetings`
--
DROP TABLE IF EXISTS `v_meetings`;
DROP VIEW IF EXISTS `v_meetings`;
CREATE TABLE `v_meetings` (
  `id` int(10) unsigned,
  `mdate` date,
  `meeting_type` varchar(45),
  `year` char(4),
  `semester` varchar(8),
  `description` varchar(255),
  `semester_id` int(10) unsigned,
  `meeting_type_id` int(10) unsigned
);

--
-- Temporary table structure for view `v_meetings_children`
--
DROP TABLE IF EXISTS `v_meetings_children`;
DROP VIEW IF EXISTS `v_meetings_children`;
CREATE TABLE `v_meetings_children` (
  `id` int(10) unsigned,
  `children` bigint(21)
);

--
-- Temporary table structure for view `v_member_dd`
--
DROP TABLE IF EXISTS `v_member_dd`;
DROP VIEW IF EXISTS `v_member_dd`;
CREATE TABLE `v_member_dd` (
  `member` int(10) unsigned,
  `name` varchar(148),
  `meeting_type` int(10) unsigned
);

--
-- Temporary table structure for view `v_members`
--
DROP TABLE IF EXISTS `v_members`;
DROP VIEW IF EXISTS `v_members`;
CREATE TABLE `v_members` (
  `id` int(10) unsigned,
  `name` varchar(100),
  `ulink` varchar(45),
  `position` varchar(45),
  `status` varchar(45),
  `position_id` int(10) unsigned,
  `vote` tinyint(1),
  `quorum` int(4)
);

--
-- Temporary table structure for view `v_members_non`
--
DROP TABLE IF EXISTS `v_members_non`;
DROP VIEW IF EXISTS `v_members_non`;
CREATE TABLE `v_members_non` (
  `id` int(10) unsigned,
  `name` varchar(100),
  `ulink` varchar(45),
  `position` varchar(45),
  `status` varchar(45),
  `vote` tinyint(1),
  `quorum` int(4)
);

--
-- Temporary table structure for view `v_members_require`
--
DROP TABLE IF EXISTS `v_members_require`;
DROP VIEW IF EXISTS `v_members_require`;
CREATE TABLE `v_members_require` (
  `member` int(10) unsigned,
  `position` int(10) unsigned,
  `status` int(10) unsigned,
  `meeting_type` int(10) unsigned
);

--
-- Temporary table structure for view `v_quorum`
--
DROP TABLE IF EXISTS `v_quorum`;
DROP VIEW IF EXISTS `v_quorum`;
CREATE TABLE `v_quorum` (
  `meeting` int(10) unsigned,
  `TotalMembers` bigint(21),
  `TotalPresent` decimal(25,0),
  `VotingMembers` decimal(25,0),
  `VotingPresent` decimal(25,0),
  `Quorum` decimal(17,0),
  `QuorumTest` int(1)
);

--
-- Temporary table structure for view `v_quorum_interum`
--
DROP TABLE IF EXISTS `v_quorum_interum`;
DROP VIEW IF EXISTS `v_quorum_interum`;
CREATE TABLE `v_quorum_interum` (
  `meeting` int(10) unsigned,
  `TotalMembers` bigint(21),
  `TotalPresent` decimal(25,0),
  `VotingMembers` decimal(25,0),
  `VotingPresent` decimal(25,0),
  `Quorum` decimal(17,0)
);

--
-- Temporary table structure for view `v_reports_member_details`
--
DROP TABLE IF EXISTS `v_reports_member_details`;
DROP VIEW IF EXISTS `v_reports_member_details`;
CREATE TABLE `v_reports_member_details` (
  `member` int(10) unsigned,
  `meeting_id` int(10) unsigned,
  `mdate` date,
  `semester` varchar(13),
  `meeting_type` varchar(45),
  `position` varchar(45),
  `name` varchar(100),
  `status` varchar(45)
);

--
-- Temporary table structure for view `v_reports_member_summary`
--
DROP TABLE IF EXISTS `v_reports_member_summary`;
DROP VIEW IF EXISTS `v_reports_member_summary`;
CREATE TABLE `v_reports_member_summary` (
  `member` int(10) unsigned,
  `semester` varchar(13),
  `startday` date,
  `meeting_type` varchar(45),
  `position` varchar(45),
  `name` varchar(100),
  `Unknown` decimal(23,0),
  `Present` decimal(23,0),
  `Absent` decimal(23,0),
  `Excused` decimal(23,0),
  `CoOp` decimal(23,0),
  `warning` int(1),
  `trouble` int(1)
);

--
-- Temporary table structure for view `v_semester_children`
--
DROP TABLE IF EXISTS `v_semester_children`;
DROP VIEW IF EXISTS `v_semester_children`;
CREATE TABLE `v_semester_children` (
  `id` int(10) unsigned,
  `children` bigint(21)
);

--
-- Temporary table structure for view `v_standing_a`
--
DROP TABLE IF EXISTS `v_standing_a`;
DROP VIEW IF EXISTS `v_standing_a`;
CREATE TABLE `v_standing_a` (
  `id` int(10) unsigned,
  `semester` int(10) unsigned,
  `meeting` int(10) unsigned,
  `meeting_type` int(10) unsigned,
  `mdate` date,
  `member` int(10) unsigned,
  `vote` tinyint(1),
  `status` int(10) unsigned
);

--
-- Temporary table structure for view `v_standing_b`
--
DROP TABLE IF EXISTS `v_standing_b`;
DROP VIEW IF EXISTS `v_standing_b`;
CREATE TABLE `v_standing_b` (
  `id` int(10) unsigned,
  `semester` int(10) unsigned,
  `meeting` int(10) unsigned,
  `meeting_type` int(10) unsigned,
  `mdate` date,
  `member` int(10) unsigned,
  `vote` tinyint(1),
  `status` int(10) unsigned,
  `status2` decimal(11,0),
  `status3` decimal(11,0)
);

--
-- Temporary table structure for view `v_standing_c`
--
DROP TABLE IF EXISTS `v_standing_c`;
DROP VIEW IF EXISTS `v_standing_c`;
CREATE TABLE `v_standing_c` (
  `semester` int(10) unsigned,
  `meeting_type` int(10) unsigned,
  `member` int(10) unsigned,
  `absent` decimal(23,0)
);

--
-- Temporary table structure for view `v_standing_d`
--
DROP TABLE IF EXISTS `v_standing_d`;
DROP VIEW IF EXISTS `v_standing_d`;
CREATE TABLE `v_standing_d` (
  `semester` int(10) unsigned,
  `meeting_type` int(10) unsigned,
  `member` int(10) unsigned,
  `warning` int(1),
  `trouble` int(1)
);

--
-- Temporary table structure for view `v_standing_e`
--
DROP TABLE IF EXISTS `v_standing_e`;
DROP VIEW IF EXISTS `v_standing_e`;
CREATE TABLE `v_standing_e` (
  `semester` int(10) unsigned,
  `meeting_type` int(10) unsigned,
  `member` int(10) unsigned,
  `warning` int(1),
  `trouble` int(1)
);

--
-- Temporary table structure for view `v_standing_f`
--
DROP TABLE IF EXISTS `v_standing_f`;
DROP VIEW IF EXISTS `v_standing_f`;
CREATE TABLE `v_standing_f` (
  `type` varchar(11),
  `semester` int(11) unsigned,
  `meeting_type` int(11) unsigned,
  `member` int(11) unsigned,
  `warning` int(11),
  `trouble` int(11)
);

--
-- Temporary table structure for view `v_standing_g`
--
DROP TABLE IF EXISTS `v_standing_g`;
DROP VIEW IF EXISTS `v_standing_g`;
CREATE TABLE `v_standing_g` (
  `semester` int(11) unsigned,
  `meeting_type` int(11) unsigned,
  `member` int(11) unsigned,
  `warning` int(1),
  `trouble` int(1)
);

--
-- Definition of table `achievement_category`
--

DROP TABLE IF EXISTS `achievement_category`;
CREATE TABLE `achievement_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_achievement_category_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `achievement_category`
--

/*!40000 ALTER TABLE `achievement_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `achievement_category` ENABLE KEYS */;


--
-- Definition of table `achievements`
--

DROP TABLE IF EXISTS `achievements`;
CREATE TABLE `achievements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `goal` int(10) unsigned NOT NULL,
  `points` int(10) unsigned NOT NULL,
  `added` date NOT NULL,
  `lock` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_achievement_names` (`name`) USING BTREE,
  KEY `FK_achievements_category` (`category`),
  CONSTRAINT `FK_achievements_category` FOREIGN KEY (`category`) REFERENCES `achievement_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `achievements`
--

/*!40000 ALTER TABLE `achievements` DISABLE KEYS */;
/*!40000 ALTER TABLE `achievements` ENABLE KEYS */;


--
-- Definition of table `achievements_earned`
--

DROP TABLE IF EXISTS `achievements_earned`;
CREATE TABLE `achievements_earned` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member` int(10) unsigned NOT NULL,
  `achievement` int(10) unsigned NOT NULL,
  `progress` int(10) unsigned NOT NULL,
  `updated` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_achievement_member` (`member`,`achievement`) USING BTREE,
  KEY `FK_achievements_earned_achievement` (`achievement`),
  CONSTRAINT `FK_achievements_earned_achievement` FOREIGN KEY (`achievement`) REFERENCES `achievements` (`id`),
  CONSTRAINT `FK_achievements_earned_member` FOREIGN KEY (`member`) REFERENCES `members` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `achievements_earned`
--

/*!40000 ALTER TABLE `achievements_earned` DISABLE KEYS */;
/*!40000 ALTER TABLE `achievements_earned` ENABLE KEYS */;


--
-- Definition of table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meeting` int(10) unsigned NOT NULL,
  `member` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_attendance` (`meeting`,`member`),
  KEY `FK_member` (`member`),
  KEY `FK_status` (`status`),
  KEY `FK_position_a` (`position`),
  CONSTRAINT `FK_meeting` FOREIGN KEY (`meeting`) REFERENCES `meetings` (`id`),
  CONSTRAINT `FK_member` FOREIGN KEY (`member`) REFERENCES `members` (`id`),
  CONSTRAINT `FK_position_a` FOREIGN KEY (`position`) REFERENCES `position` (`id`),
  CONSTRAINT `FK_status` FOREIGN KEY (`status`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=616 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;


--
-- Definition of table `committee_membership`
--

DROP TABLE IF EXISTS `committee_membership`;
CREATE TABLE `committee_membership` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `committee` int(10) unsigned NOT NULL,
  `member` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_committee_member` (`committee`,`member`),
  KEY `FK_committee_membership_member` (`member`),
  CONSTRAINT `FK_committee_membership_committee` FOREIGN KEY (`committee`) REFERENCES `committees` (`id`),
  CONSTRAINT `FK_committee_membership_member` FOREIGN KEY (`member`) REFERENCES `members` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `committee_membership`
--

/*!40000 ALTER TABLE `committee_membership` DISABLE KEYS */;
/*!40000 ALTER TABLE `committee_membership` ENABLE KEYS */;


--
-- Definition of table `committees`
--

DROP TABLE IF EXISTS `committees`;
CREATE TABLE `committees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `manager` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_committees_manager` (`manager`),
  CONSTRAINT `FK_committees_manager` FOREIGN KEY (`manager`) REFERENCES `members` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `committees`
--

/*!40000 ALTER TABLE `committees` DISABLE KEYS */;
/*!40000 ALTER TABLE `committees` ENABLE KEYS */;



--
-- Definition of table `form`
--

DROP TABLE IF EXISTS `form`;
CREATE TABLE `form` (
  `key` varchar(50) NOT NULL,
  `expires` datetime NOT NULL,
  `name` varchar(50) NOT NULL,
  `session` varchar(50) NOT NULL,
  `pk` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`key`),
  KEY `Index_form_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `form`
--

/*!40000 ALTER TABLE `form` DISABLE KEYS */;
/*!40000 ALTER TABLE `form` ENABLE KEYS */;


--
-- Definition of table `meeting_type`
--

DROP TABLE IF EXISTS `meeting_type`;
CREATE TABLE `meeting_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meeting_type`
--

/*!40000 ALTER TABLE `meeting_type` DISABLE KEYS */;
INSERT INTO `meeting_type` (`id`,`name`) VALUES 
 (3,'Council Event'),
 (2,'Directors Meeting'),
 (1,'General Business Meeting');
/*!40000 ALTER TABLE `meeting_type` ENABLE KEYS */;


--
-- Definition of table `meetings`
--

DROP TABLE IF EXISTS `meetings`;
CREATE TABLE `meetings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mdate` date NOT NULL,
  `meeting_type` int(10) unsigned NOT NULL,
  `semester` int(10) unsigned NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `lock` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_date_type` (`mdate`,`meeting_type`) USING BTREE,
  KEY `FK_meeting_type` (`meeting_type`),
  KEY `FK_semester` (`semester`),
  CONSTRAINT `FK_meeting_type` FOREIGN KEY (`meeting_type`) REFERENCES `meeting_type` (`id`),
  CONSTRAINT `FK_semester` FOREIGN KEY (`semester`) REFERENCES `semester` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meetings`
--

/*!40000 ALTER TABLE `meetings` DISABLE KEYS */;
/*!40000 ALTER TABLE `meetings` ENABLE KEYS */;


--
-- Definition of table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `ulink` varchar(45) NOT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT '20',
  `status` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Unique_Ulink` (`ulink`) USING BTREE,
  KEY `FK_status_m` (`status`),
  KEY `FK_position` (`position`) USING BTREE,
  CONSTRAINT `FK_position_m` FOREIGN KEY (`position`) REFERENCES `position` (`id`),
  CONSTRAINT `FK_status_m` FOREIGN KEY (`status`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

/*!40000 ALTER TABLE `members` DISABLE KEYS */;
/*!40000 ALTER TABLE `members` ENABLE KEYS */;


--
-- Definition of table `position`
--

DROP TABLE IF EXISTS `position`;
CREATE TABLE `position` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `vote` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

/*!40000 ALTER TABLE `position` DISABLE KEYS */;
INSERT INTO `position` (`id`,`name`,`vote`) VALUES 
 (1,'President',0),
 (2,'Vice-President',1),
 (3,'Director of Administration',1),
 (4,'Director of Corporate and Alumni Relations',1),
 (5,'Director of Finance',1),
 (6,'Director of Public Relations',1),
 (7,'Director of Society Relations',1),
 (8,'Director of Student Activities',1),
 (9,'Director of Student Affairs',1),
 (10,'1st Year Representative',1),
 (11,'2nd Year Representative',1),
 (12,'3rd Year Representative',1),
 (13,'4th Year Representative',1),
 (14,'5th Year Representative',1),
 (15,'PhD Representative',1),
 (16,'Senator',1),
 (17,'Voting Society',1),
 (18,'Non-Voting Society',0),
 (19,'Member at Large',0),
 (20,'Non-Member',0);
/*!40000 ALTER TABLE `position` ENABLE KEYS */;


--
-- Definition of table `require`
--

DROP TABLE IF EXISTS `require`;
CREATE TABLE `require` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position` int(10) unsigned DEFAULT NULL,
  `meeting_type` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_member_meeting` (`position`,`meeting_type`) USING BTREE,
  KEY `FK_meeting_type_r` (`meeting_type`),
  CONSTRAINT `FK_meeting_type_r` FOREIGN KEY (`meeting_type`) REFERENCES `position` (`id`),
  CONSTRAINT `FK_member_type_r` FOREIGN KEY (`position`) REFERENCES `position` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `require`
--

/*!40000 ALTER TABLE `require` DISABLE KEYS */;
INSERT INTO `require` (`id`,`position`,`meeting_type`) VALUES 
 (1,1,1),
 (19,1,2),
 (28,1,3),
 (2,2,1),
 (20,2,2),
 (29,2,3),
 (3,3,1),
 (21,3,2),
 (30,3,3),
 (4,4,1),
 (22,4,2),
 (31,4,3),
 (5,5,1),
 (23,5,2),
 (32,5,3),
 (6,6,1),
 (24,6,2),
 (33,6,3),
 (7,7,1),
 (25,7,2),
 (34,7,3),
 (8,8,1),
 (26,8,2),
 (35,8,3),
 (9,9,1),
 (27,9,2),
 (36,9,3),
 (10,10,1),
 (37,10,3),
 (11,11,1),
 (38,11,3),
 (12,12,1),
 (39,12,3),
 (13,13,1),
 (40,13,3),
 (14,14,1),
 (41,14,3),
 (15,15,1),
 (42,15,3),
 (16,16,1),
 (43,16,3),
 (17,17,1),
 (44,17,3),
 (18,18,1),
 (45,18,3),
 (46,19,3);
/*!40000 ALTER TABLE `require` ENABLE KEYS */;


--
-- Definition of table `semester`
--

DROP TABLE IF EXISTS `semester`;
CREATE TABLE `semester` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `year` char(4) NOT NULL,
  `semester` varchar(8) NOT NULL,
  `startday` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_year_semester` (`year`,`semester`),
  KEY `Unique_startday` (`startday`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semester`
--

/*!40000 ALTER TABLE `semester` DISABLE KEYS */;
/*!40000 ALTER TABLE `semester` ENABLE KEYS */;


--
-- Definition of table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `present` tinyint(1) NOT NULL,
  `quorum` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`id`,`name`,`present`,`quorum`) VALUES 
 (1,'Unknown',0,1),
 (2,'Present',1,1),
 (3,'Absent',0,1),
 (4,'Excused',0,1),
 (5,'Co-Op',0,0);
/*!40000 ALTER TABLE `status` ENABLE KEYS */;


--
-- Definition of view `v_achievement_children`
--

DROP TABLE IF EXISTS `v_achievement_children`;
DROP VIEW IF EXISTS `v_achievement_children`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_achievement_children` AS select `a`.`id` AS `id`,(select count(0) AS `num` from `achievements_earned` `e` where (`e`.`achievement` = `a`.`id`)) AS `children` from `achievements` `a`;

--
-- Definition of view `v_achievements`
--

DROP TABLE IF EXISTS `v_achievements`;
DROP VIEW IF EXISTS `v_achievements`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_achievements` AS select `a`.`id` AS `id`,`c`.`name` AS `category`,`a`.`image` AS `image`,`a`.`name` AS `name`,`a`.`description` AS `description`,`a`.`goal` AS `goal`,`a`.`points` AS `points`,`a`.`added` AS `added`,`a`.`lock` AS `lock` from (`achievements` `a` join `achievement_category` `c` on((`a`.`category` = `c`.`id`)));

--
-- Definition of view `v_achievements_earned`
--

DROP TABLE IF EXISTS `v_achievements_earned`;
DROP VIEW IF EXISTS `v_achievements_earned`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_achievements_earned` AS select `e`.`id` AS `id`,`e`.`member` AS `member_id`,`e`.`achievement` AS `achievement`,`a`.`category` AS `category_id`,`c`.`name` AS `category`,`a`.`name` AS `name`,`a`.`description` AS `description`,`a`.`image` AS `image`,`e`.`progress` AS `progress`,`a`.`points` AS `points`,`e`.`updated` AS `updated`,`m`.`name` AS `member` from (((`achievements_earned` `e` join `achievements` `a` on((`e`.`achievement` = `a`.`id`))) join `achievement_category` `c` on((`a`.`category` = `c`.`id`))) join `members` `m` on((`e`.`member` = `m`.`id`))) where (`e`.`progress` >= `a`.`goal`);

--
-- Definition of view `v_achievements_earned_all`
--

DROP TABLE IF EXISTS `v_achievements_earned_all`;
DROP VIEW IF EXISTS `v_achievements_earned_all`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_achievements_earned_all` AS select `e`.`id` AS `id`,`e`.`member` AS `member_id`,`e`.`achievement` AS `achievement`,`a`.`category` AS `category_id`,`c`.`name` AS `category`,`a`.`name` AS `name`,`a`.`description` AS `description`,`a`.`image` AS `image`,`e`.`progress` AS `progress`,`a`.`points` AS `points`,`e`.`updated` AS `updated`,`m`.`name` AS `member` from (((`achievements_earned` `e` join `achievements` `a` on((`e`.`achievement` = `a`.`id`))) join `achievement_category` `c` on((`a`.`category` = `c`.`id`))) join `members` `m` on((`e`.`member` = `m`.`id`)));

--
-- Definition of view `v_attendance`
--

DROP TABLE IF EXISTS `v_attendance`;
DROP VIEW IF EXISTS `v_attendance`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_attendance` AS select `a`.`id` AS `id`,`a`.`meeting` AS `meeting`,`a`.`position` AS `position_id`,`m`.`name` AS `name`,`p`.`name` AS `position`,`a`.`status` AS `status`,`p`.`vote` AS `vote`,`s`.`present` AS `present`,if((`p`.`vote` = 1),`s`.`quorum`,0) AS `quorum` from (((`attendance` `a` join `members` `m` on((`a`.`member` = `m`.`id`))) join `position` `p` on((`a`.`position` = `p`.`id`))) join `status` `s` on((`a`.`status` = `s`.`id`)));

--
-- Definition of view `v_committee_children`
--

DROP TABLE IF EXISTS `v_committee_children`;
DROP VIEW IF EXISTS `v_committee_children`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_committee_children` AS select `c`.`id` AS `id`,(select count(0) AS `num` from `committee_membership` `m` where (`m`.`committee` = `c`.`id`)) AS `children` from `committees` `c`;

--
-- Definition of view `v_committees`
--

DROP TABLE IF EXISTS `v_committees`;
DROP VIEW IF EXISTS `v_committees`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_committees` AS select `c`.`id` AS `id`,`m`.`name` AS `manager`,`c`.`name` AS `name`,`c`.`description` AS `description`,(select count(0) AS `num` from `committee_membership` `o` where (`o`.`committee` = `c`.`id`)) AS `members` from (`committees` `c` join `members` `m` on((`c`.`manager` = `m`.`id`)));

--
-- Definition of view `v_meetings`
--

DROP TABLE IF EXISTS `v_meetings`;
DROP VIEW IF EXISTS `v_meetings`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_meetings` AS select `m`.`id` AS `id`,`m`.`mdate` AS `mdate`,`t`.`name` AS `meeting_type`,`s`.`year` AS `year`,`s`.`semester` AS `semester`,`m`.`description` AS `description`,`m`.`semester` AS `semester_id`,`m`.`meeting_type` AS `meeting_type_id` from ((`meetings` `m` join `meeting_type` `t` on((`m`.`meeting_type` = `t`.`id`))) join `semester` `s` on((`m`.`semester` = `s`.`id`)));

--
-- Definition of view `v_meetings_children`
--

DROP TABLE IF EXISTS `v_meetings_children`;
DROP VIEW IF EXISTS `v_meetings_children`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_meetings_children` AS select `m`.`id` AS `id`,(select count(0) AS `NUM` from `attendance` `a` where (`a`.`meeting` = `m`.`id`)) AS `children` from `meetings` `m`;

--
-- Definition of view `v_member_dd`
--

DROP TABLE IF EXISTS `v_member_dd`;
DROP VIEW IF EXISTS `v_member_dd`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_member_dd` AS select `v`.`member` AS `member`,concat(`m`.`name`,' (',`p`.`name`,')') AS `name`,`v`.`meeting_type` AS `meeting_type` from ((`v_members_require` `v` join `members` `m` on((`v`.`member` = `m`.`id`))) join `position` `p` on((`v`.`position` = `p`.`id`)));

--
-- Definition of view `v_members`
--

DROP TABLE IF EXISTS `v_members`;
DROP VIEW IF EXISTS `v_members`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_members` AS select `m`.`id` AS `id`,`m`.`name` AS `name`,`m`.`ulink` AS `ulink`,`p`.`name` AS `position`,`s`.`name` AS `status`,`p`.`id` AS `position_id`,`p`.`vote` AS `vote`,if((`p`.`vote` = 1),`s`.`quorum`,0) AS `quorum` from ((`members` `m` join `position` `p` on((`m`.`position` = `p`.`id`))) join `status` `s` on((`m`.`status` = `s`.`id`))) where (not((`p`.`name` like 'Non-Member')));

--
-- Definition of view `v_members_non`
--

DROP TABLE IF EXISTS `v_members_non`;
DROP VIEW IF EXISTS `v_members_non`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_members_non` AS select `m`.`id` AS `id`,`m`.`name` AS `name`,`m`.`ulink` AS `ulink`,`p`.`name` AS `position`,`s`.`name` AS `status`,`p`.`vote` AS `vote`,if((`p`.`vote` = 1),`s`.`quorum`,0) AS `quorum` from ((`members` `m` join `position` `p` on((`m`.`position` = `p`.`id`))) join `status` `s` on((`m`.`status` = `s`.`id`))) where (`p`.`name` like _latin1'Non-Member') order by `p`.`id`,`m`.`name`;

--
-- Definition of view `v_members_require`
--

DROP TABLE IF EXISTS `v_members_require`;
DROP VIEW IF EXISTS `v_members_require`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_members_require` AS select `m`.`id` AS `member`,`m`.`position` AS `position`,`m`.`status` AS `status`,`r`.`meeting_type` AS `meeting_type` from (`members` `m` join `require` `r` on((`m`.`position` = `r`.`position`)));

--
-- Definition of view `v_quorum`
--

DROP TABLE IF EXISTS `v_quorum`;
DROP VIEW IF EXISTS `v_quorum`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_quorum` AS select `q`.`meeting` AS `meeting`,`q`.`TotalMembers` AS `TotalMembers`,`q`.`TotalPresent` AS `TotalPresent`,`q`.`VotingMembers` AS `VotingMembers`,`q`.`VotingPresent` AS `VotingPresent`,`q`.`Quorum` AS `Quorum`,if((`q`.`VotingPresent` >= `q`.`Quorum`),1,0) AS `QuorumTest` from `v_quorum_interum` `q`;

--
-- Definition of view `v_quorum_interum`
--

DROP TABLE IF EXISTS `v_quorum_interum`;
DROP VIEW IF EXISTS `v_quorum_interum`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_quorum_interum` AS select `v`.`meeting` AS `meeting`,count(0) AS `TotalMembers`,sum(`v`.`present`) AS `TotalPresent`,sum(`v`.`vote`) AS `VotingMembers`,sum(if((`v`.`vote` = 1),`v`.`present`,0)) AS `VotingPresent`,(ceiling((sum(`v`.`quorum`) * 0.5)) + 1) AS `Quorum` from `v_attendance` `v` group by `v`.`meeting`;

--
-- Definition of view `v_reports_member_details`
--

DROP TABLE IF EXISTS `v_reports_member_details`;
DROP VIEW IF EXISTS `v_reports_member_details`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_reports_member_details` AS select `m`.`id` AS `member`,`e`.`id` AS `meeting_id`,`e`.`mdate` AS `mdate`,concat_ws(' ',`t`.`year`,`t`.`semester`) AS `semester`,`y`.`name` AS `meeting_type`,`p`.`name` AS `position`,`m`.`name` AS `name`,`s`.`name` AS `status` from ((((((`attendance` `a` join `members` `m` on((`a`.`member` = `m`.`id`))) join `status` `s` on((`a`.`status` = `s`.`id`))) join `meetings` `e` on((`a`.`meeting` = `e`.`id`))) join `semester` `t` on((`e`.`semester` = `t`.`id`))) join `meeting_type` `y` on((`e`.`meeting_type` = `y`.`id`))) join `position` `p` on((`a`.`position` = `p`.`id`))) where (`e`.`mdate` < (now() + interval 1 day));

--
-- Definition of view `v_reports_member_summary`
--

DROP TABLE IF EXISTS `v_reports_member_summary`;
DROP VIEW IF EXISTS `v_reports_member_summary`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_reports_member_summary` AS select `m`.`id` AS `member`,concat_ws(' ',`t`.`year`,`t`.`semester`) AS `semester`,`t`.`startday` AS `startday`,`y`.`name` AS `meeting_type`,`p`.`name` AS `position`,`m`.`name` AS `name`,sum(if((`a`.`status` = 1),1,0)) AS `Unknown`,sum(if((`a`.`status` = 2),1,0)) AS `Present`,sum(if((`a`.`status` = 3),1,0)) AS `Absent`,sum(if((`a`.`status` = 4),1,0)) AS `Excused`,sum(if((`a`.`status` = 5),1,0)) AS `CoOp`,`g`.`warning` AS `warning`,`g`.`trouble` AS `trouble` from (((((((`attendance` `a` join `members` `m` on((`a`.`member` = `m`.`id`))) join `status` `s` on((`a`.`status` = `s`.`id`))) join `meetings` `e` on((`a`.`meeting` = `e`.`id`))) join `semester` `t` on((`e`.`semester` = `t`.`id`))) join `meeting_type` `y` on((`e`.`meeting_type` = `y`.`id`))) join `position` `p` on((`a`.`position` = `p`.`id`))) join `v_standing_g` `g` on(((`e`.`semester` = `g`.`semester`) and (`e`.`meeting_type` = `g`.`meeting_type`) and (`a`.`member` = `g`.`member`)))) where (`e`.`mdate` < (now() + interval 1 day)) group by `t`.`id`,`y`.`id`,`m`.`id`,`p`.`id`;

--
-- Definition of view `v_semester_children`
--

DROP TABLE IF EXISTS `v_semester_children`;
DROP VIEW IF EXISTS `v_semester_children`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_semester_children` AS select `s`.`id` AS `id`,(select count(0) AS `NUM` from `meetings` `m` where (`m`.`semester` = `s`.`id`)) AS `children` from `semester` `s`;

--
-- Definition of view `v_standing_a`
--

DROP TABLE IF EXISTS `v_standing_a`;
DROP VIEW IF EXISTS `v_standing_a`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_standing_a` AS select `a`.`id` AS `id`,`m`.`semester` AS `semester`,`a`.`meeting` AS `meeting`,`m`.`meeting_type` AS `meeting_type`,`m`.`mdate` AS `mdate`,`a`.`member` AS `member`,`p`.`vote` AS `vote`,`a`.`status` AS `status` from (((`attendance` `a` join `meetings` `m` on((`a`.`meeting` = `m`.`id`))) join `members` `e` on((`a`.`member` = `e`.`id`))) join `position` `p` on((`a`.`position` = `p`.`id`)));

--
-- Definition of view `v_standing_b`
--

DROP TABLE IF EXISTS `v_standing_b`;
DROP VIEW IF EXISTS `v_standing_b`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_standing_b` AS select `s`.`id` AS `id`,`s`.`semester` AS `semester`,`s`.`meeting` AS `meeting`,`s`.`meeting_type` AS `meeting_type`,`s`.`mdate` AS `mdate`,`s`.`member` AS `member`,`s`.`vote` AS `vote`,`s`.`status` AS `status`,ifnull((select `v_standing_a`.`status` AS `status` from `v_standing_a` where ((`v_standing_a`.`meeting_type` = `s`.`meeting_type`) and (`v_standing_a`.`member` = `s`.`member`) and (`v_standing_a`.`mdate` > `s`.`mdate`)) order by `v_standing_a`.`mdate` limit 0,1),0) AS `status2`,ifnull((select `v_standing_a`.`status` AS `status` from `v_standing_a` where ((`v_standing_a`.`meeting_type` = `s`.`meeting_type`) and (`v_standing_a`.`member` = `s`.`member`) and (`v_standing_a`.`mdate` > `s`.`mdate`)) order by `v_standing_a`.`mdate` limit 1,1),0) AS `status3` from `v_standing_a` `s` order by `s`.`mdate`;

--
-- Definition of view `v_standing_c`
--

DROP TABLE IF EXISTS `v_standing_c`;
DROP VIEW IF EXISTS `v_standing_c`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_standing_c` AS select `v`.`semester` AS `semester`,`v`.`meeting_type` AS `meeting_type`,`v`.`member` AS `member`,sum(if((`v`.`status` = 3),1,0)) AS `absent` from `v_standing_a` `v` group by `v`.`semester`,`v`.`meeting_type`,`v`.`member`;

--
-- Definition of view `v_standing_d`
--

DROP TABLE IF EXISTS `v_standing_d`;
DROP VIEW IF EXISTS `v_standing_d`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_standing_d` AS select `v`.`semester` AS `semester`,`v`.`meeting_type` AS `meeting_type`,`v`.`member` AS `member`,if((`v`.`status` = 3),if((`v`.`status2` = 3),1,0),0) AS `warning`,if((`v`.`status` = 3),if((`v`.`status2` = 3),if((`v`.`status3` = 3),1,0),0),0) AS `trouble` from `v_standing_b` `v`;

--
-- Definition of view `v_standing_e`
--

DROP TABLE IF EXISTS `v_standing_e`;
DROP VIEW IF EXISTS `v_standing_e`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_standing_e` AS select `v`.`semester` AS `semester`,`v`.`meeting_type` AS `meeting_type`,`v`.`member` AS `member`,if((`v`.`absent` = 4),1,0) AS `warning`,if((`v`.`absent` > 4),1,0) AS `trouble` from `v_standing_c` `v`;

--
-- Definition of view `v_standing_f`
--

DROP TABLE IF EXISTS `v_standing_f`;
DROP VIEW IF EXISTS `v_standing_f`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_standing_f` AS select 'Consecutive' AS `type`,`d`.`semester` AS `semester`,`d`.`meeting_type` AS `meeting_type`,`d`.`member` AS `member`,`d`.`warning` AS `warning`,`d`.`trouble` AS `trouble` from `v_standing_d` `d` union select 'Total' AS `type`,`e`.`semester` AS `semester`,`e`.`meeting_type` AS `meeting_type`,`e`.`member` AS `member`,`e`.`warning` AS `warning`,`e`.`trouble` AS `trouble` from `v_standing_e` `e`;

--
-- Definition of view `v_standing_g`
--

DROP TABLE IF EXISTS `v_standing_g`;
DROP VIEW IF EXISTS `v_standing_g`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_standing_g` AS select `v_standing_f`.`semester` AS `semester`,`v_standing_f`.`meeting_type` AS `meeting_type`,`v_standing_f`.`member` AS `member`,if((sum(`v_standing_f`.`warning`) > 0),1,0) AS `warning`,if((sum(`v_standing_f`.`trouble`) > 0),1,0) AS `trouble` from `v_standing_f` group by `v_standing_f`.`semester`,`v_standing_f`.`meeting_type`,`v_standing_f`.`member`;



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
