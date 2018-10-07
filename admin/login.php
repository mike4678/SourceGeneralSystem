<?php 
error_reporting(0);
require("../kernl/Init.php"); //初始化基础参数

//判断之前的登陆状态
$_COOKIE['state'] = empty($_COOKIE['state']) ? '' : $_COOKIE['state'];
if($_COOKIE['state'] != NULL )  //已经登陆过，且记录还存在
{
	$user = $_COOKIE['usr'];
	$pwd = $_COOKIE['pwd'];
	$time = $_COOKIE['state'];
	$now = time();
	if($time > $now - 3600) 
	{
		$dou -> query("select * from admin_user where username = '$user' and password = '$pwd'");		
		if( $dou -> affected_rows() == NULL ) 
		{
			echo '<script language="JavaScript">window.alert("账户信息验证失败，请重新登陆！")</script>';
		} else {
			header("Location: admin.php"); //重定向浏览器到播放界面
		}
	} else {
		echo '<script language="JavaScript">window.alert("Session异常，请重新登陆！")</script>';
		
		$dou->cookie("usr", '', time()-3600*24*365);
		$dou->cookie("pwd", '', time()-3600*24*365);    //一个小时3600*一天24小时*365天
		$dou->cookie("state", '', time()-3600*24*365);
		}
}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php $dou -> Info('corp'); ?>后台管理系统</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.STYLE1 {font-size: 24px}
-->
</style>
</head>
<body class="login">
<div class="login_m">
	<div class="login_padding STYLE1">
	  <div align="center"><strong><?php $dou -> Info('corp'); ?>中央认证系统</strong></div>
	</div>
<div class="login_boder">
		<div class="login_padding">
			<h2>用户名</h2>
			<form method="post" action="login_check.php">
				<input type="hidden" id="return" name="return" value="<?php echo $_GET['ref']; ?>">
				<input type="text" id="username" name="username" class="txt_input txt_input2" onfocus="if (value ==&#39;Your name&#39;){value =&#39;&#39;}" onblur="if (value ==&#39;&#39;){value=&#39;Your name&#39;}" value="Your name">
			</label>
			<h2>密码</h2>
			<label>
				<input type="password" name="password" id="userpwd" class="txt_input" onfocus="if (value ==&#39;******&#39;){value =&#39;&#39;}" onblur="if (value ==&#39;&#39;){value=&#39;******&#39;}" value="******">
			</label>
			<p class="forgot"></p>
			<div class="rem_sub">
				<div class="rem_sub_l">
					<input type="checkbox" name="checkbox" id="save_me">
					<label for="checkbox">记住登陆信息</label>
				</div>
				<label>
					<input type="submit" class="sub_button" name="button" id="button" value="登录" style="opacity: 0.7;">
				</form>
			</div>
		</div>
	</div>
</div>
<div align="center"><strong><?php echo $dou -> Info('bottom') ; ?></strong></div>
<br />
<br />
</body>
</html>