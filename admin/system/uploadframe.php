<?php
error_reporting(0);
require("../../kernl/Init.php"); 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器到播放界面

//初始化接口列表
$select = '<select onchange="SelectEdit();" id="attrib">';
$UData = $dou -> UploadFrame();
$x=0;
foreach ($UData as $value)
{
	
	$select.='<option value='.$x.'>'.$value[0].'('.$value[1].')</option>';
	$x++;
	
}
$select.='</select>';

//传递参数到js
$UFData = json_encode($UData);
echo '<script> var data= '.$UFData.';</script>';

//请求方式处理
if($_SERVER["REQUEST_METHOD"] == "GET") 
{
	switch($_GET['m']) {	
	case 'add':
		$buttom = '新增';
		$Title = '新增上传参数';
	break;
	
	case 'edit':
		$buttom = '修改';	
		$Title = '修改上传参数设置';
		echo '<script language="JavaScript">document.getElementsByName("path_address")[1].style.display = "none"</script>';	
	break;
	
	case 'del':
		$buttom = '删除';
		$Title = '删除上传参数';
		echo '<script language="JavaScript">document.getElementsByName("musicname")[1].style.display = "none"</script>';
		echo '<script language="JavaScript">document.getElementsByName("singername")[1].style.display = "none"</script>';
		echo '<script language="JavaScript">document.getElementsByName("path_address")[1].style.display = "none"</script>';	
	break;		
			
	default: 
		echo '<script language="JavaScript">window.alert("无效的参数请求")</script>';
		exit;
	break;
	} 
}



if($_SERVER["REQUEST_METHOD"] == "POST") 
{

}

//生成页面代码
$content = "<div class=\"Add\">
   			<form id=\"contact\" action=\"#\" method=\"post\" >  
    		<h4>".$Title."</h4>  
    		<fieldset id=\"Address\">上传接口名
			".$select."
        	<input name=\"path_address\" type=\"text\" placeholder=\"上传接口名\" tabindex=\"1\" />
			</fieldset>  
    		<fieldset>支持后缀名
      		<input name=\"musicname\" type=\"text\" required=\"required\" id=\"music\" placeholder=\"支持后缀名，格式为.xxx，多个用、分割\" tabindex=\"2\" value=".$UData[0][1]."/>
			</fieldset>
    		<fieldset>存储路径
      		<input name=\"singername\" type=\"text\" id=\"singer\" placeholder=\"存储路径\" tabindex=\"3\" value=".$UData[0][2]."/>
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
function SelectEdit() 
{
	 var rtl = document.getElementById("attrib"); 
	 document.getElementsByName("musicname")[1].value = data[rtl.value][1];
	 document.getElementsByName("singername")[1].value = data[rtl.value][2];

}   
</script>	
<body>
<?php echo $content; ?>
</body>
</html>