<?php
//error_reporting(0);
require("kernl/Init.php"); //初始化基础参数
$dou -> CheckServerState(); //网站状态检查
if($dou -> Info("index_status") == 0 ) //网站状态检查
{
	echo $dou -> Index_ErrorPage(404);
	
} else 
	{
		if($dou -> Info("index_page") != NULL)
		{
			$file = dirname(__FILE__) . '/' . $dou -> Info("index_page"); 
			if(file_exists(strtolower($file)) != TRUE)  //检查页面是否存在
			{  
				
				echo $dou -> Index_ErrorPage(307);
				
			} else 
				{     
					$fh = file_get_contents( HttpsCheck(). $_SERVER['HTTP_HOST'] . $dou -> Info("index_page") );
					echo $fh;
					//header('Location: '. $dou -> Info("index_page")); //返回页面不存在
					//exit;
				}
		} else 
			{
				
				echo $dou -> Index_ErrorPage(301);

			}

	}
?>