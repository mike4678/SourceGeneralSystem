<?php 
require("../kernl/Init.php"); //初始化基础参数

//判断之前的登陆状态
$state = $dou -> AccountState();
if ($state != 'Access denied') 
{
	header("Location: admin.php"); //重定向浏览器到播放界面
}

if ($_COOKIE["SourceTryCount"] >= $_G['Login']['MaxNumber']) 

{ 
	//echo $dou -> Sys_ErrorPage(999);
	//exit; 
}
//基础网页内容
$var = '<div class="login_m">
			<div class="login_padding login_title">
	  			<div align="center"><strong>'.$dou -> Info('corp').'中央认证系统</strong></div>
			</div>
			<div id="login_boder" class="login_boder">
				<div class="login_padding">
					<label>
						<h2>用户名</h2>
						<form method="post" action="login_check.php">
						<input type="hidden" id="return" name="return" value="'.$_GET['ref'].'">
						<input type="text" id="username" name="username" class="txt_input txt_input2" onfocus="if (value ==&#39;Your name&#39;){value =&#39;&#39;}" onblur="if (value ==&#39;&#39;){value=&#39;Your name&#39;}" value="Your name">
					</label>
					<label>
						<h2>密码</h2>
						<input type="password" name="password" id="userpwd" class="txt_input" onfocus="if (value ==&#39;******&#39;){value =&#39;&#39;}" onblur="if (value ==&#39;&#39;){value=&#39;******&#39;}" value="******">
					</label>
					<label id=\'code\'>
						<h2>验证码</h2>
						<input type="text" id="code" name="code" class="txt_input txt_input2" style=\'width: 235px; height: 38px;\'>
						<img src = \'code.php\' id=\'showcode\' onclick=\'GetCode();\' style=\'top: -5px;\'>
					</label>
					<p class="forgot"></p>
					<div id="rem_sub" class="rem_sub" style=\'margin-top: -10px;\'>
						<div class="rem_sub_l">
							<input type="checkbox" name="checkbox" id="save_me">
							<label for="checkbox">记住登陆信息</label>
						</div>
						<label>
							<input type="submit" class="sub_button" name="button" id="button" value="登录" style="opacity: 0.7;">
						</label>
					</form>
					</div>
				</div>
			</div>
		</div>
		<div id=\'corp\' align="center"><strong>'.$dou -> Info('bottom').'</strong></div>';
	

//判断登陆失败次数，后台增加设置尝试次数，超过则跳转到错误页，超过3次则加载验证码
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php $dou -> Info('corp'); ?>后台管理系统</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script src="../js/global.js"></script>
</head>
<body class="login">
<?php echo $var; ?>
</body>
</html>
<?php 
//判断验证码是否启用
if ($dou -> Info('VaildCode') == 1) 
{
	echo "<script>javascript:LoginStatus(2);</script>";
} else {
	echo "<script>javascript:LoginStatus(1);</script>";
}

//if($_COOKIE["SourceTryCount"] == 0 || $_COOKIE["SourceTryCount"] <= 3 )
//{
	//echo "<script>javascript:LoginStatus(1);</script>";
//} else {
	//echo "<script>javascript:LoginStatus(2);</script>";
//}
?>
