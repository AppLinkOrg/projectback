<?php

/**************
#以下是常用的代码，请注意以下几点
#1、请不要在本页面中出现html的代码，否则你自己负责了
#2、最后面输出一定要outputJSON代码，否则输出的页面json为空。
#3、一般来说，这里用的是数据库对象最多，因此请看熟悉以下的代码
#4、一般都是以一种输出为准，否则你自己的代码会变得难以请求和代码复杂。不要走太多分之有多种请求。
#5、要写公用类或者公用的引用，请在上层的common文件夹或者datamgr文件夹中添加代码，在这个文件中引用


$dbmgr;//数据库请求对象
$sql="select now()";
$query=$dbmgr->query($sql);//提交一个请求
$result=$dbmgr->fetch_array($query);//返回一行数据
$result=$dbmgr->fetch_array_all($query);//返回多行数据
$dbmgr->begin_trans();//启动数据库事务
$dbmgr->commit_trans();//提交数据库事务
$dbmgr->rollback_trans();//回滚数据库事务，一般不写这个也可以，反正SQL语句错误就自动回滚

#其它常用的数据库方法
$dbmgr->checkHave("表名","where 条件")；//检查是否存在某一条数据
$dbmgr->getNewId("表名");//获取新的ID，表必须有id字段

#其它常用方法
$str=parameter_filter($_str);//将内容进行过滤
outputJson($array);//数组转json并输出
outResult($code,$result,$return);//标准数组结果输出，$code=标识码，$result=结果文字描述，$return=结果内容


logger_mgr::logError("错误日志");
logger_mgr::logInfo("常用信息日志");
logger_mgr::logDebug("Debug日志");


#其它常用常量
USER_ROOT    //用户目录根目录



写完这个请一定登录应用管理在接口中点击保存XML，最好能够去进行测试！
写完这个请一定登录应用管理在接口中点击保存XML，最好能够去进行测试！
写完这个请一定登录应用管理在接口中点击保存XML，最好能够去进行测试！
写完这个请一定登录应用管理在接口中点击保存XML，最好能够去进行测试！
写完这个请一定登录应用管理在接口中点击保存XML，最好能够去进行测试！
写完这个请一定登录应用管理在接口中点击保存XML，最好能够去进行测试！



***************/
////以下是代码开始，请勿删除此行注释
////starthere
logger_mgr::logInfo("wechat/decrypteddata：".json_encode($_REQUEST));//$_REQUEST=json_decode('{"errMsg":"getShareInfo:ok","iv":"UrXx9eOzR+1LF9WKYCY1vA==","encryptedData":"sP+dPqTuEgmU1mOIpapSoIfFWFIechNTu3T7bNgSX5j3TVGQfUTgiOAB1fvbBiSUfBr4ENUEIFXkmfupboqpzJGuSOCQdNdgXUO1pPg2yoTnNjccibI+fOXQiXoOEOebZ5mjOu7460\/i+WNTKu2SSA=="}',true);$iv = $_REQUEST["iv"];$encryptedData=$_REQUEST["encryptedData"];$appid=$inst["appid"];$appsecret=$inst["appsecret"];if($_REQUEST["code"]!=""){    $code=$_REQUEST["code"];$grant_type=$_REQUEST["grant_type"];$url="https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$appsecret&js_code=$code&grant_type=$grant_type";$authinfo=request_get($url);$member=json_decode($authinfo,true);$openid=$member["openid"];$session_key=$member["session_key"];$member=$dbmgr->fetch_array($dbmgr->query("select * from tb_member where openid='$openid'"));if($member["id"]==""){    $sql="insert into tb_member (id,openid,session_key) values select ifnull(max(id),1),'$openid','$session_key' from tb_member ";}else{    $sql="update tb_member set  openid='$openid', session_key='$session_key' where id=".$member["id"];}$dbmgr->query($sql);}$sessionKey=$member["session_key"];include_once USER_ROOT."common/wxBizDataCrypt.php";$pc = new WXBizDataCrypt($appid, $sessionKey);$errCode = $pc->decryptData($encryptedData, $iv, $data );//$data=[];$data=json_decode($data,true);if ($errCode == 0) {$data["openid"]=$member["openid"];$data["session_key"]=$member["session_key"];    outputJSON(outResult(0,"success",$data));} else {    outputJSON(outResult($errCode,$errCode,$data));}




?>