CREATE TABLE `admin_user` (
  `username` text NOT NULL,
  `password` text NOT NULL,
  `lastip` text,
  `lasttime` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `admin_user`(`username`,`password`,`lastip`,`lasttime`) values('admin','k5WfnKA=','192.168.1.101','19/02/01 21:05:08');
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
insert into `adminlist`(`t_e`,`m_e`,`table`,`menu`,`url`,`page`,`count`) values('system','module','系统','模块管理','admin.php?/system/module','system/module.php','1');
insert into `adminlist`(`t_e`,`m_e`,`table`,`menu`,`url`,`page`,`count`) values('system','ips','系统','IP防火墙','admin.php?/system/ips','system/ips.php','1');
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
}','<div class=\"panel-head\"><strong>系统日志</strong></div>
        <div class=\"padding border-bottom\">
        	<input type=\"button\" class=\"button button-small checkall\" name=\"checkall\" checkfor=\"id[]\" value=\"全选\">
            <input type=\"submit\" class=\"button button-small border-yellow\" value=\"批量删除\"  />
        </div>
        <table class=\"table table-hover\">
        	<tr><th width=\"5%\">选择</th><th width=\"10%\">请求方式</th><th width=\"25%\" style=\"text-align:center\">操作内容</th><th width=\"14%\" style=\"text-align:center\">操作ip</th><th width=\"8%\" >&nbsp;&nbsp;&nbsp;时间</th><th width=\"8%\">&nbsp;操作</th></tr>','<tr><td>&nbsp;<input type=\'checkbox\' name=\'id[]\' value=\'{id}\'><input name=\'d\' type=\'hidden\' value=\'systemlog\'></td><td>&nbsp;&nbsp;{method}</td><td align=center><a href=\'javascript:SystemBox(3,\"{data}<br/>操作IP：{ip}&nbsp;&nbsp;操作时间：{time}\")\'>点击查看</td><td style=\'text-align:center\'>{ip}</td><td>{time}</td><td>&nbsp;<a class=\'button border-yellow button-little\' href=\'#\' onclick=\"javascript:Del(\'$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]/id{id} \')\">删除</a></td></tr>');
CREATE TABLE `system_ips` (
  `iptable` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `system_ips`(`iptable`,`type`) values('192.168.2.5','1');
insert into `system_ips`(`iptable`,`type`) values('192.168.*.1','0');
insert into `system_ips`(`iptable`,`type`) values('192.168.1.1','2');
CREATE TABLE `system_log` (
  `id` int(11) NOT NULL,
  `method` text,
  `ip` text NOT NULL,
  `data` text NOT NULL,
  `addr` text NOT NULL,
  `time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('1','POST','::1','管理员执行清空数据表操作','/admin/system/databasecontrol.php?control=%E6%B8%85%E7%A9%BA%E6%95%B0%E6%8D%AE%E5%BA%93&filename=','19/01/29');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('2','POST','192.168.1.101','用户登陆成功','Login.php','19/02/01');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('3','POST','192.168.1.101','管理员执行数据库备份','/admin/system/databasecontrol.php?control=%E5%A4%87%E4%BB%BD%E6%95%B0%E6%8D%AE%E5%BA%93&filename=','19/02/01');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('4','POST','192.168.1.101','删除备份：201902011210541.sql成功！','/admin/system/databasecontrol.php?control=%E5%88%A0%E9%99%A4%E5%A4%87%E4%BB%BD&filename=201902011210541.sql','19/02/01');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('5','POST','192.168.1.101','管理员执行数据库备份','/admin/system/databasecontrol.php?control=%E5%A4%87%E4%BB%BD%E6%95%B0%E6%8D%AE%E5%BA%93&filename=','19/02/01');
insert into `system_log`(`id`,`method`,`ip`,`data`,`addr`,`time`) values('6','POST','192.168.1.101','删除备份：201902011210611.sql成功！','/admin/system/databasecontrol.php?control=%E5%88%A0%E9%99%A4%E5%A4%87%E4%BB%BD&filename=201902011210611.sql','19/02/01');
CREATE TABLE `system_setting` (
  `vars` text NOT NULL,
  `value` text NOT NULL,
  `备注` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `system_setting`(`vars`,`value`,`备注`) values('server_status','0','系统状态');
insert into `system_setting`(`vars`,`value`,`备注`) values('corp','Source','版权');
insert into `system_setting`(`vars`,`value`,`备注`) values('version','1.0.0','版本号');
insert into `system_setting`(`vars`,`value`,`备注`) values('logo','../images/logo.png','logo');
insert into `system_setting`(`vars`,`value`,`备注`) values('name','Source','');
insert into `system_setting`(`vars`,`value`,`备注`) values('upload_size','79','上传大小(MB)');
insert into `system_setting`(`vars`,`value`,`备注`) values('bottom','Copyright © 2001-2029 Source. All Rights Reserved.','页面底部信息');
insert into `system_setting`(`vars`,`value`,`备注`) values('server_infomaction','The system is under maintenance. Please visit later.<br>','系统维护显示信息');
insert into `system_setting`(`vars`,`value`,`备注`) values('encrypted','admin','密码加密字符串');
insert into `system_setting`(`vars`,`value`,`备注`) values('bugreport','2','Bug提交方式');
insert into `system_setting`(`vars`,`value`,`备注`) values('reportaddress','','外部提交地址');
insert into `system_setting`(`vars`,`value`,`备注`) values('pagedisplay','20','列表每页显示数量');
insert into `system_setting`(`vars`,`value`,`备注`) values('index_status','0','是否启用首页模块，0为启用，1为禁用');
insert into `system_setting`(`vars`,`value`,`备注`) values('index_page','admin/system/info.php','默认显示首页内容');
insert into `system_setting`(`vars`,`value`,`备注`) values('index_page_all','1;后台管理;admin/login.php|2;系统信息;admin/system/info.php','已安装首页模块
模块模板信息：uid;name;addr|uid;name;addr');
insert into `system_setting`(`vars`,`value`,`备注`) values('update_status','null','更新状态，用于判断是否为定制版');
insert into `system_setting`(`vars`,`value`,`备注`) values('ipfirewall_status','0','是否启用ip防火墙模块，0为启用，1为禁用');
insert into `system_setting`(`vars`,`value`,`备注`) values('ipfirewall_mode','1','ip防火墙黑白名单模式，0为白名单，1为黑名单');
insert into `system_setting`(`vars`,`value`,`备注`) values('system_table','系统;icon-cog;admin.php|','后台顶部夹显示部分,格式：name;logo;addr 用|分割');
insert into `system_setting`(`vars`,`value`,`备注`) values('upload_frame','system;.png、.jpg、.gif;../../images/|module;.zip;../../module/|','上传框架,格式：框架名;允许文件类型，多个用、隔开;要上传到的目录，多个框架用|分割');
insert into `system_setting`(`vars`,`value`,`备注`) values('MaxCount','4','后台登陆界面最大尝试次数');
insert into `system_setting`(`vars`,`value`,`备注`) values('VaildCode','0','后台登陆是否启用验证码，0为启用，1为关闭');
insert into `system_setting`(`vars`,`value`,`备注`) values('AllowDatabase','system_log;','可清空的数据库表名');
insert into `system_setting`(`vars`,`value`,`备注`) values('Index_head','<!DOCTYPE html>
<html lang=\"zh-cn\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\" />
    <meta name=\"renderer\" content=\"webkit\">
    <title>{corp}后台管理系统</title>
    <link rel=\"stylesheet\" href=\"../css/pintuer.css\">
    <link rel=\"stylesheet\" href=\"../css/admin.css\">
    <link rel=\"stylesheet\" href=\"../css/popup.css\">
    <link rel=\"stylesheet\" href=\"../css/puyuetian.css\">
    <script src=\"../js/jquery-1.8.3.min.js\"></script>
    <script src=\"../js/pintuer.js\"></script>
    <script src=\"../js/respond.js\"></script>
    <script src=\"../js/global.js\"></script>
    <script src=\"../js/artDialog.js?skin=default\"></script>	
    <script src=\"../js/iframeTools.js\"></script>
    <script type=\"text/javascript\" src=\"../js/jquery-1.8.1.min.js\"></script>
     <script type=\"text/javascript\">
        var $181 = $;
     </script>
</head>
<body>
<div class=\"lefter\">
    <div class=\"logo\">
    <a href=\'#\' target=\'_blank\'><img src=\'{logo}\' alt=\'Logo\' width=\'94\' height=\'40\'/></a></div>	
</div>
<div class=\"righter nav-navicon\" id=\"admin-nav\">
    <div class=\"mainer\">
        <div class=\"admin-navbar\">
            <span class=\"float-right\">
            	<a class=\"button button-little bg-main\" href=\"../index.php\" target=\"_blank\">前台首页</a>
                <a class=\"button button-little bg-yellow\" href=\"?/exit\">注销登录</a>
            </span>
            <ul class=\"nav nav-inline admin-nav\">
            {table_list}
            </ul>
        </div>
        <div class=\"admin-bread\">
            <ul class=\"bread\">','后台界面头部');
insert into `system_setting`(`vars`,`value`,`备注`) values('BackupFilePath','backup','备份文件存放路径');
