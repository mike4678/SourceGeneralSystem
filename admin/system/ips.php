<?php 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器到播放界面

//初始化相关参数信息
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if(!isset($_POST['status']))
	{
		$sql = "UPDATE system_setting 
				SET value = CASE vars 
				WHEN 'ipfirewall_mode' THEN '".$_POST['mode']."'
				END 
				WHERE vars IN ('ipfirewall_mode')";

	} else if(!isset($_POST['mode'])) 
		
	{
		$sql = "UPDATE system_setting 
				SET value = CASE vars 
				WHEN 'ipfirewall_status' THEN '".$_POST['status']."'
				END 
				WHERE vars IN ('ipfirewall_status')";
	} else 
		
	{
		$sql = "UPDATE system_setting 
				SET value = CASE vars 
				WHEN 'ipfirewall_status' THEN '".$_POST['status']."'
				WHEN 'ipfirewall_mode' THEN '".$_POST['mode']."'
				END 
				WHERE vars IN ('ipfirewall_status','ipfirewall_mode')";
	}
	if (!$dou->query($sql)) 
	{
		echo '<script language="JavaScript">SystemBox(3,"更新失败")</script>';
		
	} else {
		
		echo '<script language="JavaScript">SystemBox(3,"参数已更新")</script>';
	}		
}

?>

      <div class="tab-body">
        <div class="tab-panel " id="tab-ips">
         	<form method="post" class="form-x" action="#">
              <input type="hidden" value="tab-ips" id="Tab" name="Tab">
				<div class="form-group">
                	<div class="label"><label>系统状态</label></div>
                	<div class="field">
                     <div class="button-group button-group-small radio">
						<label id='run' class='button'><input name='status' value='0' type='radio'><span class='icon icon-check'></span> 启用</label><label id='stop' class='button'><input name='status' value='1' type='radio'><span class='icon icon-times'></span> 禁用</label>	
					 </div>
                    </div>
                </div>
				<div class="form-group">
                	<div class="label"><label>模式切换</label></div>
                	<div class="field">
                        <div class="button-group button-group-small radio">
							<label id='black' class='button'><input name='mode' value='0' onclick='javascript:Tips(1)' type='radio' ><span class='icon icon-check'></span> 白名单</label><label id='block' class='button'><input name='mode' value='1' onclick='javascript:Tips(2)' type='radio' ><span class='icon icon-check'></span> 黑名单</label><div class='label' id='info' name='info' style='width:250px;margin-top:0px;margin-left:-50px;'></div>
         				 </div>
                    </div>
                </div>
                <div class="form-group">
                	<div class="label"><label>IP防火墙黑名单/白名单</label></div>
                	<div class="field">
                        <div class="button-group button-group-small radio">
                        <select name="tableSelect" size="10" id="tableSelect" class='select' style="margin-top:6px">
           				 <?php
							$UData = $dou -> Get_IpList();
							foreach ($UData as $value)
							{
								if($value['type'] == '2' || $value['type'] == $dou->Info('ipfirewall_mode'))
								{
									echo '<option value='.$value['iptable'].'>'.$value['iptable'].'</option>';
								} 
								
							}
							echo '<script>StatusEdit('.$dou->Info('ipfirewall_status').',\'run\',\'stop\');StatusEdit('.$dou->Info('ipfirewall_mode').',\'black\',\'block\');</script>';
							?>
            			</select></div>
                    </div>
                </div>
                <div class="form-group" style="margin-top:6px" >
                	<div class="label"><label>操作</label></div>
                	<div class="field">
					<input name="databasebak" type="button" class="button" id="databasebak" href='#' onclick="javascript:art.dialog.open('/admin/system/ipsetting.php?m=add', {title: '新增IP地址', width: 420, height: 320})" value="添加" />&nbsp;&nbsp;<input type="button" class="button" href='#' onclick="javascript:art.dialog.open('system/ipsetting.php?m=edit', {title: '修改IP地址信息', width: 420, height: 320})" value="编辑" />&nbsp;&nbsp;<input type="button" class="button" href='#' onclick="javascript:art.dialog.open('/admin/system/ipsetting.php?m=del', {title: '删除IP地址', width: 420, height: 235})" value="删除" />	
                    </div>
                </div>
                <div class="form-button"><button class="button bg-main" type="submit">应用</button></div> 
         	</form>	
        </div>
     </div>
