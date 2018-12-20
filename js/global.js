/*!
 * Source Global Function
 * Date: 2019-01-01
 * 
 * (c) 2009-2029 Source, http://bbs.csource.com.cn
 *
 */

// 后台登陆界面核心处理函数
function LoginStatus(value)
{
	if(value == 1) //Normal
	{
		document.getElementById("code").style='display:none;';
		document.getElementById("login_boder").style.backgroundImage="url(../images/login_m_bg.png)";
		document.getElementById("login_boder").style.height='302px';
		document.getElementById("rem_sub").style='margin-top: 0px;';
		document.getElementById("corp").style='margin-top: 0px;';
		console.log('set success');
		
	} else if(value == 2) {
		
		document.getElementById("code").style='';
		document.getElementById("login_boder").style.backgroundImage="url(../images/logincode_m_bg.png)";
		document.getElementById("login_boder").style.height='350px';
		document.getElementById("rem_sub").style='margin-top: -10px;';
		document.getElementById("corp").style='margin-top: 60px;';
		console.log('setting success');
	}
	
}
	
function GetCode() 
{
	var obj=document.getElementById("showcode");
	obj.src="../admin/code.php?"+ Math.random();
}	