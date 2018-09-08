<?php
error_reporting(0);
require("kernl/Init.php"); //初始化基础参数
if($dou -> CheckIndexState() == 0 ) //网站状态检查
{
	include $dou -> IndexPage(1);    //返回系统默认首页
} else {
	if($dou -> IndexFile() != NULL)
	{
		$file = dirname(__FILE__) . '/' . $dou -> IndexFile(); 
		if(file_exists(strtolower($file)) != TRUE)  //检查页面是否存在
		{  
			include $dou -> IndexPage(2);   //如果不存在则跳转到错误界面
		} else 
			{     
				include $dou -> CheckIndexFile();
			}
	} else 
		{
			include $dou -> IndexPage(3);
		}
	//header('Location: /m/index.php'); 
	//exit;
	}
?>