<?php 
//载入函数PHP
require("../kernl/Init.php"); //初始化基础参数

//初始化变量
$method = $_SERVER['REQUEST_METHOD']; //操作方式，post/GET
$addr = $_SERVER['PHP_SELF'].'?'.file_get_contents('php://input'); //提交地址
$username = $_POST['username'];  //用户名
$PWD = $_POST['password'];  //密码
$ref = empty($_POST['return']) ? '' : $_POST['return']; //跳转地址

if( key == NULL) 
{
	header("Location: ../kernl/error.php?code=342"); //重定向浏览器
}

//判断最基本的两个值是否为空
if (empty($username) || empty($PWD))  //判断POST回来的用户名或密码是否为空
{ 
	echo '<script language="JavaScript">window.alert("用户名或密码不能为空！");location.replace("login.php");<</script>';
} 

//首先更改用户tocket
$passcode = PwdEnc($PWD, key); //加密密码，同时将明文密码清除掉
$PWD = "";

//判断密码是否正确
$dou -> query("select * from admin_user where username = '$username' and password = '$passcode'"); //执行登陆操作
if( $dou -> affected_rows() == NULL)
{
	echo '<script language="JavaScript">window.alert("密码错误！")</script>';
	$dou -> WriteLog('POST', '用户尝试登陆，但密码错误！','Login.php');
	echo '<script language="JavaScript">location.replace("login.php");</script>';
	
} else {
	session_start(); //标志Session的开始 
	if($_POST['checkbox'] = 'on')   //判断是否记住登陆信息
	{
		$dou->cookie("usr", $username, time()+36000);
		$dou->cookie("pwd", $passcode, time()+36000); //一个小时3600*一天24小时*365天
		$dou->cookie("state", time(), time()+36000);		
		$_SESSION['username'] = $username; 
		$iipp = $dou->Get_LocalIP(); //获取登录者ip
		$time = constant("Time"); //获取登录时间
		$_SESSION['time'] = $time;
		$dou -> query("update admin_user set lasttime = '$time' , lastip = '$iipp' where username = '$username';");
		if($dou -> affected_rows() == NULL)
		{
			$dou -> WriteLog('POST', '用户登陆成功，但登陆状态更新失败！','Login.php');
			echo '<script language="JavaScript">window.alert("登陆状态更新失败！")</script>';
			header("Location: admin.php?".$ref);
		}  else { 						
			$dou -> WriteLog('POST', '用户登陆成功','Login.php');
			echo '正在跳转。。。。';
			header("Location: admin.php?".$ref);
			}
		
	} else {
			
		$dou -> query("update admin_user set lasttime = '$time' , lastip = '$iipp' where username = '$username';");
		if($dou -> affected_rows() == NULL)
		{
			$dou -> WriteLog('POST', '用户登陆成功，但登陆状态更新失败！','Login.php');
			echo '<script language="JavaScript">window.alert("登陆状态更新失败！")</script>';
			header("Location: admin.php?".$ref);
		}  else { 						
			$dou -> WriteLog('POST', '用户登陆成功','Login.php');
			echo '正在跳转。。。。';
			header("Location: admin.php?".$ref);
								}
					
						}
				
				} 
?>