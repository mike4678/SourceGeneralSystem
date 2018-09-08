 <?php
//error_reporting(0);

require("../../kernl/Init.php");

//******* 处理登陆状态
$state = $dou -> AccountState();
if ($state == '1') 
{
	header("Location: ../login.php");
}

if($_SERVER["REQUEST_METHOD"] == "GET") {
  switch($_GET['m']) {	
	case 'add':
	$edit = '<div class="UserEdit" style="display:none">  ';
	$add = '<div class="UserAdd">  ';
	break;
	
	case 'edit':
	$edit = '<div class="UserEdit">  ';
	$add = '<div class="UserAdd" style="display:none">  ';
	$_GET['id'] = empty($_GET['id']) ? '' : $_GET['id'];
	if($_GET['id'] == NULL) 
	{
		echo '<script language="JavaScript">window.alert("ID值错误！")</script>';
		exit;
	}
	 $sql = "select * From dd_sell where identifier = '".$_GET['id']."';";
	 $resu = $dou -> query($sql);
	 $count = $dou ->affected_rows();	  
	 $row  = $dou -> fetch_array($resu);
	 $name = $row['name'];
	 $idf = $row['identifier'];	 
	if($count < 1 )	
	{
		echo '<script language="JavaScript">window.alert("值ID非法！")</script>';
		exit;
	} 
	break;
	
	default: 
	echo '<script language="JavaScript">window.alert("参数错误！")</script>';
	exit;
	} 
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
	switch($_GET['m']) { 
	case 'add':
		$_POST['sellname'] = empty($_POST['sellname']) ? '' : $_POST['sellname'];	
		$_POST['id'] = empty($_POST['id']) ? '' : $_POST['id'];	
		if($_POST['sellname'] = '') { echo "商家名不能为空！&nbsp; &nbsp; <a href=\"javascript:history.go(-1)\">点击返回</a>"; exit;}
		if($_POST['id'] = '') { echo "商家标识符不能为空！&nbsp; &nbsp; <a href=\"javascript:history.go(-1)\">点击返回</a>"; exit;}
		$dou -> query("select * from dd_sell where name = '".$_POST['sellname']."' AND identifier = '".$_POST['id']."';");	
		if( $dou -> affected_rows() == NULL ) 
		{
			$sql = "INSERT INTO `dd_sell` (`name`, `identifier`) VALUES ('".$_POST['sellname']."', '".$_POST['id']."')";
			if (!$dou->query($sql)) 
			{
				echo '<script language="JavaScript">window.alert("新增失败！")</script>';
				echo '<script language="JavaScript">parent.location.reload()</script>';
			} else {
				echo '<script language="JavaScript">window.alert("商家录入成功！")</script>';
				echo '<script language="JavaScript">parent.location.reload()</script>';
			}
		} else {
				echo '<script language="JavaScript">window.alert("商家已存在！")</script>';
				echo '<script language="JavaScript">parent.location.reload()</script>';
		}
		
	break;
	
	case 'edit':
		$_POST['sellname'] = empty($_POST['sellname']) ? '' : $_POST['sellname'];	
		$_POST['id'] = empty($_POST['id']) ? '' : $_POST['id'];	
		if($_POST['sellname'] == '') { echo "商家名不能为空！&nbsp; &nbsp; <a href=\"javascript:history.go(-1)\">点击返回</a>"; exit;}
		if($_POST['id'] == '') { echo "商家标识符不能为空！&nbsp; &nbsp; <a href=\"javascript:history.go(-1)\">点击返回</a>"; exit;}
		if($_POST['sellname'] != $_POST['name'] && $_POST['id'] != $_POST['userid'])  //两个值同时被修改
		{
			$dou -> query("select * from dd_sell where name = '".$_POST['sellname']."' AND identifier = '".$_POST['id']."';");	
			if( $dou -> affected_rows() == NULL ) 
			{
			$sql = "INSERT INTO `dd_sell` (`name`, `identifier`) VALUES ('".$_POST['sellname']."', '".$_POST['id']."')";
			if (!$dou->query($sql)) 
			{
				echo '<script language="JavaScript">window.alert("新增失败！")</script>';
				echo '<script language="JavaScript">parent.location.reload()</script>';
			} else {
				echo '<script language="JavaScript">window.alert("商家录入成功！")</script>';
				echo '<script language="JavaScript">parent.location.reload()</script>';
				}
			} else {
				echo '<script language="JavaScript">window.alert("商家已存在！")</script>';
				echo '<script language="JavaScript">parent.location.reload()</script>';
			}
		
		} 
		
		if($_POST['sellname'] != $_POST['name'] && $_POST['id'] == $_POST['userid'])
		{
			$sql = "UPDATE `dd_sell` SET `name`='".$_POST['sellname']."' WHERE (`identifier`='".$_POST['id']."')" ;
			if (!$dou->query($sql)) 
			{
				echo '<script language="JavaScript">window.alert("修改失败！")</script>';
			} else {
				echo '<script language="JavaScript">parent.location.reload()</script>';
			}
			
		} else {
			
			$sql = "UPDATE `dd_sell` SET `identifier`='".$_POST['id']."' WHERE (`name`='".$_POST['name']."')" ;
			if (!$dou->query($sql)) 
			{
				echo '<script language="JavaScript">window.alert("修改失败！")</script>';
			} else {
				echo '<script language="JavaScript">parent.location.reload()</script>';
			}
		}
	break;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<link href="../../css/setting.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://api.csource.com.cn/1.8.1/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="../../js/jquery.form.js"></script>
</head>
<body>
<?php echo $add; ?>
<form id="contact" action="#" method="post" >  
    <h4>新增商家</h4> 
    <fieldset>商家名
        <input name="sellname" type="text" required id="sell" placeholder="商家名" tabindex="1">
    </fieldset>
    <fieldset>标识符
        <input name="id" type="text" id="id" placeholder="标识符" tabindex="2">
    </fieldset>
    <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">新增</button>
    </fieldset>
  </form>

</div>
  <?php echo $edit; ?> 
<form id="contact" action="#" method="post" >
    <h4>修改商家信息</h4>
    <fieldset>商家名
        <input name="sellname" type="text" required id="sell" placeholder="商家名" tabindex="1" value=<?php echo $name;?>>
    </fieldset>
    <fieldset>标识符
        <input name="id" type="text" id="id" placeholder="标识符" tabindex="2" value=<?php echo $idf;?>>
    </fieldset>
	<input type='hidden' name='name' value=<?php echo $name;?>>
	<input type='hidden' name='userid' value=<?php echo $idf;?>>
   <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">修改</button>
    </fieldset>
  </form>
</div>
</body>

</html>
