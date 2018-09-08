<?php
//初始化
date_default_timezone_set('PRC');
require_once '../../kernl/Conf.php';
error_reporting(0);

//模块初始化
$arr = array('Connect','System');
for ($i = 0 ; $i < count($arr); $i++){
	require('../../kernl/'.$arr[$i].'.Class.php');
}

// 实例化类
$dou = new System(DBSERVER, USER, PASSWORD, DB, 'utf8');

$state = $dou -> AccountState();
if ($state == '1') 
	header("Location: ../login.php");
//******* 处理登陆状态

// 参数检查
$dou -> CheckUploadSize();   //检查如果上传大小异常，则自动修复

//初始化参数
$action = empty($_GET['act']) ? '' : $_GET['act'];
$frame =  $_GET['frame'];
$syssize = $dou -> Info('upload_size');

if($action=='delfile'){
	switch($frame)
	{
		case 'system':
			$filename = $_POST['imagename'];
			if(!empty($filename)){
				unlink("../../images/".$filename);
				echo '1';
			}else{
				echo '删除失败.';
				}
		break;
		
		case 'music':
			$filename = $_POST['imagename'];
			if(!empty($filename)){
				unlink("../../upload/".$filename);
				echo '1';
			}else{
				echo '删除失败.';
				}
		break;
			
		case 'lrc':
			$filename = $_POST['imagename'];
			if(!empty($filename)){
				unlink("../../upload/".$filename);
				echo '1';
			}else{
				echo '删除失败.';
				}
		break;	
	
	}
}else{
	$picname = $_FILES['mypic']['name'];
	$picsize = $_FILES['mypic']['size'];
	if ($picname != "") {
		if ($picsize > $syssize * 1024 * 1024) {
			echo '文件大小超过系统限制';
			exit;
		} 
		
		switch($frame) 
		{
			case 'system':
				$type = strstr($picname, '.');
				if ($type != ".png" && $type != ".gif") {
					echo '文件格式不对！';
					exit;
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				//上传路径
				$pic_path = "../../images/". $pics;
				move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
				break;
				
			case 'lrc':
				$type = strstr($picname, '.');
				if ($type != ".lrc") {
					echo '文件格式不对！';
					exit;
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				//上传路径
				$pic_path = "../../upload/". $pics;
				move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
				break;
				
			case 'music':
				$type = strstr($picname, '.');
				$file_name = explode("|",$dou -> Info('upload_name'));
				foreach ($file_name as $value) 
				{
					if ($type != "." . $value) 
					{
					echo '文件格式不对！';
					exit;
					}
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				//上传路径
				$pic_path = "../../upload/". $pics;
				move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
				break;
		}
	}
	$size = round($picsize/1024,2);
	$arr = array(
		'name'=>$picname,
		'pic'=>$pics,
		'size'=>$size
	);
	echo json_encode($arr);
}
?>