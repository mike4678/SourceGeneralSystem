/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50710
Source Host           : localhost:3306
Source Database       : generalsystem

Target Server Type    : MYSQL
Target Server Version : 50710
File Encoding         : 65001

Date: 2018-12-05 07:20:45
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
  `menu` text NOT NULL,
  `url` text NOT NULL,
  `page` text NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of adminlist
-- ----------------------------
INSERT INTO `adminlist` VALUES ('start', 'index', '系统', '关于', 'admin.php', 'system/main.php', '0');
INSERT INTO `adminlist` VALUES ('system', 'setting', '系统', '系统设置', 'admin.php?/system/setting', 'system/system.php', '1');
INSERT INTO `adminlist` VALUES ('system', 'log', '系统', '系统日志', 'admin.php?/system/log', 'system/content.php', '4');
INSERT INTO `adminlist` VALUES ('system', 'info', '系统', '系统信息', 'admin.php?/system/info', 'system/info.php', '3');
INSERT INTO `adminlist` VALUES ('system', 'database', '系统', '数据库管理', 'admin.php?/system/database', 'system/database.php', '2');
INSERT INTO `adminlist` VALUES ('system', 'module', '系统', '模块管理', 'admin.php?/system/module', 'system/module.php', '1');
INSERT INTO `adminlist` VALUES ('system', 'ips', '系统', 'IP防火墙', 'admin.php?/system/ips', 'system/ips.php', '1');

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
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('admin', 'k5WfnKA=', '192.168.2.101', '18/12/04 23:33:09');

-- ----------------------------
-- Table structure for `content_data`
-- ----------------------------
DROP TABLE IF EXISTS `content_data`;
CREATE TABLE `content_data` (
  `list` text NOT NULL COMMENT '对应菜单项目',
  `list_name` text NOT NULL,
  `script` text NOT NULL COMMENT '页面里的脚本',
  `table_head` text NOT NULL COMMENT '列表顶部',
  `table` text NOT NULL COMMENT '列表内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of content_data
-- ----------------------------
INSERT INTO `content_data` VALUES ('log', 'system_log', 'function Del(addr) \r\n{\r\n	art.dialog.confirm(\'你确定要删除这条消息吗？\', function () {\r\n		window.location.href=\'http://\' + window.location.host + addr;\r\n		//art.dialog.content(\'http://\' + window.location.host + addr);// 填充对话框内容\r\n		//art.dialog.open(\'http://\' + window.location.host + addr)\r\n		//myDialog.dialog.close();\r\n    //art.dialog.tips(\'执行确定操作\');\r\n}, function () {\r\n	art.dialog.close();\r\n    art.dialog.tips(\'操作被用户取消！\');\r\n});\r\n}\r\n\r\nfunction info(message) {\r\n		art.dialog.tips(message,10);}', '<div class=\"panel-head\"><strong>系统日志</strong></div>\r\n        <div class=\"padding border-bottom\">\r\n        	<input type=\"button\" class=\"button button-small checkall\" name=\"checkall\" checkfor=\"id[]\" value=\"全选\">\r\n            <input type=\"submit\" class=\"button button-small border-yellow\" value=\"批量删除\"  />\r\n        </div>\r\n        <table class=\"table table-hover\">\r\n        	<tr><th width=\"5%\">选择</th><th width=\"10%\">请求方式</th><th width=\"25%\" style=\"text-align:center\">操作内容</th><th width=\"14%\" style=\"text-align:center\">操作ip</th><th width=\"8%\" >&nbsp;&nbsp;&nbsp;时间</th><th width=\"8%\">&nbsp;操作</th></tr>', '<tr><td>&nbsp;<input type=\'checkbox\' name=\'id[]\' value=\'{id}\'><input name=\'d\' type=\'hidden\' value=\'systemlog\'></td><td>&nbsp;&nbsp;{method}</td><td align=center><a href=\'javascript:info(\"{data}<br/>操作IP：{ip}&nbsp;&nbsp;操作时间：{time}\")\'>点击查看</td><td style=\'text-align:center\'>{ip}</td><td>{time}</td><td>&nbsp;<a class=\'button border-yellow button-little\' href=\'#\' onclick=\"javascript:Del(\'$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]/id{id} \')\">删除</a></td></tr>');

-- ----------------------------
-- Table structure for `system_ips`
-- ----------------------------
DROP TABLE IF EXISTS `system_ips`;
CREATE TABLE `system_ips` (
  `iptable` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_ips
-- ----------------------------
INSERT INTO `system_ips` VALUES ('192.168.2.5', '1');
INSERT INTO `system_ips` VALUES ('192.168.*.1', '1');
INSERT INTO `system_ips` VALUES ('192.168.1.1', '1');

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
-- Records of system_log
-- ----------------------------
INSERT INTO `system_log` VALUES ('1', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/22');
INSERT INTO `system_log` VALUES ('2', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/22');
INSERT INTO `system_log` VALUES ('3', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/23');
INSERT INTO `system_log` VALUES ('4', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/23');
INSERT INTO `system_log` VALUES ('5', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/23');
INSERT INTO `system_log` VALUES ('6', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/23');
INSERT INTO `system_log` VALUES ('7', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/24');
INSERT INTO `system_log` VALUES ('8', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/24');
INSERT INTO `system_log` VALUES ('9', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/24');
INSERT INTO `system_log` VALUES ('10', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/24');
INSERT INTO `system_log` VALUES ('11', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/24');
INSERT INTO `system_log` VALUES ('12', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/24');
INSERT INTO `system_log` VALUES ('13', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/24');
INSERT INTO `system_log` VALUES ('14', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/24');
INSERT INTO `system_log` VALUES ('15', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/24');
INSERT INTO `system_log` VALUES ('16', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/24');
INSERT INTO `system_log` VALUES ('17', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/24');
INSERT INTO `system_log` VALUES ('18', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/24');
INSERT INTO `system_log` VALUES ('19', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/24');
INSERT INTO `system_log` VALUES ('20', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/25');
INSERT INTO `system_log` VALUES ('21', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/25');
INSERT INTO `system_log` VALUES ('22', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/25');
INSERT INTO `system_log` VALUES ('23', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/26');
INSERT INTO `system_log` VALUES ('24', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/26');
INSERT INTO `system_log` VALUES ('25', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/27');
INSERT INTO `system_log` VALUES ('26', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/27');
INSERT INTO `system_log` VALUES ('27', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/27');
INSERT INTO `system_log` VALUES ('28', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/28');
INSERT INTO `system_log` VALUES ('29', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/29');
INSERT INTO `system_log` VALUES ('30', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/29');
INSERT INTO `system_log` VALUES ('31', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/11/30');
INSERT INTO `system_log` VALUES ('32', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/12/01');
INSERT INTO `system_log` VALUES ('33', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/12/01');
INSERT INTO `system_log` VALUES ('34', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/12/02');
INSERT INTO `system_log` VALUES ('35', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/12/02');
INSERT INTO `system_log` VALUES ('36', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/12/02');
INSERT INTO `system_log` VALUES ('37', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/12/02');
INSERT INTO `system_log` VALUES ('38', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/12/02');
INSERT INTO `system_log` VALUES ('39', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/12/03');
INSERT INTO `system_log` VALUES ('40', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/12/03');
INSERT INTO `system_log` VALUES ('41', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/12/04');
INSERT INTO `system_log` VALUES ('42', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/12/04');
INSERT INTO `system_log` VALUES ('43', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/12/04');
INSERT INTO `system_log` VALUES ('44', 'POST', '192.168.2.101', '用户登陆成功', 'Login.php', '18/12/04');

-- ----------------------------
-- Table structure for `system_setting`
-- ----------------------------
DROP TABLE IF EXISTS `system_setting`;
CREATE TABLE `system_setting` (
  `vars` text NOT NULL,
  `value` text NOT NULL,
  `备注` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_setting
-- ----------------------------
INSERT INTO `system_setting` VALUES ('server_status', '0', '系统状态');
INSERT INTO `system_setting` VALUES ('corp', 'Source', '版权');
INSERT INTO `system_setting` VALUES ('version', '1.0.0', '版本号');
INSERT INTO `system_setting` VALUES ('logo', 'images/logo.png', 'logo');
INSERT INTO `system_setting` VALUES ('name', 'Source', null);
INSERT INTO `system_setting` VALUES ('upload_size', '79', '上传大小(MB)');
INSERT INTO `system_setting` VALUES ('bottom', 'Copyright © 2001-2029 Source. All Rights Reserved.', '页面底部信息');
INSERT INTO `system_setting` VALUES ('server_infomaction', 'The system is under maintenance. Please visit later.<br>', '系统维护显示信息');
INSERT INTO `system_setting` VALUES ('encrypted', 'admin', '密码加密字符串');
INSERT INTO `system_setting` VALUES ('bugreport', '2', 'Bug提交方式');
INSERT INTO `system_setting` VALUES ('reportaddress', '', '外部提交地址');
INSERT INTO `system_setting` VALUES ('pagedisplay', '20', '列表每页显示数量');
INSERT INTO `system_setting` VALUES ('index_status', '0', '是否启用首页模块，0为启用，1为禁用');
INSERT INTO `system_setting` VALUES ('index_page', 'admin/system/info.php', '默认显示首页内容');
INSERT INTO `system_setting` VALUES ('index_page_all', '1;后台管理;admin/login.php|2;系统信息;admin/system/info.php', '已安装首页模块\r\n模块模板信息：uid;name;addr|uid;name;addr');
INSERT INTO `system_setting` VALUES ('update_status', 'null', '更新状态，用于判断是否为定制版');
INSERT INTO `system_setting` VALUES ('ipfirewall_status', '1', '是否启用ip防火墙模块，0为启用，1为禁用');
INSERT INTO `system_setting` VALUES ('ipfirewall_mode', '0', 'ip防火墙黑白名单模式，0为白名单，1为黑名单');
INSERT INTO `system_setting` VALUES ('system_table', '系统;icon-cog;admin.php|', '后台顶部夹显示部分,格式：name;logo;addr 用|分割');
INSERT INTO `system_setting` VALUES ('upload_frame', 'system;.png、.jpg、.gif;../../images/|module;.zip;../../module/|', '上传框架,格式：框架名;允许文件类型，多个用、隔开;要上传到的目录，多个框架用|分割');
