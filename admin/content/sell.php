<script>
function add() { art.dialog.open('content/selldata.php?m=add', {title: '新增商家数据',width: 300, height: 315}); }
function edit(name) { art.dialog.open('content/selldata.php?m=edit&id='+name, {title: '编辑商家数据',width: 300, height: 315}); }	
</script>
<?php 
//error_reporting(0);
header("Cache-control: private");
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器到登陆界面

//初始化选项夹
$data = array
(
  "TabName"=>array("TabName"=>"订单商家编号"), //第一个为标题
   array("Name"=>"系统管理","tab"=>'#tab-set',"active"=>'active'), //往后的为选项夹
);
$dou->FormCreate($data);

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$method = $_SERVER['REQUEST_METHOD'];
	$addr = $_SERVER['PHP_SELF'].'?'.file_get_contents('php://input');
	$var = $_POST['tableSelect'];	
	
	switch($_POST['databasebak'])
	{
		case '新增': 
			echo "<script LANGUAGE='javascript'>add();</script>";
			//$_POST['databasebak'] = "";
			break;
			
		case '编辑':
			if (empty($var))
			{
				echo "<script LANGUAGE='javascript'>alert('当前编辑的商家为空！');</script>";
				break;
			} else {
				echo "<script LANGUAGE='javascript'>edit('$var');</script>";
				break;
			}
			
		case '删除':
			
			if (empty($var))
			{
				echo "<script LANGUAGE='javascript'>alert('当前删除的商家为空！');</script>";
				break;
			} else {
				$dou->DelData('dd_sell','identifier',$var,'GET');
				break;
			}
			
	}
}
?>
<div class="tab-body">
        <br />
        <div class="tab-panel active" id="tab-set">
        	<form method="post" class="form-x" action="">
            <div class="form-group">
                	<div class="label"><label>商家列表</label></div>
                	<div class="field">
                        <div class="button-group button-group-small radio">
                        <select name="tableSelect" size="10" id="tableSelect" class='select' style="margin-top:6px">
            <?php
			$sell = $dou -> Sell();
			if($sell != NULL) 
			{
				foreach ($sell as $v=>$a)  
				{
               		echo "<option value='" . $a['identifier'] . "'>" . $a['name'] . "</option>";
           		}   
			}	else {echo "<option value=>拉取商家信息失败！</option>";}			


?>

            </select></div>
                    </div>
                </div>
				<div class="form-group" style="margin-top:6px" >
                	<div class="label"></div>
                	<div class="field">
						<input name="databasebak" type="submit" class="button" id="databasebak" value="新增" onclick="javascript:add();"/>&nbsp;&nbsp;<input name="databasebak" type="submit" class="button" id="databasebak" value="编辑" />&nbsp;&nbsp;<input name="databasebak" type="submit" class="button" id="databasebak" value="删除" />
                    </div>
                </div>
            
        </div>
      </div>
    </div>
</div>
</form>
