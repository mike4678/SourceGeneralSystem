<?php 
require("../kernl/Init.php"); //初始化基础参数

//判断之前的登陆状态
$state = $dou -> AccountState();
if ($state != 'Access denied') 
{
	header("Location: admin.php"); //重定向浏览器到播放界面
}

//判断登陆失败次数，后台增加设置尝试次数，超过则跳转到错误页，超过3次则加载验证码
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
.login_boder{ background: url(../images/loginCode_m_bg.png) no-repeat; height:302px; overflow:hidden;}
.login_padding{ padding:28px 47px 20px 47px ;}	
-->
</style>
<script>
function LoginStatus(value)
{
	if(value = 1) //Normal
	{
		document.getElementById("login_boder").style.backgroundImage="url(../images/login_m_bg.png)";
		document.getElementById("login_boder").style.height='302px';
		document.getElementById("login_padding").style.padding='28px 47px 20px 47px';
		
	} else {
		
		document.getElementById("login_boder").style.backgroundImage="url(../images/logincode_m_bg.png)";
		document.getElementById("login_boder").style.height='380px';
		document.getElementById("login_padding").style.padding='28px 47px 20px 47px';
	}
	
}
function GetCode() 
{
	var obj=document.getElementById("showcode");
	obj.src="code.php?"+ Math.random();
}	
</script>	
</head>
<body class="login">
<div class="login_m">
	<div class="login_padding STYLE1">
	  <div align="center"><strong><?php $dou -> Info('corp'); ?>中央认证系统</strong></div>
	</div>
<div id="login_boder" class="login_boder">
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
			<h2>验证码</h2>
				<input type="text" id="code" name="code" class="txt_input txt_input2" style='width: 240px; height: 38px;'>
			<img src = 'code.php' id='showcode' onclick='GetCode();' style='top: -5px;'>
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

