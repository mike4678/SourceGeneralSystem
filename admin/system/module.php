<script type="text/javascript" src="../../js/jquery.form.js"></script>
<script language=javascript>   //文件上传处理
$(function () {
	var bar = $('.bar');
	var percent = $('.percent');
	var progress = $(".progress");
	var files = $(".files");
	var btn = $(".btn span");
	$("#fileupload").wrap("<form id='myupload' action='system/upload.php?frame=module' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload").change(function(){
		$("#myupload").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
				progress.show();
        		var percentVal = '0%';
        		bar.width(percentVal);
        		percent.html(percentVal);
				btn.html("上传中...");
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
        		var percentVal = percentComplete + '%';
        		bar.width(percentVal);
        		percent.html(percentVal);
    		},
			success:function(data) {
				//$("#fileupload").hide();
				//progress.hide();
				files.html(data.status);
			},
			error:function(xhr){
				btn.html("上传失败");
				bar.width('0')
				files.html("上传失败！错误：" + xhr.responseText);
			}
		});
		
	});
		
}); 
</script>
<style>
.btn{position: relative;overflow: hidden;margin-right: 4px;display:inline-block;*display:inline;padding:4px 10px 4px;font-size:14px;line-height:18px;*line-height:20px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;background:#5bb75b;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
.btn input{position: absolute;top: 0; right: 0;margin: 0;border:solid transparent;opacity: 0;filter:alpha(opacity=0); cursor: pointer;}
.progress{position:relative; margin-left:0px;margin-top:2px;width:280px;padding: 1px; border-radius:3px;}
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
   array("Name"=>"模块管理","tab"=>'#tab-post',"active"=>'')	
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
        	<div class="progress">
    		<span class="bar"></span><span class="percent">0%</span >
			</div>
        </div>
    	</div>
		<div class="form-group">
         <div class="label"><label>当前状态</label></div>
          <div class="field">
          <textarea name="sys" cols="50" rows="5" class="files" id="files" style="width:400px; height:350px"></textarea>
           </div>
        </div>	
        </div>
        <div class="tab-panel" id="tab-post">
<div class="label" style="border-bottom: solid 1px #458fce;">
	<label class="label">当前模块</label></div>

<?php		
	$tpath = $_G['SYSTEM']['PATH'] . 'module/';	
	$scan = scandir($tpath);
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
				if (file_exists($tpath . $name . '/install.json')) 
				{
					$ahtml = "
					<a class='pk-text-success pk-hover-underline' href='javascript:' onclick='location.href=\"admin.php?/system/module/{$name}&ml=install\"'>安装</a>
					";
				} else if(file_exists($tpath . $name . '/unstall.json')) { 
					$ahtml = "
					<a class='pk-text-success pk-hover-underline' href='javascript:' onclick='pkalert(\"安装该模板后后台将被自动刷新，请保存当前设置，确认继续？\",\"提示\",\"pktip(\\\"正在安装请稍后...\\\",\\\"loading\\\",0);location.href=\\\"admin.php?/system/module/{$name}&ml=install\\\"\")'>卸载</a>
					";
					
					} else {
					$ahtml = "
					<a class='pk-text-success pk-hover-underline'>⊗核心模块，不允许操作</a>
					";
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
		  </div>      </div>
        </form>
    </div>