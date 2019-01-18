<?php 
require("../kernl/Init.php"); 

//************** 处理登陆状态
$dou -> WSCS_Check();                    //安全检查，防护系统
$state = $dou -> AccountState();
$addr = $dou -> AddrConvery($_GET);	 //初始化参数
if ($state == 'Access denied') 
{
	if( count($addr) > 0 && $addr[1] != 'exit') 
	{
		header("Location: login.php?ref=/".$addr[1]."/".$addr[2]);
		
	} else { 
		
		header("Location: login.php"); }
	
} else { 
	
	$dou->cookie("state", time(), time()+3600);  //更新时间
}
	
echo str_replace("\$corp$",$dou -> Info('corp'),$dou -> Info('Index_head')); //初始化页面Head
//************** 处理页面请求
if($addr[1] == 'exit') 
{ 
		
	session_start();
	session_unset($Session);
	session_destroy();
	setcookie("usr", null, time()-3600);  
	setcookie("pwd", null, time()-3600);  
	setcookie("state", null, time()-3600); 
	//exit;
	echo '<script language="JavaScript">SystemBox(3,"您已成功退出系统！");</script>';
	echo '<script language="JavaScript">location.replace("login.php");</script>'; 
		
}

//用于系统探针	
if($addr[1] == 'phpinfo') 
{ 
	//$dou -> FormCheck('phpinfo'); //防跨页面查看	
	phpinfo();
	exit();
		
}
	
if($addr[1] == "Function")
{
	//$dou -> FormCheck('Function'); //防跨页面查看
	$arr = get_defined_functions();
	echo "<pre>";
	echo "当前系统所支持的所有函数,和自定义函数\n";
	print_r($arr);
	echo "</pre>";
	exit();
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
					echo "<a href='admin.php' class='icon-home'> 首页</a> > <li>后台首页</li>";
					
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