<?php
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器到播放界面
$addr = $dou->AddrConvery($_GET);
$data = $dou->convert($addr[1],$addr[2],$query);
$sql = "select page from Menu_list where Menu_list.table = '".$data[2]."' AND Menu_list.list = '".$data[3]."';"; 
$result = $dou -> query($sql);
while ($row = $dou -> fetch_array($result)) 
{  
	$file = $row['page'];
}
?>

</head>
<body>
  <div id="main">
    <header id="header">
      <h1><span class="sub">模块加载失败！</span></h1>
    </header>
    <div id="content">
      <p>[ 主参数 ] <?php echo $data[2] . '(' . $addr[1] . ')' ;?><br />[ 子参数 ] <?php echo $data[3] . '(' . $addr[2] . ')' ;?><br />[ 模块名称 ] <?php echo $file;?><br />[ 错误原因 ] 由于模块未找到或出现异常，加载失败！ (处理出现异常)<br /> [ 记录时间 ] <?php echo constant("Time"); ?> [ 访问IP ] <?php echo $_SERVER["REMOTE_ADDR"]; ?></p>
      <?php $dou -> WriteLog('GET', '加载模块：' . $data[2] . '/' . $data[3] .'<br />实例对象：'. $file . '失败','404.php'); ?>
    </div>
</div>
</html>