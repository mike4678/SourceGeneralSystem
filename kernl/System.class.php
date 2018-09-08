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
						
					} else {
						if($table == 'music_list') 
						{
							$music_info = $this->Load_MusicInfo($term);
							if(!unlink("../".$music_info[3])) 
							{
								echo '<script language="JavaScript">window.alert("文件删除失败！")</script>';
							}
						}	
						
						$sql = "delete from ".$table." where ".$hterm." = '" .$term. "';";
						if (!$this->query($sql)) 
						{
   							echo '<script language="JavaScript">window.alert("删除失败！")</script>';
     					}
					}
    				echo '<script language="JavaScript">window.alert("删除成功！")</script>';
    				echo '<script language="JavaScript">self.location=document.referrer;</script>'; 
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
			$query = $this->select_all('table_list'); //顶部标题部分
			$infor = array(); 
			
			while (	$row = $this->fetch_array($query))   
			{
				
				if($table == $row[0]) {	
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
		if($File_size > $PHP_Size) 
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
			header("Location: kernl/error.php?code=503"); //重定向浏览器
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
		$opts = array(
			'http'=>array(
			'method'=>"GET",
			'timeout'=>600,
			)
		);
		$context = stream_context_create($opts);
		
		$url = 'http://service.csource.com.cn/update/check.php?product=music'; 
		$html = file_get_contents($url,false, $context); 
		$str = strtr($html, "\t", ' ');
		$encode = mb_detect_encoding($str, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
		if($encode != "UTF-8")
		{
  			$str = iconv("GBK","UTF-8",$str);
		}
		$return_data = json_decode($str,true);
		echo '<a href="javascript:info(\'http://service.csource.com.cn/update/update.php?product=music\')" >'.$return_data['version'].'</a>'; 

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
	
	
		
		//获取域名中间部分
	/* ---------------------------------------------------- */

	function Get_domain($url)  
	{  
		$pattern = "/[\/w-]+\/.(com|net|org|gov|biz|com.tw|com.hk|com.ru|net.tw|net.hk|net.ru|info|cn|com.cn|net.cn|org.cn|gov.cn|mobi|name|sh|ac|la|travel|tm|us|cc|tv|jobs|asia|hn|lc|hk|bz|com.hk|ws|tel|io|tw|ac.cn|bj.cn|sh.cn|tj.cn|cq.cn|he.cn|sx.cn|nm.cn|ln.cn|jl.cn|hl.cn|js.cn|zj.cn|ah.cn|fj.cn|jx.cn|sd.cn|ha.cn|hb.cn|hn.cn|gd.cn|gx.cn|hi.cn|sc.cn|gz.cn|yn.cn|xz.cn|sn.cn|gs.cn|qh.cn|nx.cn|xj.cn|tw.cn|hk.cn|mo.cn|org.hk|is|edu|mil|au|jp|int|kr|de|vc|ag|in|me|edu.cn|co.kr|gd|vg|co.uk|be|sg|it|ro|com.mo)(\/.(cn|hk))*/";  
		preg_match($pattern, $url, $matches);  
		if(count($matches) > 0)  
		{  
			return $matches[0];  
		}else {  
			$rs = parse_url($url);  
			$main_url = $rs["host"];  
			if(!strcmp(long2ip(sprintf("%u",ip2long($main_url))),$main_url))  
			{  
				return $main_url;  
			}else {  
				$arr = explode(".",$main_url);  
				$count = count($arr);  
				$endArr = array("com","net","org");//com.cn net.cn 等情况  
				if (in_array($arr[$count-2],$endArr))  
				{  
					$domain = $arr[$count-3].".".$arr[$count-2].".".$arr[$count-1];  
				}else {  
					$domain = $arr[$count-2].".".$arr[$count-1];  
				}  
				return $domain;  
			}  
		}  
	}  
	/* ---------------------------------------------------- */
		
	
		
		//订单识别
	/* ---------------------------------------------------- */
	
	function Analyse($data)
	{
		$temp = explode(".",$data);
		$query = $this -> query("select * from dd_sell where identifier = '$temp[0]'");	
		if( $this -> affected_rows() == NULL ) 
		{
			return $temp[0];
		} else {
			$row = $this->fetch_array($query); 
			return $row[0];
		}
		
	}
	/* ---------------------------------------------------- */
		
		
		//订单商家信息读取
	/* ---------------------------------------------------- */
	
	function Sell()
	{
		$query = $this -> query("select * from dd_sell");	
		if( $this -> affected_rows() == NULL ) 
		{
			return null;
		} else {
			$row = $this->fetch_array_all("dd_sell"); 
			return $row;
		}
		
	}
	/* ---------------------------------------------------- */
		
		
		//随机字符生成
	/* ---------------------------------------------------- */	
	
	function generate_password( $length = 8 ) {
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
}



?>