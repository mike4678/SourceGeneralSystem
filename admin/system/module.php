<?php

$addr = $dou -> AddrConvery($_GET);	 //初始化参数
$FileRootPath = str_replace('\\','/',realpath(dirname(__FILE__).'/../'));
$tpath = $_G['SYSTEM']['PATH'] . 'module/';	
$scan = scandir($tpath);
if($addr[3] != NULL && is_dir($tpath . $addr[4]) == true)
{	
	switch($addr[3])
	{
		case 'reinstall':
			if (!file_exists($tpath . $addr[4] . '/Init.Lock') || file_exists($tpath . $addr[4] . '/install.xml')) 
			{
				echo '<script language="JavaScript">SystemBox(3,"检测到安装锁存在或重新安装所需文件缺失，当前操作已被取消！<br> 如您确实需要重新安装，请参考我们官方论坛教程");</script>';
				break;
			}
			$dou -> ModuleInstall('module/' . $addr[4]); 
		break;
		
		case 'pack':
			// 此段Bug
			function addFileToZip($path, $zip) 
			{
				$dir = str_replace('\\','/',realpath(dirname(__FILE__).'/../')) . "/module/" . $path;

				$handler = opendir($dir); //打开当前文件夹由$path指定。
				while (($filename = readdir($handler))) 
				{
					print_r($filename);
					if ($filename != "." && $filename != "..") //文件夹文件名字为'.'和‘..’，不要对他们进行操作
					{
						if (is_dir($dir . "/" . $filename)) // 如果读取的某个对象是文件夹，则递归
						{
							addFileToZip($dir . "/" . $filename, $zip);
							
						} else { //将文件加入zip对象

							$zip->addFile($dir . "/" . $filename);

							
							//print_r( $dir);
							//if($dir.$filename != $dir.$filename) 
							//{
								//$zip->renameName($dir . "/" . $filename , str_replace($dir . "/" . $filename,"",$dir . "/" . $filename)."/".$filename);
							//}
							//$zip->renameName($dir . "/" . $filename , $path."/".$filename);
						}
					}
				}
				@closedir($dir);
			}
 
			$zip = new ZipArchive();
			if ($zip->open("../module/".$addr[4] . '.zip', ZipArchive::OVERWRITE) === TRUE) 
			{
				
				addFileToZip($addr[4], $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
				$zip->close(); //关闭处理的zip文件
			}
			echo '<script language="JavaScript">SystemBox(3,"打包操作执行成功，如需下载请到module目录下进行手动下载");</script>';
			break;
			// 此段Bug
		case 'uninstall':
		
	}
} 

?>
<script type="text/javascript" src="../../js/jquery.form.js"></script>
<script language=javascript>   //文件上传处理
$(function () {
	var bar = $('.bar');
	var percent = $('.percent');
	var progress = $(".progress");
	var files = $(".files");
	var btn = $(".btn span");
	$181("#fileupload").wrap("<form id='myupload' action='system/upload.php?act=add&ifr=module' method='post' enctype='multipart/form-data'></form>");
    $181("#fileupload").change(function(){
		$181("#myupload").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
				progress.show();
        		var percentVal = '0%';
        		bar.width(percentVal);
        		percent.html(percentVal);
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
        		var percentVal = percentComplete + '%';
        		bar.width(percentVal);
        		percent.html(percentVal);
				console.log("上传中..." + percentVal);
    		},
			success:function(data) {
				if(data.status == '0' || data.status == null)
				{
					console.info(data.message);
					SystemBox(3,"模块安装成功！");
					
				} else {
					
					console.info("上传失败！错误：" + data.message);
					
				}
			}
		});
		
	});
		
}); 
</script>
<style>
.btn{position: relative;overflow: hidden;margin-right: 4px;display:inline-block;*display:inline;padding:4px 10px 4px;font-size:14px;line-height:18px;*line-height:20px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;background:#5bb75b;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
.btn input{position: absolute;top: 0; right: 0;margin: 0;border:solid transparent;opacity: 0;filter:alpha(opacity=0); cursor: pointer;}
.progress{position:relative; margin-left:0px;margin-top:10px;width:280px;padding: 1px; border-radius:20px;}
.bar {background-color: green; display:block; width:0%; height:20px; border-radius:3px; }
.percent{position:absolute; height:20px; display:inline-block; top:0px; left:45%; color:#000 }
.files{height:22px; line-height:22px; margin:10px 0}
input[type="file"]{
	margin-top:5px;
	border-style: solid;
	border-width: 1px;
	}
</style>	
  <?php 
  $data = array
  (
  "TabName"=>array("TabName"=>"模块管理"), //第一个为标题
   array("Name"=>"模块安装","tab"=>'#tab-get',"active"=>'active'), //往后的为选项夹
   array("Name"=>"模块管理","tab"=>'#tab-post',"active"=>''),
   array("Name"=>"模块中心","tab"=>'http://service.csource.com.cn/module',"active"=>'')	
  );
  $dou->FormCreate($data);
  
  ?>
      <div class="tab-body">
		<form id="ModuleUpload" action="#" method="post" class="form-x">
        <div class="tab-panel active" id="tab-get">
		<div class="form-group">
        <div class="label"><label>模块上传</label></div>
        <div class="field">
		<input id="fileupload" type="file" name="mypic">

        </div>
    	</div>
		<div class="form-group">
         <div class="label"><label>状态</label></div>
          <div class="field">
			<div class="progress">
    		<span class="bar"></span><span class="percent">0%</span >
			</div>
           </div>
        </div>	
        </div>
		</form>
        <div class="tab-panel" id="tab-post">
<div class="label" style="border-bottom: solid 1px #458fce;">
	<label class="label">当前模块</label></div>
			<form method="post" class="form-x" action="#">

<?php		
	foreach ($scan as $name) 
	{	
		if ($name && $name != '.' && $name != '..' && filetype($tpath . $name) == 'dir') 
		{
			if (file_exists($tpath . $name . '/config.xml')) 
			{
				$xml = simplexml_load_string(file_get_contents($tpath . $name . '/config.xml'));
				$tname = $xml -> name;
				$author = $xml -> author;
				$version = $xml -> version;
				$link = $xml -> link;
				$description = $xml -> description;
				if (file_exists($tpath . $name . '/install.xml')) 
				{
					$ahtml = "<a class='pk-text-success pk-hover-underline' href='javascript:' onclick=''>安装</a>";
				} else if(file_exists($tpath . $name . '/uninstall.xml')) 
				
				{ 
					$ahtml = "<a class='pk-text-success pk-hover-underline' href='".HttpsCheck().$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']."/reinstall/".$name."'>重新安装</a>&nbsp;&nbsp;&nbsp;<a class='pk-text-success pk-hover-underline' href='".HttpsCheck().$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']."/pack/".$name."'>打包</a>&nbsp;&nbsp;&nbsp;<a class='pk-text-success pk-hover-underline' href='".HttpsCheck().$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']."/uninstall/".$name."'>卸载</a>";
					
				} else {
					
					$ahtml = "<a class='pk-text-danger pk-hover-underline'>⊗核心模块，不允许操作</a>";
				}
				$var .= "<div class='pk-row pk-padding-top-15 pk-padding-bottom-15' style='border-bottom:solid 1px #eee'>
							<label class='pk-w-sm-3 pk-text-right' style='padding-top:2px'><img src='../module/{$name}/logo.png' onerror=\"this.src='../module/{$name}/img/template.png'\" style='width:48px;height:48px'></label>
							<div class='pk-w-sm-8 pk-text-default pk-text-sm'>
						 	<div class='pk-text-truncate pk-text-bold'>{$tname} （目录：{$name}，版本：{$version}，作者：<a target='_blank' class='pk-hover-underline' href='{$link}'>{$author}</a>）</div>
						 	<div class='pk-text-xs pk-text-truncate'>{$description}</div>
						 	<div class='pk-text-xs pk-text-truncate'>{$ahtml}</div>
						 </div></div>";
			} else { 
				if($var == NULL) 
				{
					$var = "<div class='pk-row pk-padding-top-15 pk-padding-bottom-15' style='border-bottom:solid 1px #eee'>
					<label class='pk-w-sm-3 pk-text-right' style='padding-top:2px'>未安装任何模块</label>
					</div>";
				}
			}
		}
	}
	echo $var;		
			
?>
		  </div>
		  </form>
	</div>
    </div>