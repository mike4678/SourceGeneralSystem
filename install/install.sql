/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50045
Source Host           : localhost:3306
Source Database       : music

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2017-07-06 13:45:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `adminlist`
-- ----------------------------
DROP TABLE IF EXISTS `adminlist`;
CREATE TABLE `adminlist` (
  `t_e` text NOT NULL,
  `m_e` text NOT NULL,
  `table` text NOT NULL,
  `menu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `username` text NOT NULL,
  `password` text NOT NULL,
  `lastip` text,
  `lasttime` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `menu_list`
-- ----------------------------
DROP TABLE IF EXISTS `menu_list`;
CREATE TABLE `menu_list` (
  `list` text NOT NULL,
  `url` text NOT NULL,
  `table` text NOT NULL,
  `page` text,
  `count` int(11) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `music_list`
-- ----------------------------
DROP TABLE IF EXISTS `music_list`;
CREATE TABLE `music_list` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `music_name` text NOT NULL,
  `singer_name` text,
  `album_name` text,
  `address` text NOT NULL,
  `access` int(11) NOT NULL,
  `link` int(11) NOT NULL,
  `upload_time` text NOT NULL,
  `lrc_path` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `system_log`
-- ----------------------------
DROP TABLE IF EXISTS `system_log`;
CREATE TABLE `system_log` (
  `id` int(11) NOT NULL,
  `method` text,
  `ip` text NOT NULL,
  `data` text NOT NULL,
  `addr` text NOT NULL,
  `time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `system_setting`
-- ----------------------------
DROP TABLE IF EXISTS `system_setting`;
CREATE TABLE `system_setting` (
  `vars` text NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `table_list`
-- ----------------------------
DROP TABLE IF EXISTS `table_list`;
CREATE TABLE `table_list` (
  `table` text NOT NULL,
  `class` text,
  `Index` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `report`
-- ----------------------------

DROP TABLE IF EXISTS `report`;
CREATE TABLE `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` text NOT NULL,
  `address` text NOT NULL,
  `type` text NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of adminlist
-- ----------------------------
INSERT INTO `adminlist` VALUES ('start', 'index', '系统', '关于');
INSERT INTO `adminlist` VALUES ('system', 'setting', '系统', '系统设置');
INSERT INTO `adminlist` VALUES ('system', 'log', '系统', '系统日志');
INSERT INTO `adminlist` VALUES ('system', 'info', '系统', '系统信息');
INSERT INTO `adminlist` VALUES ('system', 'database', '系统', '数据库管理');
INSERT INTO `adminlist` VALUES ('system', 'music', '系统', '音乐管理');
INSERT INTO `adminlist` VALUES ('system', 'report', '系统', '反馈管理');

-- ----------------------------
-- Records of menu_list
-- ----------------------------
INSERT INTO `menu_list` VALUES ('关于', 'admin.php', '系统', 'system/main.php', '0');
INSERT INTO `menu_list` VALUES ('系统信息', 'admin.php?/system/info', '系统', 'system/info.php', '4');
INSERT INTO `menu_list` VALUES ('系统日志', 'admin.php?/system/log', '系统', 'system/SysLog.php', '5');
INSERT INTO `menu_list` VALUES ('系统设置', 'admin.php?/system/setting', '系统', 'system/system.php', '1');
INSERT INTO `menu_list` VALUES ('音乐管理', 'admin.php?/system/music', '系统', 'system/music.php', '3');
INSERT INTO `menu_list` VALUES ('数据库管理', 'admin.php?/system/database', '系统', 'system/database.php', '2');
INSERT INTO `menu_list` VALUES ('反馈管理', 'admin.php?/system/report', '系统', 'system/report.php', '3');

-- ----------------------------
-- Records of system_setting
-- ----------------------------
INSERT INTO `system_setting` VALUES ('server_status', '0');
INSERT INTO `system_setting` VALUES ('corp', 'Source');
INSERT INTO `system_setting` VALUES ('version', '1.0.2');
INSERT INTO `system_setting` VALUES ('logo', 'images/logo.png');
INSERT INTO `system_setting` VALUES ('name', '音乐分享系统');
INSERT INTO `system_setting` VALUES ('upload_size', '10');
INSERT INTO `system_setting` VALUES ('upload_name', 'mp3');
INSERT INTO `system_setting` VALUES ('bottom', 'Copyright © 2001-2022 Source. All Rights Reserved.');
INSERT INTO `system_setting` VALUES ('server_infomaction', 'The system is under maintenance. Please visit later.<br>');
INSERT INTO `system_setting` VALUES ('encrypted', '');
INSERT INTO `system_setting` VALUES ('bugreport', '0');
INSERT INTO `system_setting` VALUES ('reportaddress', '');

-- ----------------------------
-- Records of table_list
-- ----------------------------
INSERT INTO `table_list` VALUES ('系统', 'icon-cog', 'admin.php');
