<script>
$().ready(function(){
 if($.browser.safari || $.browser.mozilla){
  $('#dtb-msg1 .compatible').show();
  $('#dtb-msg1 .notcompatible').hide();
  $('#drop_zone_home').hover(function(){
   $(this).children('p').stop().animate({top:'0px'},200);
  },function(){
   $(this).children('p').stop().animate({top:'0px'},200);
  });
  //功能实现
  $(document).on({
   dragleave:function(e){
    e.preventDefault();
    $('.dashboard_target_box').removeClass('over');
   },
   drop:function(e){
    e.preventDefault();
    //$('.dashboard_target_box').removeClass('over');
   },
   dragenter:function(e){
    e.preventDefault();
    $('.dashboard_target_box').addClass('over');
   },
   dragover:function(e){
    e.preventDefault();
    $('.dashboard_target_box').addClass('over');
   }
  });
  var box = document.getElementById('target_box');
  box.addEventListener("drop",function(e){
   e.preventDefault();
   //获取文件列表
   //console.log(e.dataTransfer.files);
   var fileList = e.dataTransfer.files;
   var img = document.createElement('img');
   //检测是否是拖拽文件到页面的操作
   if(fileList.length == 0){
    $('.dashboard_target_box').removeClass('over');
    return;
   }
   
   if($.browser.safari){
    //Chrome8+
    img.src = window.webkitURL.createObjectURL(fileList[0]);
   }else if($.browser.mozilla){
    //FF4+
    img.src = window.URL.createObjectURL(fileList[0]);
   }else{
    //实例化file reader对象
    var reader = new FileReader();
    reader.onload = function(e){
     img.src = this.result;
     $(document.body).appendChild(img);
    }
    reader.readAsDataURL(fileList[0]);
   }
   var xhr = new XMLHttpRequest();
   xhr.open("post", "system/Upload.php", true);
   xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
   xhr.upload.addEventListener("progress", function(e){
    $("#dtb-msg3").hide();
	$('#dtb-msg1 .compatible').hide();
    $('#dtb-msg1 .notcompatible').show();
    $("#dtb-msg4 span").show();
    $("#dtb-msg4").children('span').eq(1).css({width:'0px'});
    $('.show').html('');
    if(e.lengthComputable){
     var loaded = Math.ceil((e.loaded / e.total) * 100);
     $("#dtb-msg4").children('span').eq(1).css({width:(loaded*2)+'px'});
    }
   }, false);
   xhr.addEventListener("load", function(e){
    $('.dashboard_target_box').removeClass('over');
    $("#dtb-msg3").show();
    $("#dtb-msg4 span").hide();
	  $('#dtb-msg1 .compatible').show();
  $('#dtb-msg1 .notcompatible').hide();
    var result = jQuery.parseJSON(e.target.responseText);
    alert(result.info);
    $('.show').append(result.img);
   }, false);
   
   var fd = new FormData();
   fd.append('xfile', fileList[0]);
   xhr.send(fd);
  },false);
 }else{
  $('#dtb-msg1 .compatible').hide();
  $('#dtb-msg1 .notcompatible').show();
 }
});

//点击按钮弹出文件选择窗口
$(document).ready(function (){
$("#uploadVideo").click(function (){ 
var fileInput = document.getElementById("fileInput");//隐藏的file文本ID 
fileInput.click();//加一个触发事件
}); 
}); 


//选择完文件上传
function FileUpload_onselect()
        {
   var fileObj = document.getElementById("fileInput").files[0]; // js 获取文件对象
   console.log(fileObj);
   var xhr = new XMLHttpRequest();
   xhr.open("post", "Upload.php", true);
   xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
   xhr.upload.addEventListener("progress", function(e){
    $("#dtb-msg3").hide();
	$('#dtb-msg1 .compatible').hide();
    $('#dtb-msg1 .notcompatible').show();
    $("#dtb-msg4 span").show();
    $("#dtb-msg4").children('span').eq(1).css({width:'0px'});
    $('.show').html('');
    if(e.lengthComputable){
     var loaded = Math.ceil((e.loaded / e.total) * 100);
     $("#dtb-msg4").children('span').eq(1).css({width:(loaded*2)+'px'});
    }
   }, false);
   xhr.addEventListener("load", function(e){
    $('.fileInput').removeClass('over');
    $("#dtb-msg3").show();
    $("#dtb-msg4 span").hide();
	  $('#dtb-msg1 .compatible').show();
  $('#dtb-msg1 .notcompatible').hide();
    var result = jQuery.parseJSON(e.target.responseText);
    //alert(result.info);
	alert(result.path);
    $('.show').append(result.img);
   }, false);
   
   var fd = new FormData();
   fd.append('xfile', fileObj);
   xhr.send(fd);
  }
</script>
<style>
.dashboard_target_box{
	border: 3px dashed #E5E5E5;
	text-align: center;
	position: absolute;
	z-index: 2000;
	cursor: pointer;
	width: 400px;
	left: 50%;
	margin-left: -200px;  /*此处的负值是宽度的一半*/
}
.dashboard_target_box.over{border:3px dashed #000;background:#ffa}
.dashboard_target_messages_container{display:inline-block;margin:12px 0 0;position:relative;text-align:center;height:44px;overflow:hidden;z-index:2000}
.dashboard_target_box_message{
	position:relative;
	margin:5px auto;
	font:15px/18px helvetica,arial,sans-serif;
	font-size:15px;
	color:#999;
	font-weight:normal;
	width:150px;
	line-height:40px
}
.dashboard_target_box.over #dtb-msg1{color:#000;font-weight:bold}
.dashboard_target_box.over #dtb-msg3{color:#ffa;border-color:#ffa}
#dtb-msg2{color:orange}
#dtb-msg3{display:block;border-top:1px #EEE dotted;padding:8px 24px}
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
        <br />
<form id="contact" action="#" method="post" >
        <div class="tab-panel active" id="tab-get">
        <p style='font-size:28px;text-align:center;'>模块在线安装</p><br />
         <div id="target_box" class="dashboard_target_box">
 <div id="drop_zone_home" class="dashboard_target_messages_container">
  <p id="dtb-msg1" class="dashboard_target_box_message">
   <span class="compatible">拖动文件到这里</span><span class="notcompatible" style="display:none">正在处理</span>
  </p>
 </div>
 <p id="dtb-msg4" class="dashboard_target_box_message" style="position:relative">
  <span style="display:none;width:200px;height:5px;background:#ccc;left:-25px;position:absolute;z-index:1"></span>
  <span style="display:none;width:0px;height:5px;background:#09F;left:-25px;position:absolute;z-index:2"></span>
 </p>
 	<p id=dtb-msg3 style='text-align:center'><a id='uploadVideo' class='button button-big' href='#'>上传模块</a><br /><br /></p>
    <input type="file" style="display: none" id="fileInput" onchange="FileUpload_onselect()"/>
</div>

  </p>
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