CREATE TABLE `admin_user` (
  `username` text NOT NULL,
  `password` text NOT NULL,
  `lastip` text,
  `lasttime` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `admin_user`(`username`,`password`,`lastip`,`lasttime`) values('admin','k5WfnKA=','127.0.0.1','18/10/04 14:18:06');
CREATE TABLE `adminlist` (
  `t_e` text NOT NULL,
  `m_e` text NOT NULL,
  `table` text NOT NULL,
  `menu` text NOT NULL,
  `url` text NOT NULL,
  `page` text NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `adminlist`(`t_e`,`m_e`,`table`,`menu`,`url`,`page`,`count`) values('start','index','系统','关于','admin.php','system/main.php','0');
insert into `adminlist`(`t_e`,`m_e`,`table`,`menu`,`url`,`page`,`count`) values('system','setting','系统','系统设置','admin.php?/system/setting','system/system.php','1');
insert into `adminlist`(`t_e`,`m_e`,`table`,`menu`,`url`,`page`,`count`) values('system','log','系统','系统日志','admin.php?/system/log','system/content.php','4');
insert into `adminlist`(`t_e`,`m_e`,`table`,`menu`,`url`,`page`,`count`) values('system','info','系统','系统信息','admin.php?/system/info','system/info.php','3');
insert into `adminlist`(`t_e`,`m_e`,`table`,`menu`,`url`,`page`,`count`) values('system','database','系统','数据库管理','admin.php?/system/database','system/database.php','2');
CREATE TABLE `content_data` (
  `list` text NOT NULL COMMENT '对应菜单项目',
  `list_name` text NOT NULL,
  `script` text NOT NULL COMMENT '页面里的脚本',
  `table_head` text NOT NULL COMMENT '列表顶部',
  `table` text NOT NULL COMMENT '列表内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `content_data`(`list`,`list_name`,`script`,`table_head`,`table`) values('log','system_log','function Del(addr) 
{
	art.dialog.confirm(\'你确定要删除这条消息吗？\', function () {
		window.location.href=\'http://\' + window.location.host + addr;
		//art.dialog.content(\'http://\' + window.location.host + addr);// 填充对话框内容
		//art.dialog.open(\'http://\' + window.location.host + addr)
		//myDialog.dialog.close();
    //art.dialog.tips(\'执行确定操作\');
}, function () {
	art.dialog.close();
    art.dialog.tips(\'操作被用户取消！\');
});
}

function info(message) {
		art.dialog.tips(message,10);}','<div class=\"panel-head\"><strong>系统日志</strong></div>
        <div class=\"padding border-bottom\">
        	<input type=\"button\" class=\"button button-small checkall\" name=\"checkall\" checkfor=\"id[]\" value=\"全选\">
            <input type=\"submit\" class=\"button button-small border-yellow\" value=\"批量删除\"  />
        </div>
        <table class=\"table table-hover\">
        	<tr><th width=\"5%\">选择</th><th width=\"10%\">请求方式</th><th width=\"25%\" style=\"text-align:center\">操作内容</th><th width=\"14%\" style=\"text-align:center\">操作ip</th><th width=\"8%\" >&nbsp;&nbsp;&nbsp;时间</th><th width=\"8%\">&nbsp;操作</th></tr>','<tr><td>&nbsp;<input type=\'checkbox\' name=\'id[]\' value=\'{id}\'><input name=\'d\' type=\'hidden\' value=\'systemlog\'></td><td>&nbsp;&nbsp;{method}</td><td align=center><a href=\'javascript:info(\"{data}<br/>操作IP：{ip}&nbsp;&nbsp;操作时间：{time}\")\'>点击查看</td><td style=\'text-align:center\'>{ip}</td><td>{time}</td><td>&nbsp;<a class=\'button border-yellow button-little\' href=\'#\' onclick=\"javascript:Del(\'$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]/id{id} \')\">删除</a></td></tr>');
insert into `content_data`(`list`,`list_name`,`script`,`table_head`,`table`) values('keyword','search_keyword','function info(message) { art.dialog.tips(message,5); }
		
function Del(addr) 
{
	art.dialog.confirm(\'你确定要删除这条记录吗？\', function () {
		window.location.href=\'http://\' + window.location.host + addr;
		//art.dialog.content(\'http://\' + window.location.host + addr);// 填充对话框内容
		//art.dialog.open(\'http://\' + window.location.host + addr)
		//myDialog.dialog.close();
    //art.dialog.tips(\'执行确定操作\');
}, function () {
	art.dialog.close();
    art.dialog.tips(\'操作被用户取消！\');
});
}','<div class=\"panel-head\"><strong>搜索关键词管理</strong></div>
        <div class=\"padding border-bottom\">
            <input type=\"button\" class=\"button button-small checkall\" name=\"checkall\" checkfor=\"id[]\" value=\"全选\" />
            <input type=\"submit\" class=\"button button-small border-yellow\" value=\"批量删除\" />
        </div>
        <table class=\"table table-hover\">
        	<tr><th width=\"3%\"></th><th width=\"25%\">&nbsp;搜索关键词</th><th width=\"15%\">方式</th><th width=\"15%\">被搜索次数</th><th width=\"25%\">提交时间</th><th width=\"14%\">&nbsp;操作</th></tr>','<tr><td><input type=\'checkbox\' name=\'id[]\' value=\'{id}\'></td><td>{keyword}</td><td>{type}</td><td>{count}</td><td>{time}</td><td>&nbsp;<a class=\'button border-yellow button-little\' href=# onclick=\"javascript:Del(\'$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]/id{id}\')\">删除</a>');
insert into `content_data`(`list`,`list_name`,`script`,`table_head`,`table`) values('report','report','function info(message) { art.dialog.tips(message,5); }
	
function Del(addr) 
{
	art.dialog.confirm(\'你确定要删除这条内容吗？\', function () {
		window.location.href=\'http://\' + window.location.host + addr;
		//art.dialog.content(\'http://\' + window.location.host + addr);// 填充对话框内容
		//art.dialog.open(\'http://\' + window.location.host + addr)
		//myDialog.dialog.close();
    //art.dialog.tips(\'执行确定操作\');
}, function () {
	art.dialog.close();
    art.dialog.tips(\'操作被用户取消！\');
});
}','<div class=\"panel-head\"><strong>建议与意见</strong></div>
        <div class=\"padding border-bottom\">
            <input type=\"button\" class=\"button button-small checkall\" name=\"checkall\" checkfor=\"id[]\" value=\"全选\" />
            <input type=\"submit\" class=\"button button-small border-yellow\" value=\"批量删除\" />
        </div>
        <table class=\"table table-hover\">
        	<tr><th width=\"1%\"></th><th width=\"8%\">ID</th><th width=\"13%\">提交时间</th><th width=\"13%\">联系方式</th><th width=\"16%\">类型</th><th width=\"14%\">内容</th><th width=\"14%\">操作</th></tr>','<tr><td></td><td><input type=\'checkbox\' name=\'id[]\' value=\'{id}\'>&nbsp;&nbsp;{id}</td><td>{time}</td><td>{address}</td><td>{type}</td><td><a href=\'javascript:info(\"{data}\")\'>点击查看</td><td>&nbsp;<a class=\'button border-yellow button-little\' href=# onclick=\"javascript:Del(\'$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]/id{id}\')\\\">删除</a>\";');
insert into `content_data`(`list`,`list_name`,`script`,`table_head`,`table`) values('lrc','lrc_list','function Del(addr) 
{
	art.dialog.confirm(\'你确定要删除这条消息吗？\', function () {
		window.location.href=\'http://\' + window.location.host + addr;
		//art.dialog.content(\'http://\' + window.location.host + addr);// 填充对话框内容
		//art.dialog.open(\'http://\' + window.location.host + addr)
		//myDialog.dialog.close();
    //art.dialog.tips(\'执行确定操作\');
}, function () {
	art.dialog.close();
    art.dialog.tips(\'操作被用户取消！\');
});
}

function info(message) {
		art.dialog.tips(message,10);}

function LrcManager(action,music_id)
	{
		if(action == \'\' || music_id == \'\')
		{ info(\'参数错误！\'); }
		
		if(action == \'add\')
		{ art.dialog.open(\'system/Lrc.php?m=add&id=\'+music_id, {title: \'新增歌词数据\',width: 420});	}
		
		if(action == \'edit\')
		{ art.dialog.open(\'system/Lrc.php?m=edit&id=\'+music_id, {title: \'修改歌词数据\',width: 420,});	}	
	
	}','<div class=\"panel-head\"><strong>歌词管理</strong></div>
        <div class=\"padding border-bottom\">
        	<input type=\"button\" class=\"button button-small checkall\" name=\"checkall\" checkfor=\"id[]\" value=\"全选\">
                   <input type=\"button\" class=\"button button-small border-green\" name=\"Add\"  value=\"新增\"  onclick=\"LrcManager(\'add\')\" />
            <input type=\"submit\" class=\"button button-small border-yellow\" value=\"批量删除\"  />
        </div>
        <table class=\"table table-hover\">
        	<tr><th width=\"5%\">选择</th><th width=\"10%\">歌曲名</th><th width=\"15%\">歌手名</th><th width=\"20%\">歌词数据</th><th width=\"8%\">&nbsp;操作</th></tr>','<tr><td>&nbsp;<input type=\'checkbox\' name=\'id[]\' value=\'{id}\'><input name=\'d\' type=\'hidden\' value=\'lrc\'></td><td>&nbsp;&nbsp;{name}</td><td>{singer}</td><td><a href=\'javascript:info(\"{lrc}\")\'>点击查看</td><td>&nbsp;<a class=\'button border-yellow button-little\' href=\"javascript:LrcManager(\'edit\',\'{id}\')\">编辑</a>&nbsp;<a class=\'button border-yellow button-little\' href=\'#\' onclick=\"javascript:Del(\'$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]/id{id} \')\">删除</a></td></tr>');
CREATE TABLE `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` text NOT NULL,
  `address` text NOT NULL,
  `type` text NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `search_keyword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` text NOT NULL,
  `type` text NOT NULL,
  `count` int(11) NOT NULL,
  `time` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
insert into `search_keyword`(`id`,`keyword`,`type`,`count`,`time`) values('6','五月天','音乐名','4','17/10/03 17:54:20');
insert into `search_keyword`(`id`,`keyword`,`type`,`count`,`time`) values('8','1 and 1=2 union select * from user ','音乐名','1','17/10/03 18:26:57');
insert into `search_keyword`(`id`,`keyword`,`type`,`count`,`time`) values('10','夏天的风','音乐名','4','17/10/03 18:28:15');
insert into `search_keyword`(`id`,`keyword`,`type`,`count`,`time`) values('11','五月天','专辑名称','1','17/10/06 10:33:43');
insert into `search_keyword`(`id`,`keyword`,`type`,`count`,`time`) values('12','五月天','歌手名','2','17/10/06 10:36:23');
insert into `search_keyword`(`id`,`keyword`,`type`,`count`,`time`) values('13','佚名','歌手名','2','17/10/06 10:36:30');
insert into `search_keyword`(`id`,`keyword`,`type`,`count`,`time`) values('14','十年','音乐名','1','18/01/25 21:59:12');
insert into `search_keyword`(`id`,`keyword`,`type`,`count`,`time`) values('15','十年之前','音乐名','1','18/01/25 22:03:20');
insert into `search_keyword`(`id`,`keyword`,`type`,`count`,`time`) values('16','','歌词','1','18/01/27 11:48:44');
insert into `search_keyword`(`id`,`keyword`,`type`,`count`,`time`) values('17','nonono','歌词','28','18/01/27 11:50:43');
insert into `search_keyword`(`id`,`keyword`,`type`,`count`,`time`) values('18','当一座城墙 只为了阻挡','歌词','5','18/01/27 11:52:10');
insert into `search_keyword`(`id`,`keyword`,`type`,`count`,`time`) values('19','十年之前','歌词','2','18/01/27 13:17:06');
CREATE TABLE `system_log` (
  `id` int(11) NOT NULL,
  `method` text,
  `ip` text NOT NULL,
  `data` text NOT NULL,
  `addr` text NOT NULL,
  `time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('1','POST','192.168.2.101','用户登陆成功','Login.php','17/09/28');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('2','POST','192.168.2.101','用户登陆成功','Login.php','17/10/03');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('3','POST','192.168.2.101','用户登陆成功','Login.php','17/10/03');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('4','POST','192.168.2.101','用户登陆成功','Login.php','17/10/03');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('5','POST','192.168.2.101','用户登陆成功','Login.php','17/10/03');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('6','POST','192.168.2.101','用户登陆成功','Login.php','17/10/03');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('7','POST','192.168.2.101','用户登陆成功','Login.php','17/10/03');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('8','POST','192.168.2.101','用户登陆成功','Login.php','17/10/05');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('9','POST','192.168.2.101','用户登陆成功','Login.php','17/10/05');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('10','POST','192.168.2.101','用户登陆成功','Login.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('11','POST','192.168.2.101','用户登陆成功','Login.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('12','POST','192.168.2.101','管理员执行数据库备份','/admin/admin.php?databasebak=%E5%A4%87%E4%BB%BD%E6%95%B0%E6%8D%AE%E5%BA%93','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('13','GET','192.168.2.101','加载模块：系统/音乐管理<br />实例对象：system/content.php?page=music失败','404.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('14','GET','192.168.2.101','加载模块：系统/音乐管理<br />实例对象：system/content.php&music失败','404.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('15','POST','192.168.2.101','用户登陆成功','Login.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('16','POST','192.168.2.101','用户登陆成功','Login.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('17','POST','192.168.2.101','用户尝试登陆，但密码错误！','Login.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('18','POST','192.168.2.101','用户登陆成功','Login.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('19','POST','192.168.2.101','用户登陆成功','Login.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('20','POST','192.168.2.101','用户登陆成功','Login.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('21','POST','192.168.2.101','用户登陆成功','Login.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('22','POST','192.168.2.101','用户登陆成功','Login.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('23','GET','192.168.2.101','加载模块：系统/数据库管理<br />实例对象：system/content.php失败','404.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('24','POST','192.168.2.101','用户登陆成功','Login.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('25','GET','192.168.2.101','加载模块：系统/数据库管理<br />实例对象：system/content.php失败','404.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('26','GET','192.168.2.101','加载模块：系统/数据库管理<br />实例对象：system/content.php失败','404.php','17/10/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('27','POST','192.168.2.101','用户登陆成功','Login.php','17/10/07');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('28','POST','192.168.2.101','用户登陆成功','Login.php','17/10/07');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('29','POST','192.168.2.101','用户登陆成功','Login.php','17/10/07');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('30','POST','192.168.2.101','用户登陆成功','Login.php','17/10/07');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('31','POST','192.168.2.101','用户登陆成功','Login.php','17/10/07');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('32','POST','192.168.2.101','用户登陆成功','Login.php','18/01/25');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('33','POST','192.168.2.101','用户登陆成功','Login.php','18/01/26');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('34','POST','192.168.2.101','用户登陆成功','Login.php','18/01/26');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('35','POST','192.168.2.101','用户尝试登陆，但密码错误！','Login.php','18/01/26');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('36','POST','192.168.2.101','用户登陆成功','Login.php','18/01/26');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('37','POST','192.168.2.101','用户登陆成功','Login.php','18/01/27');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('38','POST','192.168.2.101','用户登陆成功','Login.php','18/01/27');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('39','POST','192.168.2.101','用户登陆成功','Login.php','18/01/28');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('40','POST','192.168.2.101','用户登陆成功','Login.php','18/01/28');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('41','POST','::1','用户登陆成功','Login.php','18/09/06');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('42','POST','192.168.2.101','用户登陆成功','Login.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('43','GET','192.168.2.101','加载模块：系统/音乐管理<br />实例对象：K:GitHubSourceGeneralSystemadmin/system/music.php失败','404.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('44','POST','192.168.2.101','管理员执行数据库备份','/admin/admin.php?databasebak=%E5%A4%87%E4%BB%BD%E6%95%B0%E6%8D%AE%E5%BA%93','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('45','GET','192.168.2.101','访问请求由于 系统维护中 被拦截<br />','error.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('46','GET','192.168.2.101','访问请求由于 系统维护中 被拦截<br />','error.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('47','GET','192.168.2.101','访问请求由于 系统维护中 被拦截<br />','error.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('48','GET','192.168.2.101','访问请求由于 系统维护中 被拦截<br />','error.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('49','GET','192.168.2.101','访问请求由于 系统维护中 被拦截<br />','error.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('50','GET','192.168.2.101','访问请求由于 系统维护中 被拦截<br />','error.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('51','GET','192.168.2.101','访问请求由于 系统维护中 被拦截<br />','error.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('52','GET','192.168.2.101','访问请求由于 系统维护中 被拦截<br />','error.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('53','GET','192.168.2.101','访问请求由于 系统维护中 被拦截<br />','error.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('54','GET','192.168.2.101','访问请求由于 系统维护中 被拦截<br />','error.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('55','GET','192.168.2.101','访问请求由于 系统维护中 被拦截<br />','error.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('56','GET','192.168.2.101','访问请求由于 系统维护中 被拦截<br />','error.php','18/09/11');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('57','GET','192.168.2.101','访问请求由于 系统维护中 被拦截<br />','error.php','18/09/12');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('58','GET','127.0.0.1','访问请求由于 系统维护中 被拦截<br />','error.php','18/10/04');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('59','POST','127.0.0.1','用户登陆成功','Login.php','18/10/04');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('60','GET','127.0.0.1','加载模块：系统/音乐管理<br />实例对象：K:GithubSourceGeneralSystemadmin/system/music.php失败','404.php','18/10/04');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('61','GET','127.0.0.1','加载模块：系统/音乐管理<br />实例对象：K:GithubSourceGeneralSystemadmin/system/music.php失败','404.php','18/10/04');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('62','POST','127.0.0.1','用户登陆成功','Login.php','18/10/04');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('63','GET','127.0.0.1','加载模块：系统/音乐管理<br />实例对象：K:GithubSourceGeneralSystemadmin/system/music.php失败','404.php','18/10/04');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('64','GET','192.168.2.101','加载模块：系统/音乐管理<br />实例对象：K:GithubSourceGeneralSystemadmin/system/music.php失败','404.php','18/10/04');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('65','POST','192.168.2.101','用户登陆成功','Login.php','18/10/04');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('66','GET','192.168.2.101','加载模块：系统/音乐管理<br />实例对象：K:GithubSourceGeneralSystemadmin/system/music.php失败','404.php','18/10/04');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('67','POST','127.0.0.1','用户登陆成功','Login.php','18/10/04');
CREATE TABLE `system_setting` (
  `vars` text NOT NULL,
  `value` text NOT NULL,
  `备注` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `system_setting`(`vars`,`value`,`备注`) values('server_status','0','系统状态');
insert into `system_setting`(`vars`,`value`,`备注`) values('corp','Source','版权');
insert into `system_setting`(`vars`,`value`,`备注`) values('version','1.0.0','版本号');
insert into `system_setting`(`vars`,`value`,`备注`) values('logo','images/logo.png','logo');
insert into `system_setting`(`vars`,`value`,`备注`) values('name','Source','');
insert into `system_setting`(`vars`,`value`,`备注`) values('upload_size','10','上传大小(MB)');
insert into `system_setting`(`vars`,`value`,`备注`) values('upload_name','','允许上传类型');
insert into `system_setting`(`vars`,`value`,`备注`) values('bottom','Copyright © 2001-2029 Source. All Rights Reserved.','页面底部信息');
insert into `system_setting`(`vars`,`value`,`备注`) values('server_infomaction','The system is under maintenance. Please visit later.<br>','系统维护显示信息');
insert into `system_setting`(`vars`,`value`,`备注`) values('encrypted','admin','密码加密字符串');
insert into `system_setting`(`vars`,`value`,`备注`) values('bugreport','2','Bug提交方式');
insert into `system_setting`(`vars`,`value`,`备注`) values('reportaddress','','外部提交地址');
insert into `system_setting`(`vars`,`value`,`备注`) values('pagedisplay','','列表每页显示数量');
insert into `system_setting`(`vars`,`value`,`备注`) values('index_status','0','是否启用首页模块，0为启用，1为禁用');
insert into `system_setting`(`vars`,`value`,`备注`) values('index_page','','默认显示首页内容');
insert into `system_setting`(`vars`,`value`,`备注`) values('index_page_all','','已安装首页模块
模块模板信息：uid;name;addr|uid;name;addr');
insert into `system_setting`(`vars`,`value`,`备注`) values('update_status','null','更新状态，用于判断是否为定制版');
CREATE TABLE `table_list` (
  `table` text NOT NULL,
  `class` text,
  `Index` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `table_list`(`table`,`class`,`Index`) values('系统','icon-cog','admin.php');
