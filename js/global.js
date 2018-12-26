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

//后台消息框函数
//type 类型 : 1.信息框 2.网页框
//data 内容 : 信息框对应弹出内容，网页框则为网址
//control 控制方式，type为1生效
//title 标题
//height 高度
//weight 宽度
function SystemBox(type,data,icon,title,height,width) 
{
	if(type == 1)
		{
			
			var dialog = art.dialog({
									title: title,
    								content: data,
									icon: icon,
									});
			
		} else {
			
			art.dialog.open(data, {title: title, width: width, height: height})
		}
}