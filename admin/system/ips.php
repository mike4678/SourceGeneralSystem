<?php 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器到播放界面

//初始化相关参数信息
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if($_POST['status'] == NULL)
	{
		$sql = "UPDATE system_setting 
				SET value = CASE vars 
				WHEN 'ipfirewall_mode' THEN '".$_POST['mode']."'
				END 
				WHERE vars IN ('ipfirewall_mode')";
		
		
	} else if($_POST['mode'] == NULL) 
		
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
		echo '<script language="JavaScript">window.alert("更新失败")</script>';
		
	} else {
		
		echo '<script language="JavaScript">window.alert("参数已更新！")</script>';
		
		}		
}


//更新变量值
echo '<script> var stat = '.$dou->Info('ipfirewall_status').'; var mode = '.$dou->Info('ipfirewall_mode').';</script>';
?>
<script>
function MoniterStatus()
{
   if('stat' == 0)
   {
	   document.getElementById("run").className = "button active";
	   
   } else 
   
   {
	   document.getElementById("stop").className = "button active";
   }
	
	if('mode' == 0)
   {
	   document.getElementById("black").className = "button active";
	   
   } else 
   
   {
	   document.getElementById("block").className = "button active";
   }
	
}	
function Tips(data) //名单提示信息
{
	if(data == 1)
	{
		document.getElementsByName("info")[0].innerHTML='&nbsp;&nbsp;&nbsp;白名单：仅允许特定IP访问&nbsp;';
		
	} else 
	{ 
		document.getElementsByName("info")[0].innerHTML='&nbsp;&nbsp;&nbsp;黑名单：不允许特定IP访问&nbsp;';
	}
}
</script>
      <div class="tab-body">
        <br />
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
							echo '<script>javascript:MoniterStatus();</script>';
							$UData = $dou -> Get_IpList();
							foreach ($UData as $value)
							{
								if($value['type'] == '2' || $value['type'] == $_G['IPS']['MODE'])
								{
									echo '<option value='.$value['iptable'].'>'.$value['iptable'].'</option>';
								} 
								
							}
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
      </div>
    </div>
