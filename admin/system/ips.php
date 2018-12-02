<?php 
error_reporting(0);
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器到播放界面

//初始化相关参数信息
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	
			
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
		echo  "<label class='button'><input name='status' value='run' checked='checked' type='radio'><span class='icon icon-check'></span> 启用</label><label class='button active'><input name='status' value='stop' type='radio'><span class='icon icon-times'></span> 禁用</label>";
		break;
	case 0:
		echo "<label class='button active'><input name='status' value='run' checked='checked' type='radio'><span class='icon icon-check'></span> 启用</label><label class='button'><input name='status' value='stop' type='radio'><span class='icon icon-times'></span> 禁用</label>";
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
		echo  "<label class='button'><input name='mode' value='black' checked='checked' onclick='javascript:Tips(1)' type='radio' ><span class='icon icon-check'></span> 白名单</label><label class='button active'><input name='mode' value='block' onclick='javascript:Tips(2)' type='radio' ><span class='icon icon-check'></span> 黑名单</label><div class='label' id='info'  name='info' style='width:500px;margin-top:5px;margin-left:10px;'></div>";
		break;
	case 0:
		echo "<label class='button active'><input name='mode' value='black' checked='checked' onclick='javascript:Tips(1)' type='radio'><span class='icon icon-check'></span> 白名单</label><label class='button'><input name='mode' value='block' onclick='javascript:Tips(2)' type='radio'><span class='icon icon-check'></span> 黑名单</label><div id='info'  name='info' style='width:500px;margin-top:5px;margin-left:10px;'></div>";
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
							$UData = $dou -> Get_IpList();
							foreach ($UData as $value)
							{
								echo '<option value='.$value[0].'>'.$value[0].'</option>';
							}

							?>
            </select></div>
                    </div>
                </div>
                <div class="form-group" style="margin-top:6px" >
                	<div class="label"><label>操作</label></div>
                	<div class="field">
				<input name="databasebak" type="button" class="button" id="databasebak" href='#' onclick="javascript:art.dialog.open('/admin/system/uploadframe.php?m=add', {title: '新增IP地址', width: 420, height: 400})" value="添加" />&nbsp;&nbsp;<input type="button" class="button" href='#' onclick="javascript:art.dialog.open('system/uploadframe.php?m=edit', {title: '修改IP地址信息', width: 420, height: 402})" value="编辑" />&nbsp;&nbsp;<input type="button" class="button" href='#' onclick="javascript:art.dialog.open('/admin/system/uploadframe.php?m=del', {title: '删除IP地址', width: 420, height: 235})" value="删除" />	
                    </div>
                </div>
                <div class="form-button"><button class="button bg-main" type="submit">应用</button></div> 
         </form>	
        	
        </div>
        
        </div>
      </div>
    </div>
<script>
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
