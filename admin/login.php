<?php 
error_reporting(0);
require("../kernl/Init.php"); //初始化基础参数

//判断之前的登陆状态
$state = $dou -> AccountState();
if ($state != 'Access denied') 
{
	header("Location: admin.php"); //重定向浏览器到播放界面
}
?>
<!DOCTYPE html>
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