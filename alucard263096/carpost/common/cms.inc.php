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
/********
$sysuser=getCMSSession("SysUser");
if($sysuser["righttype"]=="OD"){
	//print_r($MenuArray);
	$m=array();
	$m["mainmenus"]["mainmenu"]=array();
	for($i=0;$i<count($MenuArray["mainmenus"]["mainmenu"]);$i++){
		//echo $MenuArray["mainmenus"]["mainmenu"][$i]["module"];
		if($MenuArray["mainmenus"]["mainmenu"][$i]["module"]=="salesmgr"){
			$m["mainmenus"]["mainmenu"][]=$MenuArray["mainmenus"]["mainmenu"][$i];
		}
	}
	$MenuArray=$m;
}else{
	$m=array();
	$m["mainmenus"]["mainmenu"]=array();
	for($i=0;$i<count($MenuArray["mainmenus"]["mainmenu"]);$i++){
		//echo $MenuArray["mainmenus"]["mainmenu"][$i]["module"];
		if($MenuArray["mainmenus"]["mainmenu"][$i]["module"]!="salesmgr"){
			$m["mainmenus"]["mainmenu"][]=$MenuArray["mainmenus"]["mainmenu"][$i];
		}
	}
	$MenuArray=$m;
}

$smarty->assign("SystemMenu",$MenuArray);
*********/


if(!empty($model)){
$sysuser=getCMSSession("SysUser");
$inst_id=$sysuser["inst_id"]+0;
$requestinst_id=$_REQUEST["inst_id"]+0;
$action=$_REQUEST["action"];
if($action==""){
	$clinic=$model->getModelField("inst_id");
	if($inst_id>0&&$inst_id!=$requestinst_id){
		$inst["hidden"]=1;
		$inst["displayinlist"]=0;
		$inst["value"]=$inst_id;
		$model->setModelField("inst_id",$clinic);
		
		
	}
}
if($action=="search"){
	$clinic=$model->getModelField("inst_id");
	if($inst_id>0&&$inst_id!=$requestinst_id){
		$_REQUEST["inst_id"]=$inst_id;
	}
}
if($action=="save"){
	if($inst_id>0&&$requestinst_id>0&&$inst_id!=$requestinst_id){
		die("本数据不属于该机构，无法进行操作 ");
	}
}
if($action=="edit"){
	$clinic=$model->getModelField("inst_id");
	if($inst_id>0&&$clinic!=null){
		//$sql=str_replace("where"," where inst_id=$inst_id and ",$sql);
		$model->XmlData["searchcondition"]=empty($model->XmlData["searchcondition"])?" r_main.inst_id=$inst_id ":$model->XmlData["searchcondition"]." and r_main.inst_id=$inst_id";
		
	}
}
}
?>