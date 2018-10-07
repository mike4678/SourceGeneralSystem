<?php 
error_reporting(0);
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器到播放界面

//初始化相关参数信息
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
			
	}


//更新变量值
$_G['IPS']['STATUS'] = $dou->Info('ipfirewall_status');
$_G['IPS']['MODE'] = $dou->Info('ipfirewall_mode');
?>
      <div class="tab-body">
        <br />
        <div class="tab-panel " id="tab-ips">
                 <form method="post" class="form-x" action="#">
                 <input type="hidden" value="tab-ips" id="Tab" name="Tab">
				<div class="form-group">
                	<div class="label"><label>IP防火墙状态</label></div>
                	<div class="field">
                        <div class="button-group button-group-small radio">
                        <?php 
	switch ($_G['IPS']['STATUS']) {
	case 1:
		echo  "<label class='button'><input name='status' value='yes' checked='checked' type='radio'><span class='icon icon-check'></span> 启用</label><label class='button active'><input name='status' value='no' type='radio'><span class='icon icon-times'></span> 禁用</label>";
		break;
	case 0:
		echo "<label class='button active'><input name='status' value='yes' checked='checked' type='radio'><span class='icon icon-check'></span> 启用</label><label class='button'><input name='status' value='no' type='radio'><span class='icon icon-times'></span> 禁用</label>";
		break;
		 }
?>
          </div>
                    </div>
                </div>
				<div class="form-group">
                	<div class="label"><label>IP防火墙模式</label></div>
                	<div class="field">
                        <div class="button-group button-group-small radio">
                        <?php 
	switch ($_G['IPS']['MODE']) {
	case 1:
		echo  "<label class='button'><input name='mode' value='yes' checked='checked' type='radio'><span class='icon icon-check'></span> 白名单</label><label class='button active'><input name='mode' value='no' type='radio'><span class='icon icon-check'></span> 黑名单</label><div class='label' id='info' style='width:500px;margin-top:5px;margin-left:5px;'>&nbsp;白名单：仅允许特定IP访问&nbsp;/ 黑名单：不允许特定IP访问</div>";
		break;
	case 0:
		echo "<label class='button active'><input name='mode' value='yes' checked='checked' type='radio'><span class='icon icon-check'></span> 白名单</label><label class='button'><input name='mode' value='no' type='radio'><span class='icon icon-check'></span> 黑名单</label><div id='info' style='width:500px;margin-top:5px;margin-left:5px;'>&nbsp;白名单：仅允许特定IP访问&nbsp;/ 黑名单：不允许特定IP访问</div>";
		break;
		 }
?>
          </div>
                    </div>
                </div>
                            <div class="form-group">
                	<div class="label"><label>IP防火墙黑名单/白名单</label></div>
                	<div class="field">
                        <div class="button-group button-group-small radio">
                        <select name="tableSelect" size="10" id="tableSelect" class='select' style="margin-top:6px">
            <?php
			$arr = array();
if (!file_exists('backup')) {
    mkdir("backup");
    echo "<option value=>第一次使用请先备份数据</option>";
} else {
    $d = dir("backup");
    while (false !== ($e = $d->read())) {
		$arr[] = $e; } 
	 if (count($arr) > 2) {   //判断文件数量是否大于2，如果不大于则认为不存在备份文件
	 unset($arr[0],$arr[1]);
              foreach ($arr as $v=>$a)  {
                echo "<option value=" . $a . ">" . $a . "</option>";
            }   
	    } else {echo "<option value=>无可用备份数据</option>";}
}

?>

            </select></div>
                    </div>
                </div>
                <div class="form-group" style="margin-top:6px" >
                	<div class="label"><label>操作</label></div>
                	<div class="field">
                       <input type="button" class="button checkall" value="添加" onclick="add()" />&nbsp;&nbsp;<input type="button" class="button checkall" value="编辑" onclick="add()" />&nbsp;&nbsp;<input type="button" class="button checkall" value="删除" onclick="add()" />
                    </div>
                </div>
                <div class="form-button"><button class="button bg-main" type="submit">应用</button></div> 
         </form>	
        	
        </div>
        
        </div>
      </div>
    </div>
<script>
function info(message) { art.dialog.tips(message,5); }
	
function add() { art.dialog.open('system/MusicEdit.php?m=add', {title: '新增歌曲',width: 420, height: 635}); }
	
function edit(music_id) { art.dialog.open('system/MusicEdit.php?m=edit&id='+music_id, {title: '修改歌曲信息',width: 420}); }
	
function Del(addr) 
{
	art.dialog.confirm('你确定要删除这首歌曲吗？', function () {
		window.location.href='http://' + window.location.host + addr;
		//art.dialog.content('http://' + window.location.host + addr);// 填充对话框内容
		//art.dialog.open('http://' + window.location.host + addr)
		//myDialog.dialog.close();
    //art.dialog.tips('执行确定操作');
}, function () {
	art.dialog.close();
    art.dialog.tips('操作被用户取消！');
});
}
	
</script>
