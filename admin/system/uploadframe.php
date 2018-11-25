<?php
error_reporting(0);
require("../../kernl/Init.php"); 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器到播放界面

print_r($dou -> UploadFrame());
//初始化接口列表
$select =  '<select>';
	if($dou -> Info("upload_frame") == NULL)  //如果为空自动修复							 
	{
		if($dou -> UploadFrameFix() == 'null') 
		{
			die("参数读取发生错误，请与管理员联系");
		}
						
	}	else {
			$pieces = explode("|", $dou ->Info("upload_frame"));
				foreach($pieces as $val)
				{
					if($val == NULL)
					{
						break;
					}
					$IndexData = explode(";", $val);
  					$select.='<option value='.$IndexData[0].'>'.$IndexData[0].'('.str_replace("*","、",$IndexData[1]).')</option>';
					$filepath[count($filepath)] = $IndexData[2];
					$fileico[count($fileico)] = str_replace("*","、",$IndexData[1]);
				}
			}
$select.='</select>';

//请求方式处理
if($_SERVER["REQUEST_METHOD"] == "GET") 
{
	switch($_GET['m']) {	
	case 'add':
	$edit = '<div class="UserEdit" style="display:none">  ';
	$add = '<div class="UserAdd">  ';
    $del = '<div class="UserDel" style="display:none">  ';
	break;
	
	case 'edit':
	$del = '<div class="UserDel" style="display:none">  ';
	$edit = '<div class="UserEdit">  ';
	$add = '<div class="UserAdd" style="display:none">  ';
	break;
	
	case 'del':
	$edit = '<div class="UserEdit" style="display:none">  ';
	$add = '<div class="UserAdd" style="display:none">  ';
    $del = '<div class="UserDel">  ';
	break;		
			
	default: 
	$edit = '<div class="UserEdit" style="display:none">  ';
	$add = '<div class="UserAdd">  ';
	break;
	} 
}

if($_SERVER["REQUEST_METHOD"] == "POST") 
{

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/setting.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php echo $add; ?>
<form id="contact" action="#" method="post" >  
    <h4>新增上传参数</h4>  
  <fieldset id="Address">上传接口名
        <input name="path_address" type="text" placeholder="上传接口名" tabindex="0" />
    </fieldset>  
    <fieldset>支持后缀名
      <input name="musicname" type="text" required="required" id="music" placeholder="支持后缀名" tabindex="1" />
    </fieldset>
    <fieldset>存储路径
      <input name="singername" type="text" id="singer" placeholder="存储路径" tabindex="2" />
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
        <input name="musicname" type="text"  id="music" placeholder="支持后缀名" tabindex="1" value="<?php echo $fileico[0]; ?>"/>
    </fieldset>
    <fieldset>存储路径
        <input name="singername" type="text" id="singer" placeholder="存储路径" tabindex="2" value="<?php echo $filepath[0]; ?>"/>
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