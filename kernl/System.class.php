<?php
/* ---------------------------------------------------- */
/* 程序名称: 核心函数
/* 程序功能: 所有核心函数的调用均在此页面中
/* 程序开发: Source
/* 联系方式: 542112943@qq.com
/* Date: 1970-01-01 / 2016-08-30
/* ---------------------------------------------------- */
/* 使用条款:
/* 1.该软件免费使用.
/* 2.禁止任何衍生版本.
/* ---------------------------------------------------- */

class System extends DbMysql 
{
	//系统设置表信息
	/* ---------------------------------------------------- */
	function Info($data) {                  
		$query = $this->select_all('system_setting');
		while ($row = $this->fetch_array($query)) 
		{
			
			if ($row[0] == $data)
			{
				return $row[1];
				break;
				}
			}

		}
	/* ---------------------------------------------------- */
	
	//删除一条或多条数据
	/* ---------------------------------------------------- */
	function DelData($table,$hterm,$term,$method)    //参数：表$table,条件头$hterm,条件$term,操作方式$method
	{ 
   		if(empty($table) || empty($hterm) || empty($term) || empty($method))  //五个变量任意一个如果为空
		{     
		echo "<script language='JavaScript'>window.alert(操作请求所需要的值错误，请检查！)</script>";
		} else {
			switch ($method) {
					
				default:   //请求无效
					echo '<script language="JavaScript">window.alert("无效的操作请求")</script>';
				break;
		
				case 'POST':    //处理多个删除任务
					$sql = "delete from ".$table." where ".$hterm." in ('".$term."');";
					if (!$this->query($sql)) 
					{
   						echo '<script language="JavaScript">window.alert("删除失败！")</script>';
     				}
					echo '<script language="JavaScript">window.alert("删除成功！")</script>';
    				echo '<script language="JavaScript">self.location=document.referrer;</script>';
    			break;
		
				case 'GET':    //处理单个删除任务
					if (count(explode("%",$term)) > 1)  //一般认为一个中文字会转换成3个类似%D8%E5%C3的代码，因此这里以3为判断标准
					{  
						$url = urldecode($term);
						$sql = "delete from ".$table." where ".$hterm." = '" .$url. "';";
						echo '<script language="JavaScript">window.alert("'.$sql.'")</script>';
						if (!$this->query($sql)) 
						{
   							echo '<script language="JavaScript">window.alert("删除失败！")</script>';
     					}
						echo '<script language="JavaScript">window.alert("删除成功！")</script>';
    					echo '<script language="JavaScript">self.location=document.referrer;</script>';
						
					} 
				break;
				} 
		}
	}
	/* ---------------------------------------------------- */
	
	//页面功能生成
	/* ---------------------------------------------------- */
	function table_list($table,$table_list) //自动生成顶部选项位置以及当前选中的左边列表
	{  
		if( empty($table) && empty($table_list) )   //检查，如果这两个参数都为空，则返回错误信息，
		{ 
			echo '<script language="JavaScript">window.alert("初始化页面失败！");history.back(-1);</script>';
 	 	} else { 
			$tab = ""; //初始化变量
			$TableData = explode("|", $this -> Info("system_table"));
			foreach($TableData as $val)
			{
				$row = explode(";", $val);
				if($table == $row[0]) 
				{	
					$tab.= "<li class='active'><a href=".$row[2]." class=".$row[1]."> ".$row[0]."</a><ul>"; 
					$list = $this->select('adminlist', '*', "adminlist.table = '".$table."' ORDER BY count ASC;", $debug = ''); //生成左边列表部分
					$infor1 = array(); 
					while ( $row1 = $this->fetch_array($list) )  
					{
						if($table_list == $row1['menu'])
						{
							$tab.= "<li class='active'><a href=".$row1['url']."> ".$row1['menu']."</a></li>";
						}else {
							$tab.= "<li><a href=".$row1['url']."> ".$row1['menu']."</a></li>";
						}
					}				
					$tab.= "</li></ul>";
				}else {
					$tab.= "<li><a href='".$row[2]."' class='".$row[1]."'> ".$row[0]."</a></li>";
				}
			}
   		}
		return $tab;
	}
	
	
	function navigation ($table,$table_list)   //导航栏内容
	{   
		if( empty($table) || empty($table_list) )   //检查
		{ 
			echo '<script language="JavaScript">window.alert("初始化导航栏失败！");history.back(-1);</script>';
		} else { 
			$infor = array(); 
			$query = $this->select('adminlist', '*', "adminlist.table='".$table."'  AND adminlist.menu = '".$table_list."' UNION ALL SELECT * FROM `adminlist` where adminlist.table = '".$table."' ORDER BY count ASC limit 2;", $debug = '');
			while (	$row = $this->fetch_array($query))   
			{
				echo "<li><a href='index.php' class='icon-home'> 开始</a></li>";
				echo "<li><a href=".$row[1].">".$row[2]."管理</a></li>"; 
				echo "<li>".$table_list."</li>";
				break;
			}
		}
	}

	function convert($table,$table_list)  //将英文名称转换为中文
	{  
		$query = $this->select('Adminlist', '*', "Adminlist.t_e = '".$table."' AND m_e = '".$table_list."'", $debug = '');
		$row = $this->fetch_array($query);
		return $row;
	}
	
	function AddrConvery($data)  //处理请求
	{  
		foreach ($data as $key=>$value) //把参数传入变量key中
		$arr = explode("/",$key);
		return $arr;
	}	
	
	function PageLoading($table,$table_list = '')    //载入框架页面
	{  
		$query = $this->select('adminlist', '*', "adminlist.table = '".$table."' AND adminlist.menu = '".$table_list."'", $debug = '');
		$row = $this->fetch_array($query);
		//print_r("Menu_list.table = '".$table."' AND Menu_list.list = '".$table_list."'");
		return $row['page'];
	}
	
	function FormCheck()  //检查框架页面是否存在，即不允许直接访问
	{   
		echo '<script>if(window.top==window.self){ window.alert("未检测到框架窗口，请从主窗口进入！") var browserName=navigator.appName; if (browserName=="Netscape") {window.open("","_self","");window.close(); } else {window.close();}  }</script>';
	}
	
	
	function FormCreate($data)  //多选项夹生成
	{ 
		$form = '<div class="tab"><div class="tab-head"><strong>'.$data['TabName']['TabName'].'</strong><ul class="tab-nav">';
		unset($data['TabName']); //删除标题数组
		foreach ($data as $row)   
		{
			if($row['active'] != 'active') 
			{
				$form.= "<li><a href=".$row['tab'].">".$row['Name']."</a></li>";
				} else {
					$form.= "<li class=\"active\"><a href=".$row['tab'].">".$row['Name']."</a></li>";
					}
		}
		$form.= "</ul></div>"; 
		echo $form;
	}
	
	function PageValue($table,$table_list = '')  //读入页面参数
	{  
		$query = $this->select('adminlist', '*', "adminlist.table = '".$table."' AND adminlist.menu = '".$table_list."'", $debug = '');
		$row = $this->fetch_array($query);
		//print_r("Menu_list.table = '".$table."' AND Menu_list.list = '".$table_list."'");
		return $row['value'];
	}
	
	function content($data,$value)
	{                     //内容页面相关参数返回
		$query = $this -> query("select * from content_data where list = '$data'");	
		if($this -> affected_rows() == NULL )  
		{
			return 'error';
		} else {
			$row = $this->fetch_array($query);
			return $row[$value];
			}

	}
	/* ---------------------------------------------------- */
	
	//写入系统日志
	/* ---------------------------------------------------- */
	function WriteLog($method,$data,$addr)     //参数：请求方式、操作内容、操作页面
	{    
		$ip = $_SERVER["REMOTE_ADDR"]; //获取IP
		$time = date("y/m/d",time());  //获取现在时间
		$query = $this->select('system_log', 'max(id)', "", $debug = '');
		while ($row = $this->fetch_array($query)) 
		{ 
			$id = $row['max(id)'] + 1;
		}
		$this->query("INSERT INTO system_log (id, method, ip, data, addr, time) VALUES ('$id','$method','$ip','$data','$addr','$time')");
 	 	if ($this->affected_rows() == NULL) {
      	echo '<script language="JavaScript">window.alert("写入日志失败！")</script>';
    		 }
	} 
	/* ---------------------------------------------------- */
	
		//上传大小检查
	/* ---------------------------------------------------- */
	function CheckUploadSize() 
	{
		$File_size = $this->Info('upload_size');
		$PHP_Size = str_replace("M","",ini_get('post_max_size'));
		if($File_size == NULL || $File_size == 0 || $File_size > $PHP_Size) 
		{
			$size = $PHP_Size - 1;
			$sql = "update system_setting set value = '". $size ."' where vars = 'upload_size';";
			if(!$this->query($sql))
			{
				echo '参数检测发现异常，但尝试修复失败！';
			}
		} 
	}

	/* ---------------------------------------------------- */
	
		
		//系统状态检查
	/* ---------------------------------------------------- */
	function CheckServerState() 
	{
		$staus = $this->Info('server_status');
		if($staus == "1") 
		{
			echo $this->Sys_ErrorPage(503);
			exit;
		}
	}

	/* ---------------------------------------------------- */
	
		
		
		//登陆状态
	/* ---------------------------------------------------- */
	function AccountState() 
	{
		$_COOKIE['state'] = empty($_COOKIE['state']) ? '' : $_COOKIE['state'];
		if($_COOKIE['state'] != NULL )  //已经登陆过，且记录还存在
		{
			$user = $_COOKIE['usr'];
			$pwd = $_COOKIE['pwd'];
			$time = $_COOKIE['state'];
			$now = time();
			if($time > $now - 3600) 
			{
				$this -> query("select * from admin_user where username = '$user' and password = '$pwd'");		
				if( $this -> affected_rows() == NULL ) 
				{
				echo '<script language="JavaScript">window.alert("账户信息验证失败，请重新登陆！")</script>';
				return '1';
				} 
			} else {
				echo '<script language="JavaScript">window.alert("Session失败，请重新登陆！")</script>';
				return '1';
				}
		} else {
			return '1';
			}	
	}

	/* ---------------------------------------------------- */
	
		
		//PHP COOKIE设置函数立即生效，支持数组
	/* ---------------------------------------------------- */
	function cookie($var, $value = '', $time = 0, $path = '', $domain = '', $s = false)
	{
    $_COOKIE[$var] = $value;
    if (is_array($value)) 
		{
        foreach ($value as $k => $v)
			{
            setcookie($var . '[' . $k . ']', $v, $time, $path, $domain, $s);
        	}
    	} else {
        	setcookie($var, $value, $time, $path, $domain, $s);
    		}
	}
	
	/* ---------------------------------------------------- */
		
	
		
		//在线检查更新
	/* ---------------------------------------------------- */
	function CheckUpdate()
	{
		
		if(strtolower($this -> Info("update_status")) == 'custom')  //定制版
		{
			echo '定制版请联系开发者获取更新';
			
		} else {
			
			$opts = array(
							'http'=>array(
							'method'=>"GET",
							'timeout'=>600,
							)
						);
		
			$context = stream_context_create($opts);
			$url = 'http://service.csource.com.cn/update/check.php?product=' . $this -> Info("update_status"); 
			$html = file_get_contents($url,false, $context); 
			$str = strtr($html, "\t", ' ');
			$encode = mb_detect_encoding($str, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
				if($encode != "UTF-8")
				{
  					$str = iconv("GBK","UTF-8",$str);
				}
			$return_data = json_decode($str,true);
			echo '<a href="javascript:info(\'http://service.csource.com.cn/update/update.php?product=' . $this -> Info("update_status") . '\')" >' . $return_data['version'] . '</a>'; 
			
			}

	}
	
	
	/* ---------------------------------------------------- */
	
			
	
		
		//数据表检查(参数：需要检查的表名)
	/* ---------------------------------------------------- */
	function TableCheck($table)   
	{
		
		
	}
	
	/* ---------------------------------------------------- */

	
		
		//IP管理核心部分
	/* ---------------------------------------------------- */
	function Get_LocalIP()          //获取客户端IP
	{
		
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
			$ip = getenv("HTTP_CLIENT_IP"); 
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
			$ip = getenv("HTTP_X_FORWARDED_FOR"); 
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
			$ip = getenv("REMOTE_ADDR"); 
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
			$ip = $_SERVER['REMOTE_ADDR']; 
		else 
			$ip = "unknown"; 
		return($ip); 
		
	}
	
	function Check_IPStatus()     //检查当前IP是否被限制
	{
		
	}
	
	function AddIP_Firewall($ip,$fwlist)    //将一个IP添加到一个列表中
	{
		
	
	}
	
	function DelIP_Firewall($ip,$fwlist)    //将一个IP从一个列表中删除
	{
		
	}
	
	function EditIP_Firewall($ip,$fwlist)    //修改一个列表中的某一个IP信息
	{
		
	}
	
	function Get_IpList($fwlist)   //获取当前列表中的ip信息
	{
		
		
	}	
	/* ---------------------------------------------------- */

		
		//随机字符生成
	/* ---------------------------------------------------- */	
	
	function generate_password( $length = 8 ) 
	{
    // 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    $password = '';
    for ( $i = 0; $i < $length; $i++ ) 
    {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    }

    return $password;
	}
	/* ---------------------------------------------------- */
	
		//首页错误页生成
	/* ---------------------------------------------------- */	
	
	function Index_ErrorPage ( $code = 3 ) 
	{
    	// 根据错误码生成对应的错误文本
    	switch($code) //判断错误码
		{
			
			case '307':    
				$errorcode = "<span>3</span><span>0</span><span>7</span>";
				$data = "如果您看到此页面，是由于启用了首页模块，但所设置的页面系统未搜索到，如果您是网站管理员请检查所设置页面是否可以访问";
				$title = "";
				break;
			case '301':    
				$errorcode = "<span>3</span><span>0</span><span>1</span>";
				$data = "如果您看到此页面，是由于启用了首页模块，但并未设置相应页面，如果您是网站管理员可到系统设置中进行设置";
				$title = "";
				break;
			case '404':    
				$errorcode = "<span>4</span><span>0</span><span>4</span>";
				$data = "这是系统默认首页，如果您看到此页面说明当前网站服务是正常的，但未设置前端主页！";
				$title = "Page No Found!";
				break;	
		}
		
		$Page = '<!DOCTYPE html><html lang="en"><head><meta name="viewport" content="width=device-width, initial-scale=1" /><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><link href="../css/error.css" rel="stylesheet" type="text/css" media="all" /><body><div class="w3layouts-bg"><h1 class="header-w3ls">Error Page</h1><div class="agileits-content"><h2>' . $errorcode . '</h2></div><div class="w3layouts-right"><div class="w3ls-text"><h3>sorry !</h3><h4 class="w3-agileits2">' . $title . '</h4><p>' . $data . '</p><p class="copyright">'. $this->Info(bottom) . '</p></div></div><div class="clearfix"></div></div></body></html>';
		
		return $Page;
		
	}
		/* ---------------------------------------------------- */
	
		
		//系统错误页生成
	/* ---------------------------------------------------- */	
	
	function Sys_ErrorPage ( $code = 3 ) 
	{
    	// 根据错误码生成对应的错误文本
    	switch($code) //判断错误码
		{
			
			case '503':
				$title = '系统正在维护中！';
				$content = $this->Info('server_infomaction');
				$this -> WriteLog('GET', '访问请求由于 系统维护中 被拦截<br />','error.php');
				break;
			
			case '402':
				$title = '获取歌曲信息失败';
				$content = '歌曲受版权保护，管理员已禁止该歌曲播放与下载功能！';
				break;
		
			case '342':
				$title = '系统数据检查失败';
				$content = '检测到一个或多个核心数据字段丢失，请删除kernl目录下的conf文件，重新安装系统！';
				break;	
		
			case '336:1':
				$title = '操作非法';
				$content = '当前操作不在系统许可范围内，请检查后重试！';
				break;
	
			case '336:2':
				$title = '操作非法';
				$content = 'Session值校验异常，请检查后重试！';
				break;	
		
			case '336:3':
				$title = '操作非法';
				$content = '用户检查失败,系统安装未完成！';
				break;		
		
			case '336:4':
				$title = '路径检查失败';
				$content = '路径检查失败，系统仅支持在一级目录下安装！';
				break;	
		
			case '195':
				$title = '浏览器检查失败！';
				$content = '当前浏览器版本不受支持，请更新浏览器或更换为更安全的Google浏览器';
				break;		
		
			case '330':
				$title = '管理员已禁用留言板';
				$content = '管理员已禁用留言板，如需帮助请与网站管理员联系！&nbsp; &nbsp; <a href="../index.php">返回首页</a>';
				break;			
		
		}
		$time = date("y/m/d H:i:s",time());
		$Page = '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>' . $title . '</title></head><body><div id="main"><header id="header"><h1><span class="sub"> ' . $title . '</span></h1></header><div id="content"><p>[ 错误原因 ] ' . $content . ' <br /> [ 出错时间 ] ' . $time  . ' [ 访问IP ] ' . $_SERVER["REMOTE_ADDR"] . '</p>----------------------------------------------------------------<p class="copyright">'. $this->Info(bottom) . '</p></div></div></html>' ;
		
		return $Page;
		
	}
		/* ---------------------------------------------------- */
		
		//上传大小检查
		/* ---------------------------------------------------- */
		function UploadFrameFix() 
		{
			$UploadFrame = $this->Info('upload_frame');
			if($UploadFrame == NULL ) 
			{
				$sql = "update system_setting set value = 'system;.png*.jpg*.gif;../../images/|module;.zip;../../module/|' where vars = 'upload_frame';";
				if(!$this->query($sql))
				{
					echo 'null';
				}
			} 
		}

	/* ---------------------------------------------------- */

}





?>