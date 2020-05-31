<?php 
$_G['SYSTEM']['PATH'] = str_replace(strtolower('admin/admin.php'), '', str_replace('\\', '/', strtolower(__FILE__)));
require($_G['SYSTEM']['PATH'] . "kernl/Init.php"); 

//************** 处理登陆状态
$dou -> WSCS_Check();                //请求代码安全检查
$state = $dou -> AccountState();     //获取账户状态
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
	
//************** 开始处理页面请求
switch ($addr[1])
{
	case 'exit':
		session_start();
		session_unset($Session);
		session_destroy();
		setcookie("usr", null, time()-3600);  
		setcookie("pwd", null, time()-3600);  
		setcookie("state", null, time()-3600); 
		//exit;
		echo '<script language="JavaScript">SystemBox(3,"您已成功退出系统！");</script>';
		echo '<script language="JavaScript">location.replace("login.php");</script>'; 	
	break;
		
	case 'phpinfo':
		echo '<script src="../js/jquery-1.8.3.min.js"></script>';   //防止非正常调用查看
		$dou -> FormCheck('systeminfo');
		phpinfo();
	exit();
	
	case 'Function':
		echo '<script src="../js/jquery-1.8.3.min.js"></script>';   //防止非正常调用查看
		$dou -> FormCheck('systeminfo');
		$arr = get_defined_functions();
		echo "<pre>";
		echo "当前系统所支持的所有函数,和自定义函数\n";
		print_r($arr);
		echo "</pre>";
	exit();
	
	case 'downbackup':
		session_start();
		$filename = $_SESSION["filename"];
		if($filename != NULL || $filename != '' || file_get_contents($dou -> info('BackupFilePath') . '/' . $filename) != '')
		{
			$file = file_get_contents($dou -> info('BackupFilePath') . '/' . $filename);
			Header("Content-type: application/octet-stream"); 
			Header("Accept-Ranges: bytes"); 
			Header("Accept-Length: ".filesize($file)); 
			Header("Content-Disposition: attachment; filename=" . $filename); 
			// 输出文件内容 
			print_r($file);
		} else {   //非正常调用
			echo "<script language='JavaScript'>window.location.href = 'admin.php?'</script>";
		}
	exit();
		
	default:
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
}	

//生成首页Heard部分
$value = $dou -> Info('Index_head');
preg_match_all("|{(.*)}|U", $value, $out, PREG_PATTERN_ORDER); //寻找文本中的{}字段内容
$tlist = 0;
while ($tlist <= count($out[1]) - 1)  
{
	$name = "{".$out[1][$tlist]."}";
	if($out[1][$tlist] != 'table_list')
	{
		
		$HeadData = $dou -> Info($out[1][$tlist]);
		
	} else {
		
		$HeadData = $dou -> table_list($tab,$list);
		
	}
	$value = str_ireplace($name,$HeadData,$value);	
	$tlist = $tlist + 1;
	
} 
//生成结束
$PageData = $value;
	
if ($addr[1] != "") 
{
	$PageData.= $dou -> navigation($tab,$list);
					
} else {
	
	$PageData.= "<a href='admin.php' class='icon-home'> 首页</a> > <li>后台首页</li>";
					
}

$PageData.='</ul></div></div></div><div class="admin">';

echo $PageData;

// 初始化框架页面
$bottom = $dou->PageLoading($data[2],$data[3]);
$file = dirname(__FILE__) . '/' . $bottom; 
if(file_exists(strtolower($file)) != TRUE)  //检查页面是否存在
{  //不存在
	echo $dou -> Admin_ErrorPage ( $addr[1] , $addr[2] , $file); 
		
} else 
{    
	include $bottom;
}
?>
</div></body></html>