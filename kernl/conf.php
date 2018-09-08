<?php
date_default_timezone_set("Asia/Shanghai"); //时区设定
define("DBSERVER", "localhost"); //你的MySQL主机
define("USER","root"); //你的MySQL帐户
define("PASSWORD","123456"); //你的MySQL密码
define("DB", "services"); //你的数据库名
define("Time",date("y/m/d H:i:s",time()));
define("Debug","off");   //调试模式
?>