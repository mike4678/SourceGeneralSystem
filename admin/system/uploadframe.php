<?php 
error_reporting(0);
require("../kernl/Init.php"); 
if (!defined('source'))
	//header("Location: ../login.php"); //重定向浏览器到播放界面
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
      <div class="tab-body">
        <br />
        <div class="tab-panel active" id="tab-set">
        	<form method="post" class="form-x" action="#">
            <div class="form-group">
                	<div class="label"><label>备份文件列表</label></div>
                	<div class="field">
                        <div class="button-group button-group-small radio">
                        <select name="tableSelect" size="10" id="tableSelect" class='select' style="margin-top:6px">
</div>
                </div>
				<div class="form-group" style="margin-top:6px" >
                	<div class="label"><label>数据库操作</label></div>
                	<div class="field">
                       <input name="databasebak" type="submit" class="button" id="databasebak" value="备份数据库" />&nbsp;&nbsp;<input name="databasebak" type="submit" class="button" id="databasebak" value="恢复数据库" />&nbsp;&nbsp;<input name="databasebak" type="submit" class="button" id="databasebak" value="清空数据库" />&nbsp;&nbsp;<input name="databasebak" type="submit" class="button" id="databasebak" value="删除备份" />
                    </div>
                </div>
            
        </div>
      </div>
    </div>
</div>
</form>
