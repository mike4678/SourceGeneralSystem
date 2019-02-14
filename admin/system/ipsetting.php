<?php
require("../../kernl/Init.php"); 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器

//判断是否在框架内，防止跨域
$dou -> FormCheck();

//请求方式处理
switch($_GET['m']) 
{	
	case 'add':
		$buttom = '新增';
		$Title = '新增IP信息';
		$UData = '';
	break;
	
	case 'edit':
		$buttom = '修改';	
		$Title = '修改IP信息';
	break;
	
	case 'del':
		$buttom = '删除';
		$Title = '删除IP信息';
	break;		
			
	default: 
		echo '<script language="JavaScript">window.alert("无效的参数请求")</script>';
		exit;
	break;
} 

if($_SERVER["REQUEST_METHOD"] == "POST") 
{
	switch($_GET['m']) {	
	case 'add':
		if($dou -> IPFirewallControl('add', $_POST['ip_address'] , $_POST['Interface']) != 'failed')
		{
			echo '<script language="JavaScript">parent.location.reload()</script>';
		}
		break;
	
	case 'edit':
		if($dou -> IPFirewallControl('edit', $_POST['IPTab'] , $_POST['Interface']) != 'failed')
		{
			echo '<script language="JavaScript">parent.location.reload()</script>';
		}		
		break;
	
	case 'del':
		if($dou -> IPFirewallControl('del', $_POST['IPTab'] , '') != 'failed')
		{
			echo '<script language="JavaScript">parent.location.reload()</script>';
		}	
		break;		
	} 
}

$IPTable = "<select name='IPTab' style='display:none'>";
$UData = $dou -> Get_IpList();
foreach ($UData as $value)
{
	$IPTable.= '<option value='.$value['iptable'].'>'.$value['iptable'].'</option>';					
}
$IPTable.= "</select>";

//生成页面代码
$content = "<div class=\"Frame\">
   			<form id=\"contact\" action=\"\" method=\"post\" >  
    		<h4>".$Title."</h4>  
    		<fieldset name=\"Address\">IP地址
			".$IPTable."
        	<input name=\"ip_address\" type=\"text\" placeholder=\"IP地址\" tabindex=\"1\" />
			</fieldset>  
    		<fieldset name=\"name\">应用接口
			<select name='Interface'> 
			<option value='0'>白名单</option> 
			<option value='1'>黑名单</option>
			<option value='2'>双向</option> 
			</select>
			</fieldset>
  			<fieldset>
      		<button name=\"submit\" type=\"submit\" id=\"contact-submit\" data-submit=\"...Sending\" value=\"".$buttom."\">".$buttom."</button>
    		</fieldset>
  			</form>
			</div>";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/setting.css" rel="stylesheet" type="text/css" />
</head>
<script>	
var $_GET = (function(){
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if(typeof(u[1]) == "string"){
        u = u[1].split("&");
        var get = {};
        for(var i in u){
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})();	
</script>	
<body>
<?php echo $content; ?>
<script>
//界面显示方式处理	
if ($_GET['m'] == 'del')
{
	document.getElementsByName("ip_address")[0].style.display = "none";
	document.getElementsByName("IPTab")[0].style.display = "";
	document.getElementsByName("Interface")[0].style.display = "none";
	document.getElementsByTagName("fieldset")[1].style = 'display:none';	
	
} else if ($_GET['m'] == 'edit')
	{
		document.getElementsByName("ip_address")[0].style.display = "none";
		document.getElementsByName("IPTab")[0].style.display = "";
	}	
</script>
</body>
</html>