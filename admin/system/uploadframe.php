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
	$edit = '<div class="Edit" style="display:none">  ';
	$add = '<div class="Add">  ';
    $del = '<div class="Del" style="display:none">  ';
	break;
	
	case 'edit':
	$del = '<div class="Del" style="display:none">  ';
	$edit = '<div class="Edit">  ';
	$add = '<div class="Add" style="display:none">  ';
	break;
	
	case 'del':
	$edit = '<div class="Edit" style="display:none">  ';
	$add = '<div class="Add" style="display:none">  ';
    $del = '<div class="Del">  ';
	break;		
			
	default: 
	$edit = '<div class="Edit" style="display:none">  ';
	$add = '<div class="Add">  ';
	$del = '<div class="Del" style="display:none">  ';
	break;
	} 
}

if($_SERVER["REQUEST_METHOD"] == "POST") 
{

}
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
<?php echo $add; ?>
<form id="contact" action="#" method="post" >  
    <h4>新增上传参数</h4>  
  <fieldset id="Address">上传接口名
        <input name="path_address" type="text" placeholder="上传接口名" tabindex="1" />
    </fieldset>  
    <fieldset>支持后缀名
      <input name="musicname" type="text" required="required" id="music" placeholder="支持后缀名，格式为.xxx，多个用、分割" tabindex="2" />
    </fieldset>
    <fieldset>存储路径
      <input name="singername" type="text" id="singer" placeholder="存储路径" tabindex="3" />
    </fieldset>
  <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">新增</button>
    </fieldset>
  </form>

</div>
  <?php echo $edit; ?> 
<form id="contact" action="#" method="post" >
    <h4>修改上传参数设置</h4>
    <fieldset id="Address">上传接口名
    <?php echo $select;	?>
    </fieldset>  
    <fieldset>支持后缀名
        <input name="musicname" type="text"  id="music" placeholder="支持后缀名" tabindex="1" value="<?php echo $UData[0][1]; ?>" />
    </fieldset>
    <fieldset>存储路径
        <input name="singername" type="text" id="singer" placeholder="存储路径" tabindex="2" value="<?php echo $UData[0][2]; ?>" />
    </fieldset>
   <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">修改</button>
  </fieldset>
</form>
</div>
  <?php echo $del; ?> 
<form id="contact" action="#" method="post" >
    <h4>删除上传参数</h4>
    <fieldset id="Address">上传接口名
    <?php echo $select; ?>
    </fieldset>  
   <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">删除</button>
  </fieldset>
</form>
</div>
</body>
</html>