<?php
error_reporting(0);
$_GET['code'] = empty($_GET['code']) ? '' : $_GET['code'];
switch($_GET['code']) 
{
	case '503':
	$title = '系统正在维护中！';
	require_once("Init.php"); //初始化基础参数		
	$content = $dou->Info('server_infomaction');
	$dou -> WriteLog('GET', '访问请求由于 系统维护中 被拦截<br />','error.php');
	break;
		
	case '402':
	$title = '获取歌曲信息失败';
	$content = '歌曲受版权保护，管理员已禁止该歌曲播放与下载功能！';
	break;
		
	case '342':
	$title = '系统数据检查失败';
	$content = '检测到一个或多个核心数据字段丢失，请删除kernl目录下的conf文件，重新安装系统！';
	break;	
		
	case '336:1':
	$title = '操作非法';
	$content = '当前操作不在系统许可范围内，请检查后重试！';
	break;
	
	case '336:2':
	$title = '操作非法';
	$content = 'Session值校验异常，请检查后重试！';
	break;	
		
	case '336:3':
	$title = '操作非法';
	$content = '用户检查失败,系统安装未完成！';
	break;		
		
	case '336:4':
	$title = '路径检查失败';
	$content = '路径检查失败，系统仅支持在一级目录下安装！';
	break;	
		
	case '195':
	$title = '浏览器检查失败！';
	$content = '当前浏览器版本不受支持，请更新浏览器或更换为更安全的Google浏览器';
	break;		
		
	case '330':
	$title = '管理员已禁用留言板';
	$content = '管理员已禁用留言板，如需帮助请与网站管理员联系！&nbsp; &nbsp; <a href="../index.php">返回首页</a>';
	break;			
		
	default:
	echo '<script language="JavaScript">window.alert("参数错误！")</script>';
	echo '<script language="JavaScript">window.opener=null;window.open("","_self");window.close();</script>'; 
	break;
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title ; ?></title>


</head>
<body>
  <div id="main">
    <header id="header">
      <h1><span class="sub"><?php echo $title ; ?></span></h1>
    </header>
    <div id="content">
      <p>[ 错误原因 ] <?php echo $content ; ?><br /> [ 出错时间 ] <?php echo date("y/m/d H:i:s",time()); ?> [ 访问IP ] <?php echo $_SERVER["REMOTE_ADDR"]; ?></p>
      
    </div>
</div>
</html>