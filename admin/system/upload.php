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
	echo json_encode(array('status'=>'-1','message'=>'请求参数错误'));
	exit;
	
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
			echo json_encode(array('status'=>'-1','message'=>'文件大小超过限制'));
			exit;
		}
	} 
	
	//文件格式检查
	$type = '.'. pathinfo($picname, PATHINFO_EXTENSION);
	$tmp = explode('、', $fileico[$key]);
	for ($x=0; $x<count($tmp); $x++) 
	{
  		if (strtolower($type) != strtolower($tmp[$x]) ) 
		{	
  			echo json_encode(array('status'=>'-1','message'=>'文件格式错误！'));
			exit;
		} 
	} 
	

		//文件上传并保存
	$rand = rand(100, 999);
	$pics = date("YmdHis") . $rand . $type;
	$modulename = str_replace(strrchr($picname, "."),"",$picname);
		//上传路径
	$pic_path = $filepath[$key] . $pics;
	move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
	
	if($frame == 'module')  //如果为模块，则执行解压操作
	{
		$zip = new ZipArchive();
		if($zip -> open($pic_path) != true)
		{
			$moduledata = 'Could not open Module Files';
		}
		$zip -> extractTo('../../module/'.$modulename);
		$zip -> close();
		$dou -> ModuleInstall('module/'.$modulename);
		$moduledata = 'Module File Install Complete!';
	}
	
		$size = round($picsize/1024,2);
		$arr = array(
			'name'=>$picname,
			'pic'=>$pics,
			'size'=>$size,
			'status'=>'0',
			'message'=>$moduledata
		);
		echo json_encode($arr);
		

} elseif ( $action == 'del' ) 
	
{
	$filename = $_POST['imagename'];
	if(!empty($filename))
	{
		unlink($filepath[$key].$filename);
		echo json_encode(array('status'=>'0','message'=>''));
	} else {
		echo json_encode(array('status'=>'-1','message'=>'删除失败！'));
	}
	
}
?>