<?php
error_reporting(0);
session_start();
session_unset($Session);
session_destroy();
setcookie("usr", null, time()-3600);  
setcookie("pwd", null, time()-3600);  
setcookie("state", null, time()-3600); 
echo '<script language="JavaScript">window.alert("您已成功退出系统！")</script>';
echo '<script language="JavaScript">location.replace("login.php");</script>';
?>