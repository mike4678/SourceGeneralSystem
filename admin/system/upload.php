<?php
//*******************************
// Upload 上传模块
// 回传参数
// 旧版 frame=module
// 新版 act=del|add&ifr=xxx(对应数据库)
//*******************************

//初始化
date_default_timezone_set('PRC');
require_once '../../kernl/Conf.php';

//模块初始化
$arr = array('Connect','System');
for ($i = 0 ; $i < count($arr); $i++)
{
	require('../../kernl/'.$arr[$i].'.Class.php');
}

// 实例化类
$dou = new System(DBSERVER, USER, PASSWORD, DB, 'utf8');

//******* 处理登陆状态
$state = $dou -> AccountState();
if ($state == '1') 
{
	header("Location: ../login.php");
}
	
// 初始化参数列表
$UData = $dou -> UploadFrame();
foreach ($UData as $value)
{
	$select[count($select)] = $value[0];
	$filepath[count($filepath)] = $value[2];
	$fileico[count($fileico)] = $value[1];
}
	
//初始化参数
$action = empty($_GET['act']) ? '' : $_GET['act'];   //操作方式
$frame =  $_GET['ifr']; //框架
$syssize = $dou -> Info('upload_size');  //上传大小

//获取参数
if($action == NULL || $frame == NULL )
{
	die ("请求参数错误");
	
} else {
	
	$key = array_search($frame,$select); //取出当前框架的相关参数值id

}

if( $action == 'add' )
{
	//文件大小检查
	$picname = $_FILES['mypic']['name'];
	$picsize = $_FILES['mypic']['size'];
	if ($picname != "") 
	{
		if ($picsize > $syssize * 1024 * 1024) 
		{
			die('文件大小超过系统限制');
		}
	} 
	
	//文件格式检查
	$type = '.'. pathinfo($picname, PATHINFO_EXTENSION);
	$tmp = explode('、', $fileico[$key]);
	for ($x=0; $x<count($tmp); $x++) 
	{
  		if ($type == $tmp[$x] ) 
		{	
  			$upstatus = 'success';
		} 
	} 
	
	if($upstatus == 'success')
	{
		//文件上传并保存
		$rand = rand(100, 999);
		$pics = date("YmdHis") . $rand . $type;
		//上传路径
		$pic_path = $filepath[$key] . $pics;
		move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
	
		if($frame == 'module')  //如果为模块，则执行解压操作
		{
			$moduledata = 'Init '.$picname.' files  &#10';
			$moduledata.= 'File Size:'.round($picsize/1024,2)." KB";
			$zip = new ZipArchive();
			if($zip -> open($pic_path) != true)
			{
				$moduledata.= ' &#10Could not open archive';
			}
			$zip -> extractTo('../../module/'.$picname);
			$zip -> close();
			$moduledata.= '&#10File Init Complete!';
		}
	
		$size = round($picsize/1024,2);
		$arr = array(
			'name'=>$picname,
			'pic'=>$pics,
			'size'=>$size,
			'status'=>$moduledata
		);
		echo json_encode($arr);
		
	} else 
	{
		die('文件格式错误！');
	}

} elseif ( $action == 'del' ) 
	
{
	$filename = $_POST['imagename'];
	if(!empty($filename))
	{
		unlink($filepath[$key].$filename);
		echo '1';
	} else {
		echo '删除失败.';
	}
	
}
?>