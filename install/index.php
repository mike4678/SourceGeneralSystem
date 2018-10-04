<?php
error_reporting(0);

$file = '../kernl/Conf.php';     
if(file_exists(strtolower($file)) == TRUE)  //如果不存在则跳转到安装界面
{  
	header("Location: ../index.php"); //重定向浏览器
	exit;
} 

require('../kernl/Account.Class.php');

function WriteMysql() 
{
	$mysqlFile = "install.sql";	 //sql配置文件
	set_time_limit(0); //设置超时时间为0，表示一直执行。当php在safe mode模式下无效，此时可能会导致导入超时，此时需要分段导入
	$GLOBALS["fp"] = fopen($mysqlFile,"r") or die("初始化SQL文件 $mysqlFile 失败");//打开文件
	$link = mysqli_connect($_POST["mysqlHost"], $_POST["mysqlUser"], $_POST["mysqlPass"], $_POST["mysqlName"]) or die("不能连接数据库".$_POST["mysqlHost"]);//连接数据库
	mysqli_query($link , "set names utf8;");
	echo "正在执行导入操作……<br />";
	while( $SQL = GetNextSQL() )
	{
		if (!mysqli_query($link , $SQL))
		{
			echo "<cite>执行出错：".mysqli_error($link)."</cite><br />";
			echo "SQL语句为：<br />".$SQL."<br />";
			echo "<cite style='color:#e33;'>数据库初始化失败！请删除数据库下的所有数据表重新安装。</cite><br />";
			echo '</div>
				<div class="loginBox">
				<p style="padding:10px 0 0;text-align:center;">
					<input type="submit" class="submit" value="跳过" onclick="location=\'setting.php\';"; />
				</p></div>';
			exit;
		}
	}
	echo "<cite>数据库初始化成功！</cite><br />";
	fclose($GLOBALS["fp"]) or die("Can't close file $mysqlFile");//关闭文件
}

function GetNextSQL() 
{
global $fp;
$sql="";
while ($line = @fgets($fp, 40960)) {
	$line = trim($line);
	// $line = stripcslashes($line);
	if (strlen($line)>1) {
		if ($line[0]=="-" && $line[1]=="-") {
			continue;
		}
	}
	$sql.=$line.chr(13).chr(10);
	if (strlen($line)>0){
			if ($line[strlen($line)-1]==";"){
				break;
			}
		}
	}
	return $sql; //从文件中逐条取SQL
}

function writeConfig()
{	
	$cfgContent = '<?php
date_default_timezone_set("Asia/Shanghai"); //时区设定
define("DBSERVER", "'.$_POST["mysqlHost"].'"); //你的MySQL主机
define("USER","'.$_POST["mysqlUser"].'"); //你的MySQL帐户
define("PASSWORD","'.$_POST["mysqlPass"].'"); //你的MySQL密码
define("DB", "'.$_POST["mysqlName"].'"); //你的数据库名
define("Time",date("y/m/d H:i:s",time()));
define("Debug","off");   //调试模式
?>';
	$makeFile = "../kernl/conf.php";
	chmod("../kernl",0777);
	$handle = fopen($makeFile,"w"); //打开文件指针，创建文件
	if (!is_writable($makeFile)) die("<cite>网站配置文件生成失败，".$makeFile."不可写，请检查文件或目录属性后重试！</cite><br />");
	if (!fwrite($handle,$cfgContent)) die("<cite>生成网站配置文件".$makeFile."失败！</cite><br />"); //将信息写入文件
	fclose($handle); //关闭指针
	echo ("<cite>网站配置文件生成成功！</cite><br />");
	setcookie("session", PwdEnc(time(), 'administrator'), time()+3600); 
	header("Location: setting.php?session=".PwdEnc(time(), 'administrator')); //重定向浏览器
	exit;
}

if (isset($_GET['action']) && addslashes($_GET['action']) == "install") 
{
	WriteMysql();
	WriteConfig();
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html,charset=utf-8" />
<meta name="viewport" content="width=device-width,inital-scale=1,maximum-scale=1,user-scalable=no;" /> 
<title>Source 音乐搜索系统 - 在线安装</title>
<link href="install.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function tSubmit(form){
	if(form.mysqlUser.value == ''){
		alert('请输入数据库用户名！');
		form.mysqlUser.focus();
		return false;
	}	
	if(form.mysqlPass.value == ''){
		alert('请输入数据库密码！');
		form.mysqlName.focus();
		return false;
	}
	if(form.mysqlName.value == ''){
		alert('请输入数据库名称！');
		form.mysqlName.focus();
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
			<li><a class="selected">系统安装</a></li>
		</ul>
	</div>
</div>
<div class="main">
	<div class="box">
		<div class="content">
			<div class="loginBox">
				<form method="post" action="index.php?action=install" onSubmit="return tSubmit(this);">
				<p><label for="mysqlHost">MySQL主机</label>
					<input type="text" name="mysqlHost" id="mysqlHost" value="localhost" maxlength="50" tabindex="1" />
					如你不确定，请勿修改此项。
				</p>
				<p><label for="mysqlUser">数据库用户名</label>
					<input type="text" name="mysqlUser" id="mysqlUser" maxlength="30" tabindex="2" />
					你的MySQL帐户。
				</p>
				<p><label for="mysqlPass">数据库密码</label>
					<input type="password" name="mysqlPass" id="mysqlPass" maxlength="30" tabindex="3" />
					你的MySQL密码。
				</p>
				<p><label for="mysqlName">数据库名称</label>
					<input type="text" name="mysqlName" id="mysqlName" maxlength="30" tabindex="4" />
					你的数据库名称，请先确认此数据库存在。
				</p>
				<p><label for="mysqlName">用户协议</label>
				<input name="checkbox" type="checkbox" id="acc" style="width:20px" checked disabled>我接受用户<a href="#">使用许可协议</a></p>
				<p style="float:left;padding:10px 0 20px 105px;">
					<input type="submit" class="submit" value="安装" tabindex="6" />
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