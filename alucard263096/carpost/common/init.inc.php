<?php
/********
类似与API接口相关函数，这里是一个调用API的综合入口，你可以在这里做一些代码预处理，只要这个文件存在，那么每次调用API必然会先调用这个文件

但是，
但是，
但是，我们只建议你在这个文件中做一个include文件的总入口，不要在这里写太多的业务逻辑。
比如下面这样
if(MODEL=="member"){
	include USER_ROOT."common/member.inc.php";
}
或者
if(in_array(MODEL,array("member","book","city")){
	include USER_ROOT."common/member.inc.php";
}

有一些相关的常量，你一定用得上

USER_ROOT   当前应用项目路径 echo USER_ROOT; 你就知道~~
MODEL       当前使用的API模型，还记得自定义API时候的某个参数吗？ echo MODEL;
FUNC        当前使用的API模型的方法，也在自定义API时候的某个参数，echo FUNC;

其它不够的函数请去找API随便一个文件看看吧。

另外，因为系统是开放的，所以对于header我们用了以下
    header('Access-Control-Allow-Origin:*');  
    header('Access-Control-Allow-Methods:POST');  
    header('Access-Control-Allow-Headers:x-requested-with,content-type,TokenKey,Sign,Fmd5str,lang');  
	
因此，你也可以在这个文件中定义你的自己的访问限制或者其它需要cache的等等。


*********/
//那么，请开始你的表演

function getOrderNo($type,$nocount=4){
	Global $dbmgr;
	$date=date('Ymd');
	
	
	$sql="select ifnull(no,0) no from tb_order_perfix where type='$type' and uniq='$date' ";
	$query=$dbmgr->query($sql);
	$ret=$dbmgr->fetch_array($query);
	
	$no=$ret["no"];
	$new=$no+1;
	if($no>0){
		$dbmgr->query("update tb_order_perfix set no=$new where  type='$type' and uniq='$date' ");
	}else{
		$dbmgr->query("insert into tb_order_perfix (id,type,uniq,no) select ifnull(max(id),0)+1,'$type','$date','$new' from tb_order_perfix ");
	}
	
	while(strlen($new)<$nocount){
		$new="0".$new;
	}
	
	return $type.$date.$new;
}

$member_id=-1;
if($_SERVER["HTTP_TOKEN"]!=""){
	$openid=parameter_filter($_SERVER["HTTP_TOKEN"]);
	$query=$dbmgr->query("select id from tb_member where  openid='$openid' ");
	$result=$dbmgr->fetch_array($query);
	$member_id=$result["id"]+0;
}
if($_REQUEST["member_id"]!=""){
	$member_id=$_REQUEST["member_id"]+0;
}
if($member_id==0){
	$member_id=-1;
}else{
$query=$dbmgr->query("select * from tb_member where id=$member_id ");
$member=$dbmgr->fetch_array($query);
}

$inst_id=$inst["id"]+0;
$inst_id=$inst_id>0?$inst_id:-1;


$inst_id=-1;
$unicode="";
if($_SERVER["HTTP_UNICODE"]!=""){
	$unicode=parameter_filter($_SERVER["HTTP_UNICODE"]);
}
if($_REQUEST["unicode"]!=""){
	$unicode=parameter_filter($_REQUEST["unicode"]);
}

$query=$dbmgr->query("select * from tb_inst where unicode='$unicode' and status='A' ");
$inst=$dbmgr->fetch_array($query);
$inst_id=$inst["id"]+0;
$inst_id=$inst_id>0?$inst_id:-1;


?>