<?php
require("../../kernl/Init.php"); //初始化基础参数
//Setp 1 执行SQL创建与导入
include("../../kernl/FileUtil.Class.php");

$sql = "INSERT INTO `adminlist` VALUES ('music', 'music', '音乐', '音乐管理', 'admin.php?/music/music', 'music/music.php', '0');
		INSERT INTO `adminlist` VALUES ('music', 'keyword', '音乐', '搜索关键词', 'admin.php?/music/keyword', 'music/content.php', '1');
		INSERT INTO `adminlist` VALUES ('music', 'lrc', '音乐', '歌词管理', 'admin.php?/music/lrc', 'music/content.php', '2');
		INSERT INTO `content_data` VALUES ('keyword', 'search_keyword', 'function info(message) { art.dialog.tips(message,5); }\r\n		\r\nfunction Del(addr) \r\n{\r\n	art.dialog.confirm(\'你确定要删除这条记录吗？\', function () {\r\n		window.location.href=\'http://\' + window.location.host + addr;\r\n		//art.dialog.content(\'http://\' + window.location.host + addr);// 填充对话框内容\r\n		//art.dialog.open(\'http://\' + window.location.host + addr)\r\n		//myDialog.dialog.close();\r\n    //art.dialog.tips(\'执行确定操作\');\r\n}, function () {\r\n	art.dialog.close();\r\n    art.dialog.tips(\'操作被用户取消！\');\r\n});\r\n}', '<div class=\"panel-head\"><strong>搜索关键词管理</strong></div>\r\n        <div class=\"padding border-bottom\">\r\n            <input type=\"button\" class=\"button button-small checkall\" name=\"checkall\" checkfor=\"id[]\" value=\"全选\" />\r\n            <input type=\"submit\" class=\"button button-small border-yellow\" value=\"批量删除\" />\r\n        </div>\r\n        <table class=\"table table-hover\">\r\n        	<tr><th width=\"3%\"></th><th width=\"25%\">&nbsp;搜索关键词</th><th width=\"15%\">方式</th><th width=\"15%\">被搜索次数</th><th width=\"25%\">提交时间</th><th width=\"14%\">&nbsp;操作</th></tr>', '<tr><td><input type=\'checkbox\' name=\'id[]\' value=\'{id}\'></td><td>{keyword}</td><td>{type}</td><td>{count}</td><td>{time}</td><td>&nbsp;<a class=\'button border-yellow button-little\' href=# onclick=\"javascript:Del(\'$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]'/id{id}\')\">删除</a>');
		INSERT INTO `content_data` VALUES ('report', 'report', 'function info(message) { art.dialog.tips(message,5); }\r\n	\r\nfunction Del(addr) \r\n{\r\n	art.dialog.confirm(\'你确定要删除这条内容吗？\', function () {\r\n		window.location.href=\'http://\' + window.location.host + addr;\r\n		//art.dialog.content(\'http://\' + window.location.host + addr);// 填充对话框内容\r\n		//art.dialog.open(\'http://\' + window.location.host + addr)\r\n		//myDialog.dialog.close();\r\n    //art.dialog.tips(\'执行确定操作\');\r\n}, function () {\r\n	art.dialog.close();\r\n    art.dialog.tips(\'操作被用户取消！\');\r\n});\r\n}', '<div class=\"panel-head\"><strong>建议与意见</strong></div>\r\n        <div class=\"padding border-bottom\">\r\n            <input type=\"button\" class=\"button button-small checkall\" name=\"checkall\" checkfor=\"id[]\" value=\"全选\" />\r\n            <input type=\"submit\" class=\"button button-small border-yellow\" value=\"批量删除\" />\r\n        </div>\r\n        <table class=\"table table-hover\">\r\n        	<tr><th width=\"1%\"></th><th width=\"8%\">ID</th><th width=\"13%\">提交时间</th><th width=\"13%\">联系方式</th><th width=\"16%\">类型</th><th width=\"14%\">内容</th><th width=\"14%\">操作</th></tr>', '<tr><td></td><td><input type=\'checkbox\' name=\'id[]\' value=\'{id}\'>&nbsp;&nbsp;{id}</td><td>{time}</td><td>{address}</td><td>{type}</td><td><a href=\'javascript:info(\"{data}\")\'>点击查看</td><td>&nbsp;<a class=\'button border-yellow button-little\' href=# onclick=\"javascript:Del(\'$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]/id{id}\')\\\">删除</a>\";');
		INSERT INTO `content_data` VALUES ('lrc', 'lrc_list', 'function Del(addr) \r\n{\r\n	art.dialog.confirm(\'你确定要删除该歌词吗？\', function () {\r\n		window.location.href=\'http://\' + window.location.host + addr;\r\n		//art.dialog.content(\'http://\' + window.location.host + addr);// 填充对话框内容\r\n		//art.dialog.open(\'http://\' + window.location.host + addr)\r\n		//myDialog.dialog.close();\r\n    //art.dialog.tips(\'执行确定操作\');\r\n}, function () {\r\n	art.dialog.close();\r\n    art.dialog.tips(\'操作被用户取消！\');\r\n});\r\n}\r\n\r\nfunction info(message) {\r\n		art.dialog.tips(message,10);}\r\n\r\nfunction LrcManager(action,music_id)\r\n	{\r\n		if(action == \'\' || music_id == \'\')\r\n		{ info(\'参数错误！\'); }\r\n		\r\n		if(action == \'add\')\r\n		{ art.dialog.open(\'system/Lrc.php?m=add&id=\'+music_id, {title: \'新增歌词数据\',width: 420});	}\r\n		\r\n		if(action == \'edit\')\r\n		{ art.dialog.open(\'system/Lrc.php?m=edit&id=\'+music_id, {title: \'修改歌词数据\',width: 420,});	}	\r\n	\r\n	}', '<div class=\"panel-head\"><strong>歌词管理</strong></div>\r\n        <div class=\"padding border-bottom\">\r\n        	<input type=\"button\" class=\"button button-small checkall\" name=\"checkall\" checkfor=\"id[]\" value=\"全选\">\r\n                   <input type=\"button\" class=\"button button-small border-green\" name=\"Add\"  value=\"新增\"  onclick=\"LrcManager(\'add\')\" />\r\n            <input type=\"submit\" class=\"button button-small border-yellow\" value=\"批量删除\"  />\r\n        </div>\r\n        <table class=\"table table-hover\">\r\n        	<tr><th width=\"5%\">选择</th><th width=\"10%\">歌曲名</th><th width=\"15%\">歌手名</th><th width=\"20%\">歌词数据</th><th width=\"8%\">&nbsp;操作</th></tr>', '<tr><td>&nbsp;<input type=\'checkbox\' name=\'id[]\' value=\'{id}\'><input name=\'d\' type=\'hidden\' value=\'lrc\'></td><td>&nbsp;&nbsp;{name}</td><td>{singer}</td><td><a href=\'javascript:info(\"{lrc}\")\'>点击查看</td><td>&nbsp;<a class=\'button border-yellow button-little\' href=\"javascript:LrcManager(\'edit\',\'{id}\')\">编辑</a>&nbsp;<a class=\'button border-yellow button-little\' href=\'#\' onclick=\"javascript:Del(\'$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]/id{id} \')\">删除</a></td></tr>');
		DROP TABLE IF EXISTS `lrc_list`;
		CREATE TABLE `lrc_list` (
  								`id` int(11) NOT NULL auto_increment,
								`name` text NOT NULL,
								`singer` text NOT NULL,
  								`lrc` text NOT NULL,
  								PRIMARY KEY  (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

		DROP TABLE IF EXISTS `music_list`;
		CREATE TABLE `music_list` (
  								`id` int(11) unsigned NOT NULL auto_increment,
  								`music_name` text NOT NULL,
  								`singer_name` text,
  								`album_name` text NOT NULL,
  								`address` text NOT NULL,
  								`access` int(11) NOT NULL,
  								`link` int(11) NOT NULL,
								`upload_time` text NOT NULL,
  								`lrc_path` text,
  								PRIMARY KEY  (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

		DROP TABLE IF EXISTS `search_keyword`;
		CREATE TABLE `search_keyword` (
										`id` int(11) NOT NULL auto_increment,
  										`keyword` text NOT NULL,
  										`type` text NOT NULL,
  										`count` int(11) NOT NULL,
  										`time` text NOT NULL,
  										PRIMARY KEY  (`id`)
										) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;";

$dou -> query($sql);

//Setp 2 文件移动
$fu = new FileUtil();
$fu->moveDir('musicdata/','../../music/');
$fu->moveDir('../music.zip/','../../');
?>
