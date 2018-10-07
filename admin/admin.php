<?php 
error_reporting(0);
require("../kernl/Init.php"); 
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title><?php echo $dou -> Info('corp'); ?>后台管理系统</title>
    <link rel="stylesheet" href="../css/pintuer.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/popup.css">
	<link rel="stylesheet" href="../css/puyuetian.css">
    <!-- script src="../js/jquery.js"></script -->
    <script type="text/javascript" src="http://api.csource.com.cn/1.8.1/jquery-1.8.1.min.js"></script>
    <script src="../js/pintuer.js"></script>
    <script src="../js/respond.js"></script>
    <script src="../js/artDialog.js?skin=default"></script>
    <script src="../js/iframeTools.js"></script>

</head>

<body>
<?php 
//******* 处理登陆状态
$state = $dou -> AccountState();
$addr = $dou->AddrConvery($_GET);	 //初始化参数
	
if ($state == '1') 
{
	if( count($addr) > 0 ) 
	{
		header("Location: login.php?ref=/".$addr[1]."/".$addr[2]);
		
	} else { 
		
		header("Location: login.php"); }
	
} else { 
	
	$dou->cookie("state", time(), time()+3600);  //更新时间
}
//******* 处理页面请求
	if($addr[1] == 'exit') 
	{ 
		
		echo '<script language="JavaScript">location.replace("logout.php");</script>'; 
		
	}
	
	if ($addr[1] != "" && $addr[2] != "" )     //生成顶部导航和左边导航必须参数
	{ 
		$data = $dou->convert($addr[1],$addr[2]);
		if($data[2] != "" && $data[3] != "")  //判断当前要访问的变量是否存在，如
		{
			$tab = $data[2];      //如果存在，则继续执行当前变量
			$list = $data[3];
		} else {
			$data = $dou->convert('start','index');   //如果不存在，返回空则执行默认首页代码
			$tab = $data[2];
			$list = $data[3];
		}

	} else { 
		$data = $dou->convert('start','index');   //为空则判断为默认首页
		$tab = $data[2];
		$list = $data[3];
		}	
?>
<div class="lefter">
    <div class="logo">
    <a href='#' target='_blank'><img src='<?php echo $dou->Info('logo'); ?>' alt='Logo' width='94' height='40'/></a></div>	
</div>
<div class="righter nav-navicon" id="admin-nav">
    <div class="mainer">
        <div class="admin-navbar">
            <span class="float-right">
            	<a class="button button-little bg-main" href="../index.php" target="_blank">前台首页</a>
                <a class="button button-little bg-yellow" href="?/exit">注销登录</a>
            </span>
            <ul class="nav nav-inline admin-nav">
            <?php echo $dou->table_list($tab,$list); ?>
            </ul>
        </div>
        <div class="admin-bread">
         <?php
          if(Debug == "on") 
          {
          	echo '<span style="color: red">(测试模式)</span>';
          } 
          ?> 
            <ul class="bread">
                <?php 
				if ($addr[1] != "") 
				{
					
					echo $dou->navigation($tab,$list);
					
				} else
				 {
					echo "<li><a href='admin.php' class='icon-home'> 开始</a></li><li>后台首页</li>";
					
					}
				 ?>
            </ul></div></div></div>
<div class="admin">
<?php 
$bottom = $dou->PageLoading($data[2],$data[3]);
$file = dirname(__FILE__) . '/' . $bottom; 
if(file_exists(strtolower($file)) != TRUE)  //检查页面是否存在
{  
	
	include 'system/404.php';   //如果不存在则跳转到错误界面
	
} else 
	{    
	
		include $bottom;
	
	}
?>
</div>
</body>
</html>