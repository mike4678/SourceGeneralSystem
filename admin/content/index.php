<?php 
error_reporting(0);
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器到播放界面
//处理页码
$PageNum = $dou->AddrConvery($_GET);
if(strstr($PageNum[3], 'id') != "" || is_numeric($PageNum[3]))
{
	$PageCount = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?/'.$PageNum[1].'/'.$PageNum[2];
	} else { 
	$PageCount = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	}

//页码处理完成

switch ($_SERVER['REQUEST_METHOD'])  //获取操作方式
{
	case 'GET':
	
	//判断数组第三个中是否带有id字样，如果没有则判断为页数
	if(count($PageNum) > 3) 
	{
		if(strstr($PageNum[count($addr) - 1], 'id') != "") //如果带有id字样
		{
			$dou->DelData($query,'dd_address','id',str_replace('id','',$PageNum[count($addr) - 1]),'GET');
		}
	} else {
			if(strstr($PageNum[3], 'id') != "") //如果带有id字样
			{
			$dou->DelData($query,'dd_address','id',str_replace('id','',$PageNum[3]),'GET');
			}
		}
		break;

	case 'POST':
	$ID_Dele = implode("','",$_POST['id']);  
	$dou->DelData($query,'dd_address','id',$ID_Dele,'POST'); 
	break;	
}
?>
<script>
function edit(id) { art.dialog.open('content/content_edit.php?code='+id, {title: '修改订单信息',width: 400}); }
function Del(addr) 
{
	art.dialog.confirm('你确定要删除这条消息吗？', function () {
		window.location.href='http://' + window.location.host + addr;
		//art.dialog.content('http://' + window.location.host + addr);// 填充对话框内容
		//art.dialog.open('http://' + window.location.host + addr)
		//myDialog.dialog.close();
    //art.dialog.tips('执行确定操作');
}, function () {
	art.dialog.close();
    art.dialog.tips('操作被用户取消！');
});
}
</script>
<form method="post" action="#">
    <div class="panel admin-panel">
    	<div class="panel-head icon-shopping-cart">&nbsp;<strong>订单列表</strong></div>
        <div class="padding border-bottom">
            <input type="button" class="button button-small checkall" name="checkall" checkfor="id[]" value="全选" />
            <input type="submit" class="button button-small border-yellow" value="批量删除" />
        </div>
        <table class="table table-hover">
        	<tr><th width="45">选择</th><th width="170">订单地址</th><th width="120">购买要求</th><th width="140">提交时间</th><th width="140">订单状态</th><th width="140">快递信息</th><th width="140">操作</th></tr>
             <?php 
$Page_size=10; 

$result=$dou->query('select * from dd_address');
$count = $dou->num_rows($result);
if($count < 1){  //如果获取到的数据小于1，则表示没有数据
	echo '<tr><td>&nbsp;</td><td>&nbsp;&nbsp;没有更多的数据了</td></tr>'; } 
	else { 
$page_count = ceil($count/$Page_size); 

$init=1; 
$page_len=7; 
$max_p=$page_count; 
$pages=$page_count; 

//判断当前页码 
if(empty($addr[3]) || $addr[3] < 0){ 
$page = 1; 
}else { 
$page = $addr[3]; 
} 

$offset=$Page_size*($page-1); 
$sql="select * from dd_address limit $offset,$Page_size"; 
$result=$dou->query($sql); 
while ($row=$dou->fetch_array($result)) { 
?>
          <tr><td><input type="checkbox" name="id[]" value=<?php echo $row['querycode']; ?>></td><td><a class="button border-green button-little" href="<?php echo $row['address']; ?>" target="_blank">点击打开网址</a>&nbsp;<a class="button border-red button-little"><?php echo Analyse(get_domain($row['address'])); ?></a></td><td><?php echo $row['requires']; ?></td><td><?php echo $row['gettime']; ?></td><td><?php echo $row['status']; ?></td><td><?php echo $row['code']; ?></td><td><a class='button border-green button-little' href="javascript:edit('<?php echo $row['querycode']; ?>')">更改状态</a>&nbsp;<a class="button border-yellow button-little" href="del.php?code=<?php echo $row['querycode']; ?>&d=content" onclick="{if(confirm('是否要删除该订单?')){return ture;}return false;}">删除</a><a class='button border-yellow button-little' href='#' onclick="javascript:Del('$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]/id{id} ')">删除</a></td></tr>  
          <?php  
}		
$page_len = ($page_len%2)?$page_len:$pagelen+1;//页码个数 
$pageoffset = ($page_len-1)/2;//页码个数左右偏移量 
$key='<ul class="pagination">';  
if($page!=1){ 
$key.="<li><a href=\"".$PageCount."/".($page-1)."\">上一页</a></li></ul>"; 
$key.=' <ul class="pagination pagination-group">';//上一页 
}else { 
//$key.="第一页 ";//第一页 
$key.='<ul class="pagination"><li><a>上一页</a></li></ul>'; //上一页 
} 
if($pages>$page_len){ 
//如果当前页小于等于左偏移 
if($page<=$pageoffset){ 
$init=1; 
$max_p = $page_len; 
}else{//如果当前页大于左偏移 
//如果当前页码右偏移超出最大分页数 
if($page+$pageoffset>=$pages+1){ 
$init = $pages-$page_len+1; 
}else{ 
//左右偏移都存在时的计算 
$init = $page-$pageoffset; 
$max_p = $page+$pageoffset; 
} 
} 
} 
for($i=$init;$i<=$max_p;$i++){ 
if($i==$page){ 
$key.=' <li class="active"><a>'.$i.'</a></li>';  
} else { 
$key.="<li><a href=\"".$PageCount."/".$i."\">".$i."</a></li>"; 
} 
} 
if($page!=$pages){ 
$key.='</ul><ul class="pagination">'; 
$key.="&nbsp;<li><a href=\"".$PageCount."/".($page+1)."\">下一页</a></li>";//下一页 
}else { 
$key.='</ul><ul class="pagination">&nbsp;<li><a>下一页 </a></li></ul>';//下一页  
} 
$key.='</div>'; 
}
?>
        </table>
        <div class="panel-foot text-center">
            <?php echo $key; ?>
        </div>
    </div>
    </form>
