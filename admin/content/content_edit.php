<?php 
error_reporting(0);

require("../../kernl/Init.php");

//******* 处理登陆状态
$state = $dou -> AccountState();
if ($state == '1') 
{
	header("Location: ../login.php");
}
if (empty($_GET['code'])){
	 echo '<script language="JavaScript">window.alert("查询码无效")</script>';
	 echo '<script language="JavaScript">var browserName=navigator.appName; if (browserName=="Netscape") {window.open("","_self","");window.close(); } else {window.close();}</script>';
	 }else {
		 $sql="select * from dd_address where querycode = '".$_GET['code']."';"; 
		 $code=$_GET['code'];
		 $result=$dou -> query($sql); 
		 while ($row=$dou -> fetch_array($result)) { 
		 $addr=$row['address'];
		 $status= $row['status'];
		 $time= $row['gettime'];
		 $requires= $row['requires'];
		 $kdinfo = $row['code'];
		 }}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$updatedisk = "update dd_address set status = '" . $_POST['select'] . "', code = '" .$_POST['kd']. "' where querycode = '" . $code . "';";
       if (!$dou -> query($updatedisk)) {
          die('更改状态失败: ' . mysqli_error($query));
          }
          echo '<script language="JavaScript">window.alert("更改状态成功！")</script>';
          echo '<script language="JavaScript">window.opener.location.reload()</script>';
		  echo '<script language="JavaScript">var browserName=navigator.appName; if (browserName=="Netscape") {window.open("","_self","");window.close(); } else {window.close();}</script>';
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>订单修改</title>
<link href="../../css/setting.css" rel="stylesheet" type="text/css" />
</head>
<body>

  <div class="container">  
  <form id="contact" action="#" method="post">
    <h4>订单查看与修改</h4>
    <fieldset>
      订单地址
        <input placeholder="Your address" type="text" tabindex="1" value=<?php echo $addr;?>>
    </fieldset>
    <fieldset>
      要求
        <input placeholder="Your require" type="email" tabindex="2" value=<?php echo $requires;?>>
    </fieldset>
    <fieldset>
      提交时间
      <input placeholder="Get Time" type="tel" tabindex="3" value=<?php echo $time;?>>
    </fieldset>
    <fieldset>
      订单状态
	  <?php 
	  switch($status){
	  case '等待处理':
	  echo "<select name='select' size='1' id='select'>";
	  echo "<option value='等待处理' selected = 'selected'>等待处理</option><option value='已发货'>已发货</option><option value='已完成'>已完成</option>";
	  break;
	  case '已发货':
	  echo "<select name='select' size='1' id='select'>";
	  echo "<option value='等待处理' >等待处理</option><option value='已发货' selected = 'selected'>已发货</option><option value='已完成'>已完成</option>";
	  break;
	  case '已完成':
	  echo "<select name='select' size='1' id='select'>";
	  echo "<option value='等待处理' >等待处理</option><option value='已发货'>已发货</option><option value='已完成' selected = 'selected'>已完成</option>";
	  break;
	  }
	  ?>  
        </select>
    </fieldset>
    <fieldset>
      快递信息
        <textarea placeholder="Code" tabindex="5" name="kd" ><?php echo $kdinfo;?></textarea>
    </fieldset>
    <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">更改</button>
    </fieldset>
  </form>

</div>
</body>

</html>