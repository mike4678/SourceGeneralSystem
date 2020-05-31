<?php 

$_G['SYSTEM']['PATH'] = str_replace(strtolower('admin/login.php'), '', str_replace('\\', '/', strtolower(__FILE__)));
require($_G['SYSTEM']['PATH'] . "kernl/Init.php"); //初始化基础参数

//判断之前的登陆状态
$state = $dou -> AccountState();
if ($state != 'Access denied') 
{
	header("Location: admin.php"); //重定向浏览器到播放界面
}

//基础网页内容
$var = '<div class="login_m">
			<div class="login_padding login_title">
	  			<div align="center"><strong>'.$dou -> Info('corp').'中央认证系统</strong></div>
			</div>
			<div id="login_boder" class="login_boder">
				<div class="login_padding">
					<label>
						<h2>用户名</h2>
						<input type="hidden" id="return" name="return" value="'.$_GET['ref'].'">
						<input type="text" id="username" name="username" class="txt_input txt_input2" >
					</label>
					<label>
						<h2>密码</h2>
						<input type="password" name="password" id="password" class="txt_input" >
					</label>
					<label id=\'code\'>
						<h2>验证码</h2>
						<input type="text" id="vaildcode" name="vaildcode" class="txt_input txt_input2" style=\'width: 235px; height: 38px;\'>
						<img src = \'code.php\' id=\'showcode\' onclick=\'GetCode();\' style=\'top: -5px;\'>
					</label>
					<p class="forgot"></p>
					<div id="rem_sub" class="rem_sub" style=\'margin-top: -10px;\'>
						<div class="rem_sub_l">
							<input type="checkbox" name="save_me" id="save_me">
							<label for="checkbox">记住登陆信息</label>
						</div>
						<label>
							<input type="submit" class="sub_button" name="button" id="button" value="登录" style="opacity: 0.7;">
						</label>
					</form>
					</div>
				</div>
			</div>
		</div>
		<div id=\'corp\' align="center"><strong>'.$dou -> Info('bottom').'</strong></div>';
	

//判断登陆失败次数，后台增加设置尝试次数，超过则跳转到错误页，超过3次则加载验证码
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php $dou -> Info('corp'); ?>后台管理系统</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script src="../js/global.js"></script>
<script src="../js/jquery-1.8.3.min.js"></script>
<script src="../js/artDialog.js?skin=default"></script>	
<script src="../js/iframeTools.js"></script>	
</head>
<body class="login">
<?php echo $var; ?>
<script>
eval(function(p,a,c,k,e,r){e=function(c){return c.toString(36)};if('0'.replace(0,e)==0){while(c--)r[e(c)]=k[c];k=[function(e){return r[e]||e}];e=function(){return'[124-9a-df-t]'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('$("#login_boder").bind("keydown",5(e){1 6=e||h.c;1 2=6.keyCode||6.which||6.charCode;4(2==13){$(".i").j()}});$(5(){$(".i").on(\'j\',5(c){c.preventDefault();1 d=$(\'#k\').7();1 f=$(\'#l\').7();1 2=$(\'#vaildcode\').7();1 m=$(\'#save_me\').prop(\'checked\');1 n=$(\'#8\').7();4(d==\'\'){9(3,\'错误：用户名不能为空！\');a();8 g}4(f==\'\'){9(3,\'错误：密码不能为空！\');a();8 g}4(Vaild==true){4(2==\'\'){9(3,\'错误：验证码不能为空！\');a();8 g}}$.ajax({url:\'login_check.o\',type:\'POST\',dataType:\'json\',data:{k:d,l:f,2:2,save:m},beforeSend:5(){$(\'#p\').q("r",\'正在登录...\')},success:5(b){1 errcode=b.s;1 t=b.message;4(b.s==0){h.location.href="admin.o?"+n}else{9(3,t);a();$(\'#p\').q("r",\'登录\')}}})})});',[],30,'|var|code||if|function|theEvent|val|return|SystemBox|GetCode|res|event|user||pass|false|window|sub_button|click|username|password|saveme|ref|php|button|attr|value|status|errmessage'.split('|'),0,{}))	
</script>	
</body>
</html>
<?php 
//判断验证码是否启用
if ($dou -> Info('VaildCode') == 0) 
{
	echo "<script>var Vaild = true;javascript:LoginStatus(2);</script>";
} else {
	echo "<script>var Vaild = false;javascript:LoginStatus(1);</script>";
}

//if($_COOKIE["SourceTryCount"] == 0 || $_COOKIE["SourceTryCount"] <= 3 )
//{
	//echo "<script>javascript:LoginStatus(1);</script>";
//} else {
	//echo "<script>javascript:LoginStatus(2);</script>";
//}
?>
