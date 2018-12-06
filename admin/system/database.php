<?php 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器到播放界面
$data = array
(
  "TabName"=>array("TabName"=>"数据库设置"), //第一个为标题
   array("Name"=>"数据库管理","tab"=>'#tab-set',"active"=>'active'), //往后的为选项夹
);
$dou->FormCreate($data);
?>
      <div class="tab-body">
        <br />
        <div class="tab-panel active" id="tab-set">
        	<form method="post" class="form-x" action="#">
            <div class="form-group">
                	<div class="label"><label>备份文件列表</label></div>
                	<div class="field">
                        <div class="button-group button-group-small radio">
                        <select name="tableSelect" size="10" id="tableSelect" class='select' style="margin-top:6px">
            <?php
			$arr = array();
if (!file_exists('backup')) {
    mkdir("backup");
    echo "<option value=>第一次使用请先备份数据</option>";
} else {
    $d = dir("backup");
    while (false !== ($e = $d->read())) {
		$arr[] = $e; } 
	 if (count($arr) > 2) {   //判断文件数量是否大于2，如果不大于则认为不存在备份文件
	 unset($arr[0],$arr[1]);
              foreach ($arr as $v=>$a)  {
                echo "<option value=" . $a . ">" . $a . "</option>";
            }   
	    } else {echo "<option value=>无可用备份数据</option>";}
}

?>

            </select></div>
                    </div>
                </div>
                <div class="form-group" style="margin-top:6px">
                	<div class="label"><label>当前状态</label></div>
                  <div class="field" style="margin-top:7px"><?php 
					if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$method=$_SERVER['REQUEST_METHOD'];
			$addr=$_SERVER['PHP_SELF'].'?'.file_get_contents('php://input');
						
	switch($_POST['databasebak'])
	{
	case '备份数据库': 
			$resu = $dou -> query("show tables");
			while($t = $dou -> fetch_array($resu))
			{
  				$table = $t[0];
  				$q2 = $dou -> query("show create table `$table`");
  				$sql = $dou -> fetch_array($q2);
  				$mysql.=$sql['Create Table'].";\r\n";
  				$q3 = $dou -> query("select * from `$table`");
  				while($data=$dou -> fetch_assoc($q3))
				{
    				$keys = array_keys($data);
    				$keys = array_map('addslashes',$keys);
    				$keys = join('`,`',$keys);
    				$keys = "`".$keys."`";
    				$vals = array_values($data);
    				$vals = array_map('addslashes',$vals);
    				$vals = join("','",$vals);
    				$vals = "'".$vals."'";
					$mysql.="insert into `$table`($keys) values($vals);\r\n";
				}
			}
			$filename = "backup/".$dbname.date('Ymjgi').".sql"; //存放路径，默认存放到项目最外层
			$fp = fopen($filename,'w');
			fputs($fp,$mysql);
			fclose($fp);
			echo "数据备份成功<br>备份文件 [ " .$filename." ]<br><a href=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?/system/database\">点击刷新</a>";
			$dou -> WriteLog('POST', '管理员执行数据库备份', $addr); 
			break;
			
	case '恢复数据库':
			set_time_limit(0); //设置超时时间为0，表示一直执行。当php在safe mode模式下无效，此时可能会导致导入超时，此时需要分段导入 
			echo "<p>正在恢复数据库，步骤一，清理数据表<br>"; 
			$result = $dou -> query("SHOW tables"); 
			while ($currow=$dou -> fetch_array($result)) 
			{ 
				$dou -> query("drop TABLE IF EXISTS $currow[0]"); 
				echo "清空数据表【".$currow[0]."】成功！<br>"; 
			} 
			echo "正在恢复数据库，步骤一，清理数据表....完成<br>正在恢复数据库，步骤二，导入数据<br>"; 
			$filename = $_POST['tableSelect'];
			$mysql_file="backup/".$filename; //指定要恢复的MySQL备份文件路径,请自已修改此路径
			if(file_exists($mysql_file)) {
				$sql_value="";
  				$cg=0;
  				$sb=0;
  				$sqls = file($mysql_file);
  				foreach($sqls as $sql)
  				{
  					$sql_value.=$sql;
  				}
  				$a = explode(";\r\n", $sql_value); //根据";\r\n"条件对数据库中分条执行
  				$total = count($a) - 1;
  				$dou -> query("set names 'utf8'");
  				for ($i = 0; $i<$total ; $i++)
  				{
 					$dou -> query("set names 'utf8'");
  					//执行命令
  					if($dou -> query($a[$i]))
  					{
   						$cg+=1;
  					} else {
   							$sb+=1;
							$sb_command[$sb] = $a[$i];
  						}
  				}
  				echo "操作完毕，共处理 $total 条命令，成功 $cg 条，失败 $sb 条<br><a href=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?/system/database\">点击刷新</a>";
  				//显示错误信息
				
				if(constant("Debug") == 'on' & $sb>0)   //调试模式开启，并且存在失败条数的时候才显示错误语句
  				{
  					echo "<hr><br>失败命令如下：<br>";
  					for ($ii=1;$ii<=$sb;$ii++)
  					{
   					echo "<b>第 ".$ii." 条命令（内容如下）：</b><br>".$sb_command[$ii]."<br>";
  					}
  				}  
			}  else {
  				echo "MySQL备份文件不存在，请检查文件路径是否正确！";
			}
			
			$dou -> WriteLog('POST', '管理员执行恢复数据库', $addr); 
			break;
			
	case '删除备份':
			if (empty($_POST['tableSelect'])){
				echo "待删除的备份为空！";
			} else {
			$file = dirname(__FILE__)."/../backup/".$_POST['tableSelect']; 
			$result = @unlink ($file); 
			if ($result == false) { 
			echo '<span style="color: #F00">×删除失败！</span>'; 
			$dou -> WriteLog('POST', "删除备份：".$_POST['tableSelect']."失败！", $addr); 
			} else { 
			echo "<span style='color: #3F0'>√删除成功！</span><br ><a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?/system/database'>点击刷新</a>"; 
			$dou -> WriteLog('POST', "删除备份：".$_POST['tableSelect']."成功！", $addr); 
			} 
				}
			break;
	case '清空数据库':
		$data = array
		(
  			'music_list', 'system_log'
		); 
		$num = 0;	
		while ($currow = $data) 
		{ 
			if($num > count($data) -1 ) 
			{
				break;
			} else {
				$dou -> query("truncate table ".$currow [ $num ] ); 
				echo "清空数据表".$currow [ $num ]."成功！<br>";
				$dou -> WriteLog('POST', '管理员执行清空数据表操作', $addr); 
				$num++;	
			}
		}
		break;	
} 	
}
					 ?></div>
                </div>
				<div class="form-group" style="margin-top:6px" >
                	<div class="label"><label>数据库操作</label></div>
                	<div class="field">
                       <input name="databasebak" type="submit" class="button" id="databasebak" value="备份数据库" />&nbsp;&nbsp;<input name="databasebak" type="submit" class="button" id="databasebak" value="恢复数据库" />&nbsp;&nbsp;<input name="databasebak" type="submit" class="button" id="databasebak" value="清空数据库" />&nbsp;&nbsp;<input name="databasebak" type="submit" class="button" id="databasebak" value="删除备份" />
                    </div>
                </div>
            
        </div>
      </div>
    </div>
</div>
</form>
