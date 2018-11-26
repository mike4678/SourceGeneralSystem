<?php 
error_reporting(0);
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器到播放界面

//初始化相关参数信息

if($_SERVER["REQUEST_METHOD"] == "GET")
{ 
	$status = $dou->Info('server_status');
	$IndexStatus = $dou->Info('index_status');
	$dou->CheckUploadSize();  //上传大小检查，如果超过设定，则自动修改为正常值
	if($_COOKIE['set'] == NULL && $_COOKIE['up'] == NULL)
	{
		$dou->cookie("set", 'active');
		$dou->cookie("up", '');
		$dou->cookie("adv", '');
		$dou->cookie("email", '');
	}
	
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	switch($_POST['Tab'])
	{
		case 'tab-system':
			$_POST['path'] = empty($_POST['path']) ? '' : $_POST['path'];	
			
			//密匙更新检查
			$pwdencry = key;   //获取旧的加密密匙
			$pwd_new = $_POST['pwdreq'];
			if ($pwd_new != $pwdencry ) //如果新的密匙不等于旧的，则同时更新登陆密码
			{
				$sql = 'select password from admin_user';
				$old_pwd = $dou->fetch_array($dou -> query($sql));
				$pwd = decrypt($old_pwd[0], $pwdencry); //反计算出原始密码
				$newpwd = PwdEnc($pwd, $pwd_new);  //生成新的密码
				$value = "update admin_user set password = '".$newpwd."' where username = 'admin';";
				if (!$dou->query($value)) 
				{
					echo '<script language="JavaScript">window.alert("密码更新失败！")</script>';
					} 
			}	
			
			//页面条数显示数检查
			if( $_POST['disp'] == 0 || $_POST['disp'] == NULL || is_int($_POST['disp']) == False) 
			{
				$Page_Display = 20;
				
			} else { $Page_Display = $_POST['disp']; }
			
			
			//检查结束
			
			if($_POST['pintuer'] == 'yes') //网站当前状态
			{
				$state = '0';    //开放
				
			} else { $state = '1'; }  //禁用
			
			if($_POST['path'] == Null) 
			{
				$sql = "UPDATE system_setting 
				  		  SET value = CASE vars 
				  		 WHEN 'server_status' THEN '".$state."'  
				  		 WHEN 'server_infomaction' THEN '".$_POST['sys']."' 
						 WHEN 'name' THEN '".$_POST['sitename']."' 
						 WHEN 'bottom' THEN '".$_POST['sysinfo']."' 
						 WHEN 'encrypted' THEN '".$_POST['pwdreq']."'
						 WHEN 'pagedisplay' THEN '".$Page_Display."'
				 		END 
						 WHERE vars IN ('server_status','server_infomaction','name','bottom','encrypted','pagedisplay')";
			} else {
				$sql = "UPDATE system_setting 
				  		  SET value = CASE vars 
				  		 WHEN 'server_status' THEN '".$state."'  
				  		 WHEN 'server_infomaction' THEN '".$_POST['sys']."' 
						 WHEN 'name' THEN '".$_POST['sitename']."' 
						 WHEN 'bottom' THEN '".$_POST['sysinfo']."' 
						 WHEN 'logo' THEN '".$_POST['path']."' 
						 WHEN 'encrypted' THEN '".$_POST['pwdreq']."'
						 WHEN 'pagedisplay' THEN '".$Page_Display."'
				 		END 
						 WHERE vars IN ('server_status','server_infomaction','name','bottom','logo','encrypted','pagedisplay')";
			}
			
			if (!$dou->query($sql)) 
				{
					echo '<script language="JavaScript">window.alert("更新失败")</script>';
					} else {
						echo '<script language="JavaScript">window.alert("参数已更新！")</script>';
						$dou->cookie("set", 'active' , 300);
						$dou->cookie("up", '' , 300);
						$dou->cookie("adv", '' , 300);
						//echo '<script language="JavaScript">window.location.href="admin.php?/system/setting"</script>';
					}
			break;
		
		case 'tab-upload':
			$phpsize = str_replace("M","",$_POST['php_size']);
			if($_POST['file_size'] > $phpsize)   //如果文件大小超过PHP系统限定大小
			{
				echo '<script language="JavaScript">window.alert("当前允许上传文件大小超过PHP系统限定值！")</script>';
				echo '<script language="JavaScript">window.history.back();</script>';
			} else {
				$sql = "UPDATE system_setting SET value = CASE vars WHEN 'upload_size' THEN '".$_POST['file_size']."'  WHEN 'upload_name' THEN '".$_POST['file_name']."' END WHERE vars IN ('upload_size','upload_name')";
				if (!$dou->query($sql)) 
				{
					echo '<script language="JavaScript">window.alert("更新失败")</script>';
					} else {
						echo '<script language="JavaScript">window.alert("参数已更新！")</script>';
						$dou->cookie("set", '', 300);
						$dou->cookie("up", 'active' , 300);
						$dou->cookie("adv", '' , 300);
						//echo '<script language="JavaScript">window.location.href="admin.php?/system/setting"</script>';
					}
				}
			break;
			
		case 'tab-adv':  //高级设置
			if($_POST['activeIndex'] == 'yes') //网站当前状态
			{
				$state = '0';    //开放
				if($_POST['tableSelect'] == NULL) 
				{
					$sql = "UPDATE system_setting 
				  		  SET value = CASE vars 
				  		 WHEN 'index_status' THEN '".$state."' 
				 		END 
						 WHERE vars IN ('index_status')";
				} else 
					{
						$sql = "UPDATE system_setting 
				  		  		SET value = CASE vars 
				  		 		WHEN 'index_status' THEN '".$state."' 
								WHEN 'index_page' THEN '".$_POST['tableSelect']."' 
				 				END 
						 		WHERE vars IN ('index_status','index_page')";					
					}

			} else { 
				
				$state = '1';
				$sql = "UPDATE system_setting 
				  		  SET value = CASE vars 
				  		 WHEN 'index_status' THEN '".$state."'  
				 		END 
						 WHERE vars IN ('index_status')";
				   
				}  //禁用
			
				if (!$dou->query($sql)) 
				{
					echo '<script language="JavaScript">window.alert("更新失败")</script>';
					} else {
						echo '<script language="JavaScript">window.alert("参数已更新！")</script>';
						$dou->cookie("set", '', 300);
						$dou->cookie("up", '' , 300);
						$dou->cookie("adv", 'active' , 300);
						//echo '<script language="JavaScript">window.location.href="admin.php?/system/setting"</script>';
					}
			break;
			
		case 'tab-user':
			$old_pwd = PwdEnc(empty($_POST['old_pwd']) ? '' : $_POST['old_pwd'],$dou->Info('encrypted')); //旧密码
			$new_pwd = empty($_POST['new_pwd']) ? '' : $_POST['new_pwd'];
			$conf_new_pwd = empty($_POST['conf_new_pwd']) ? '' : $_POST['conf_new_pwd'];
			if(empty($_POST['old_pwd']) && empty($_POST['new_pwd']) && empty($_POST['conf_new_pwd']))
			{
				echo '<script language="JavaScript">window.alert("密码不允许为空！")</script>';
				echo '<script language="JavaScript">window.location.href="admin.php?/system/setting"</script>';
			} else {
				$sql = "select username from admin_user where password = '".$old_pwd."';";
				$dou -> query($sql);
				if(!$dou -> affected_rows())  //如果未返回结果则认为密码错误。
				{
					echo '<script language="JavaScript">window.alert("旧密码输入错误，请重新输入！")</script>';
					echo '<script language="JavaScript">window.history.go(-1);</script>';
					exit;
				} 
				if($new_pwd != $conf_new_pwd) 
				{
					echo '<script language="JavaScript">window.alert("两次输入的密码不一致，请重新输入！")</script>';
					echo '<script language="JavaScript">window.history.go(-1);</script>';
					exit;
				}
				$encryption_pwd = PwdEnc($_POST['new_pwd'],$dou->Info('encrypted'));
				$sql = "UPDATE admin_user SET password = '".$encryption_pwd."' where username = 'admin';";
				if (!$dou->query($sql)) 
				{
					echo '<script language="JavaScript">window.alert("修改密码失败")</script>';
					echo '<script language="JavaScript">window.history.go(-1);</script>';
					} else {
						echo '<script language="JavaScript">window.alert("密码已更新，请重新登陆")</script>';
						echo '<script language="JavaScript">window.location.href="admin.php?/exit"</script>';
					}
			}

			break;
			
		default:
			$dou->cookie("set", 'active');
			$dou->cookie("up", '');
			$dou->cookie("adv", '');
			break;
			
			
	}
}

//生成顶部选项夹
$data = array
(
"TabName"=>array("TabName"=>"系统设置"), //第一个为标题
		   array("Name"=>"基础设置","tab"=>'#tab-set',"active"=>$_COOKIE['set']), //往后的为选项夹
		   array("Name"=>"高级设置","tab"=>'#tab-adv',"active"=>$_COOKIE['adv']), //往后的为选项夹
		   array("Name"=>"用户设置","tab"=>'#tab-email',"active"=>''),
		   array("Name"=>"上传设置","tab"=>'#tab-upload',"active"=>$_COOKIE['up'])	
);

$dou->FormCreate($data);
?>
<style>
.delimg{margin-left:20px; color:#090; cursor:pointer}
</style>
<script type="text/javascript" src="../../js/jquery.form.js"></script>
<script language=javascript>   //文件上传处理
$(function () {
	var bar = $('.bar');
	var percent = $('.percent');
	var showimg = $('#showimg');
	var progress = $(".progress");
	var files = $(".files");
	var btn = $(".btn span");
	$("#fileupload").wrap("<form id='myupload' action='system/upload.php?act=add&ifr=system' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload").change(function(){
		$("#myupload").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
        		showimg.empty();
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
				var img = "../images/"+data.pic;
				showimg.html("<input type='hidden' name='path' value='"+img+"'><img src='"+img+"'><span class='delimg' rel='"+data.pic+"'>删除</span>");
				$("#fileupload").hide();
				progress.hide();
			},
			error:function(xhr){
				btn.html("上传失败");
				bar.width('0')
				files.html(xhr.responseText);
			}
		});
		
	});
	
	$(".delimg").live('click',function(){
		var pic = $(this).attr("rel");
		$.post("system/upload.php?act=del&ifr=system",{imagename:pic},function(msg){
			if(msg==1){
				files.html("删除成功.&nbsp;&nbsp;<a href='javascript:history.go(0)'>刷新</a>");
				showimg.empty();
				progress.hide();
			}else{
				alert(msg);
			}
		});
	});
	
}); 
		function XZSelect() {
        if (document.getElementById('Select').options[2].selected == true) {
			document.getElementById('w').style.display = '';
			
        } else if (document.getElementById('Select').options[2].selected == false) {
            document.getElementById('w').style.display = 'none';

        } 
    }
	
	
</script>
      <div class="tab-body">
        <br />
        <div class="tab-panel <?php echo $_COOKIE['set']; ?>" id="tab-set">
        	<form method="post" class="form-x" action="#">
        		<input type="hidden" value="tab-system" id="Tab" name="Tab">
				<div class="form-group">
                	<div class="label"><label>网站状态</label></div>
                	<div class="field">
                        <div class="button-group button-group-small radio">
                        <?php 
	switch ($status) {
	case 1:
		echo  "<label class='button'><input name='pintuer' value='yes' checked='checked' type='radio'><span class='icon icon-check'></span> 正常模式</label><label class='button active'><input name='pintuer' value='no' type='radio'><span class='icon icon-times'></span> 维护模式</label>";
		break;
	case 0:
		echo "<label class='button active'><input name='pintuer' value='yes' checked='checked' type='radio'><span class='icon icon-check'></span> 正常模式</label><label class='button'><input name='pintuer' value='no' type='radio'><span class='icon icon-times'></span> 维护模式</label>";
		break;
		 }
?>
          </div>
                    </div>
                </div>
                <div class="form-group">
                   
                    <div class="label"><label for="readme">维护说明</label></div>
                    <div class="field">
                    	<textarea name="sys" cols="50" rows="5" class="input" id="sys" ><?php echo $dou->Info('server_infomaction'); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label for="sitename">网站名称</label></div>
                    <div class="field">
                    	<input type="text" class="input" id="sitename" name="sitename" size="50" placeholder="请填写你网站的名称" data-validate="required:请填写你网站的名称" value=<?php echo $dou->Info('name'); ?> />
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label for="siteurl">网址</label></div>
                    <div class="field">
                    	<input type="text" class="input" id="siteurl" name="siteurl" size="50" placeholder="请填写网址" data-validate="required:请填写网址" value=<?php echo $_SERVER['HTTP_HOST']; ?>/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label for="readme">底部内容</label></div>
                    <div class="field">
                    	<textarea name="sysinfo" cols="50" rows="5" class="input" id="sysinfo" ><?php echo $dou->Info('bottom'); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label for="logo">首页Logo</label></div>
                    <div class="field">
            <input id="fileupload" type="file" name="mypic">
        <div class="progress" style="display:none">
    		<span class="bar"></span><span class="percent">0%</span >
		</div>
        <div id="showimg"></div>
                    <div class="files"></div>

                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label for="siteurl">密码加密密匙</label></div>
                    <div class="field">
                    	<input type="text" class="input" id="pwdreq" name="pwdreq" size="50" placeholder="请填写密码加密密匙" data-validate="required:请填写密码加密密匙" value=<?php echo key; ?> >
                    </div>
                </div> 
				<div class="form-group">
                    <div class="label"><label for="siteurl">每页显示内容数</label></div>
                    <div class="field">
                    	<input type="text" class="input" id="disp" name="disp" size="50" placeholder="请填写每页可显示内容数" data-validate="required:请填写每页可显示内容数" value=<?php echo $dou->Info('pagedisplay'); ?> >
                    </div>
                </div>
                <div class="form-button"><button class="button bg-main" type="submit">提交</button></div>
            </form>
        </div>
        <div class="tab-panel " id="tab-email">
                 <form method="post" class="form-x" action="#">
                 <input type="hidden" value="tab-user" id="Tab" name="Tab">
          <div class="form-group">
           <div class="label"><label for="sitename">旧密码</label></div>
           <div class="field">
            <input type="password" class="input" id="old_pwd" name="old_pwd" size="50" placeholder="填写账户旧密码" data-validate="required:请填写账户旧密码"/>
           </div>
          </div>
          <div class="form-group">
           <div class="label"><label for="sitename">新密码</label></div>
           <div class="field">
            <input type="password" class="input" id="new_pwd" name="new_pwd" size="50" placeholder="填写账户新密码" data-validate="required:请填写账户新密码"/>
           </div>
          </div>
           <div class="form-group">
           <div class="label"><label for="sitename">确认新密码</label></div>
           <div class="field">
             <input type="password" class="input" id="conf_new_pwd" name="conf_new_pwd" size="50" placeholder="填写账户新密码" data-validate="required:请填写账户新密码" /> 
           </div>
          </div>
           <div class="form-button"><button class="button bg-main" type="submit">更新密码</button></div>
         </form>	
        	
        </div>
		<div class="tab-panel <?php echo $_COOKIE['adv']; ?>" id="tab-adv">
                 <form method="post" class="form-x" action="#">
                 <input type="hidden" value="tab-adv" id="Tab" name="Tab">
				<div class="form-group">
                	<div class="label"><label>首页功能</label></div>
                	<div class="field">
                        <div class="button-group button-group-small radio">
                        <?php 
	switch ($IndexStatus) {
	case 1:
		echo  "<label class='button'><input name='activeIndex' value='yes' checked='checked' type='radio'><span class='icon icon-check'></span> 启用</label><label class='button active'><input name='activeIndex' value='no' type='radio'><span class='icon icon-times'></span> 禁用</label>";
		break;
	case 0:
		echo "<label class='button active'><input name='activeIndex' value='yes' checked='checked' type='radio'><span class='icon icon-check'></span> 启用</label><label class='button'><input name='activeIndex' value='no' type='radio'><span class='icon icon-times'></span> 禁用</label>";
		break;
		 }
?>
          </div>
                    </div>
          </div>
          <div class="form-group">
           <div class="label"><label for="sitename">已安装首页风格</label></div>
                	<div class="field">
                        <div class="button-group button-group-small radio"> 
            <?php
			if($dou -> Info("index_status") == 1)				
			{
				
				echo '<select name="tableSelect" size="10" id="tableSelect" class="select" style="margin-top:6px" disable readonly><option value=>功能未启用</option>';
				
			} else {
				
				echo '<select name="tableSelect" size="10" id="tableSelect" class="select" style="margin-top:6px">';
					if($dou -> Info("index_page_all") == NULL)							 
					{
						echo '<option value=>未安装任何包含首页风格的模块或功能</option>';
					}	else {
						$pieces = explode("|", $dou ->Info("index_page_all"));
						foreach($pieces as $val){
							$IndexData = explode(";", $val);
  							echo '<option value='.$IndexData[2].'>'.$IndexData[1].'('.$IndexData[2].')</option>';
						}
					}
				
				}
			?>
            </select></div>
                    </div>
          </div>
           <div class="form-group">
           <div class="label"><label for="sitename">当前风格</label></div>
           <div class="field">
             <input type="text" class="input" id="IndexStyle" name="IndexStyle" size="50"  value="<?php echo $dou ->Info("index_page"); ?>" disable readonly> 
           </div>
          </div>
           <div class="form-button"><button class="button bg-main" type="submit">应用</button></div>
         </form>	
        	
        </div>  
        <div class="tab-panel <?php echo $_COOKIE['up']; ?>" id="tab-upload">
         <form method="post" class="form-x" action="#">
         <input type="hidden" value="tab-upload" id="Tab" name="Tab">				
          <div class="form-group">
           <div class="label"><label for="sitename">允许单个文件大小(MB)</label></div>
           <div class="field">
            <input type="text" class="input" id="file_size" name="file_size" size="20" placeholder="填写允许上传的文件大小,单位MB" data-validate="required:请填写允许上传的文件大小,单位MB" value=<?php echo $dou->Info('upload_size'); ?> />
           </div>
          </div>
           <div class="form-group">
           <div class="label"><label for="sitename">允许文件最大大小<br>(upload_max_filesize)</label></div>
           <div class="field">
             <input type="text" class="input" id="php_size" name="php_size" size="50"  value=<?php echo ini_get('upload_max_filesize'); ?> disable readonly> 
             <a href="http://bbs.csource.com.cn/read-273-1.html" target="_blank">(如何修改该值？)</a>
           </div>
          </div>
          <div class="form-group">
           <div class="label"><label for="sitename">允许上传最大大小<br>(post_max_size)</label></div>
           <div class="field">
             <input type="text" class="input" id="php_size" name="php_size" size="50"  value=<?php echo ini_get('post_max_size'); ?> disable readonly> 
             <a href="http://bbs.csource.com.cn/read-273-1.html" target="_blank">(如何修改该值？)</a>
           </div>
          </div>
		  <div class="form-group">
           <div class="label"><label for="sitename">上传参数</label></div>
             <div class="field">
				 <?php
					echo '<select name="tableSelect" size="10" id="tableSelect" class="select" style="margin-top:6px">';
				 	$UData = $dou -> UploadFrame();
				 	foreach ($UData as $value)
					{
						echo '<option value='.$value[0].'>'.$value[0].'('.str_replace("*","、",$value[1]).')</option>';
					}
				?>
				</select><br />
				<input name="databasebak" type="button" class="button" id="databasebak" href='#' onclick="javascript:art.dialog.open('/admin/system/uploadframe.php?m=add', {title: '新增上传框架', width: 420, height: 400})" value="添加" />&nbsp;&nbsp;<input type="button" class="button" href='#' onclick="javascript:art.dialog.open('system/uploadframe.php?m=edit', {title: '修改上传框架', width: 420, height: 402})" value="编辑" />&nbsp;&nbsp;<input type="button" class="button" href='#' onclick="javascript:art.dialog.open('/admin/system/uploadframe.php?m=del', {title: '删除上传框架', width: 420, height: 235})" value="删除" />	
				</div>
                </div>
		  <div class="form-button"><button class="button bg-main" type="submit">提交</button></div>	  
         </form>
        </div>
        </div>
      </div>
    </div>