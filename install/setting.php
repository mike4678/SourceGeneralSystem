<?php
error_reporting(0);

//配置文件检查
$file = '../kernl/Conf.php';      

if(file_exists(strtolower($file)) != TRUE)  //如果不存在则跳转到安装界面
{  
	header("Location: index.php"); //重定向浏览器
	exit;
} else {    //如果存在则引入该文件
	require_once '../kernl/Conf.php';
	}

//初始化模块
require('../kernl/Account.Class.php');
$link = mysqli_connect(DBSERVER, USER, PASSWORD, DB) or die("不能连接数据库".DBSERVER);//连接数据库

//判断当前是否传回Get值
if (isset($_GET['action']) && addslashes($_GET['action']) == "saveSet") { 
	//有传回
	echo '<div style="height:100px;line-height:100px;text-align:center;border:1px solid #b0e4ef;background:#eff;padding:5px;">';
	saveSet();
	echo '<cite style="color:#f00;">安装数据库和网站配置文件成功，请及时删除<strong>install</strong>目录！';
	echo '</div>';
	echo '<div class="loginBox">
				<p style="padding:10px 0 0;text-align:center;">
					<input type="submit" class="submit" value="进入后台" onclick="location=\'../admin/admin.php\';" />
				</p>
			</div>';
} else {
	//没有传回则校验session值是否正常
	$session = decrypt($_COOKIE['session'], 'administrator');;
	$install = $_GET['session'];
	if(!$session || !$install)
	{
		echo '<script language="JavaScript">location.replace("../kernl/error.php?code=336:1");</script>';
	}

	if( $install< $session ) 
	{
		echo '<script language="JavaScript">location.replace("../kernl/error.php?code=336:2");</script>';
	}
	
	//这里验证是否已经创建有登陆用户信息
	mysqli_query($link , "select * from admin_user;");
	if( mysqli_affected_rows($link) != NULL)
	{
		echo '<script language="JavaScript">location.replace("../kernl/error.php?code=336:3");</script>';
	}
	
}

function saveSet() 
{
$UserQuery = "INSERT INTO `admin_user` (`username`, `password`) VALUES ('". $_POST['adminacc'] ."', '". PwdEnc($_POST['adminpass'], $_POST['adminkey']) ."');";   //创建登陆用户
$KeyQuery = "UPDATE `system_setting` SET `value`='".$_POST['adminkey']."' WHERE `vars`='encrypted';";  //生成后台密码校验Key
$link = mysqli_connect(DBSERVER, USER, PASSWORD, DB) or die("不能连接数据库".DBSERVER);//连接数据库	
mysqli_query($link , $KeyQuery)	;
//$dou -> query($KeyQuery);
if( mysqli_affected_rows($link) == NULL)
	{
		echo '<script language="JavaScript">window.alert("创建后台加密Key失败！")</script>';
		echo '<script language="JavaScript">location.replace("setting.php");</script>';
	} else {
		mysqli_query($link , $UserQuery);
		if( mysqli_affected_rows($link) == NULL)
		{
		echo '<script language="JavaScript">window.alert("创建后台登陆账户失败")</script>';
		echo '<script language="JavaScript">location.replace("setting.php");</script>';
		}
		
	}	
}


//INSERT INTO `admin_user` (`username`, `password`) VALUES ('ser', '123456')  //导入
//UPDATE `system_setting` SET `value`='source1' WHERE `vars`='encrypted'；    //导入密码key
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html,charset=utf-8" />
<meta name="viewport" content="width=device-width,inital-scale=1,maximum-scale=1,user-scalable=no;" /> 
<title>初始化网站基础参数</title>
<link href="install.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function tSubmit(form){
	if(form.webname.value == ''){
		alert('请输入网站名称！');
		form.webname.focus();
		return false;
	}
	if(form.adminacc.value == ''){
		alert('请输入管理员帐户！');
		form.adminacc.focus();
		return false;
	}
	if(form.adminpass.value == ''){
		alert('请输入管理员密码！');
		form.adminpass.focus();
		return false;
	}
	if(form.adminkey.value == ''){
		alert('必须设定管理员密码校验Key值');
		form.adminkey.focus();
		return false;
	}
	return true;
}
</script>
</head>

<body>
<div class="head">
	<div class="box">
		<h1>Source 音乐搜索系统 - 在线安装</h1>
		<ul class="nav">
			<li><a href="http://bbs.csource.com.cn" target="_blank">官方网站</a></li>
			<li><a class="selected">参数设置</a></li>
		</ul>
	</div>
</div>
<div class="main">
	<div class="box">
		<div class="content">
			<div class="loginBox">
				<form method="post" action="setting.php?action=saveSet" onSubmit="return tSubmit(this);">
				<p><label for="webname">网站名称</label>
					<input type="text" name="webname" id="webname" maxlength="50" tabindex="1" />
					设置你的网站名称。
				</p>
				<p><label for="webname">管理员账号</label>
					<input type="text" name="adminacc" id="adminacc" maxlength="50" tabindex="1" />
					登陆后台的账号。
				</p>
				<p><label for="adminpass">管理员密码</label>
					<input type="password" name="adminpass" id="adminpass" maxlength="16" tabindex="4" />
					登陆后台的密码。
				</p>
				<p><label for="adminkey">系统密匙</label>
					<input type="text" name="adminkey" id="adminkey" maxlength="30" tabindex="5" />
					后台登陆密码生成所需Key值
				</p>
				<p style="float:left;padding:10px 0 20px 105px;">
					<input type="submit" class="submit" value="确定" tabindex="6" />
					<input type="reset" class="submit" value="重置" tabindex="7" />
				</p>
				</form>
			</div>
		</div>
		<div class="foot">
			Copyright &copy; 2009 - 2022 <a href="http://bbs.csource.com.cn" target="_blank">Source Inc</a>.
		</div>
	</div>
</div>
</body>
</html>