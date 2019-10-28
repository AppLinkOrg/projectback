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
/**************    请在此处编写请求的数据正确性，请求合法性的判断    比如:    if($_REQUEST["unicode"]=="")//编码    {        outputJSON(Array());    }    ****************/    //1. （请勿改动的代码）获取数据模型对象    $modelname="member";    $modelmgrpath=USER_ROOT."modelmgr/$modelname.model.php";    $model=new XmlModel($modelname,CURRENT_PATH);    //修正$model的字段默认值，for($model->XmlData["fields"]["field"] as $field)    /**************    请在此处编写你对请求值的修正    $unicode=parameter_filter($_REQUEST["unicode"]);    $query=$dbmgr->query("select id from tb_context where unicode='$unicode'");    $result=$dbmgr->fetch_array($query);    $id=$result["id"]+0;    ****************/    $mymember_id=$member_id;    if($_REQUEST["fmember_id"]!=""){        $member_id=$_REQUEST["fmember_id"];    }        //2. （请勿改动的代码）获取生成的sql语句    $sql="select id, nickName,avatarUrl,name,mobile,timesupdated,introduce from ".$model->XmlData["tablename"]." where id=$member_id ";            $query = $dbmgr->query($sql);    $result = $dbmgr->fetch_array($query);    /**************    请在此处编写你对最终返回数据的修正    如    ****************/    $rs=$dbmgr->fetch_array($dbmgr->query("Select count(1) ct from tb_member_friend where follow_member_id=$member_id "));    $result["fanscount"]=$rs["ct"]+0;        $rs=$dbmgr->fetch_array($dbmgr->query("Select count(1) ct from tb_member_friend where member_id=$member_id "));    $result["followcount"]=$rs["ct"]+0;        if($_REQUEST["fmember_id"]!=""){        $result["followedaaa"]=$dbmgr->fetch_array_all($dbmgr->query("Select * from tb_member_friend  "));        $result["followedaaaa"]=" follow_member_id=$member_id and member_id=$mymember_id ";        $result["followed"]=$dbmgr->checkHave("tb_member_friend"," follow_member_id=$member_id and member_id=$mymember_id ");    }        $unreadcount=$dbmgr->fetch_array($dbmgr->query("select count(1) ct from tb_post a     inner join  tb_post_comment b on b.isread='N' and  a.id=b.post_id and b.reply_member_id=0   where a.member_id=$member_id "));    $result["commentunreadcount"]=$unreadcount["ct"]+0;            $unreadcount=$dbmgr->fetch_array($dbmgr->query("select count(1) ct from  tb_post_comment b where b.isread='N' and      b.reply_member_id=$member_id "));    $result["atmeunreadcount"]=$unreadcount["ct"]+0;        $unreadcount=$dbmgr->fetch_array($dbmgr->query("select count(1) ct from tb_post_comment a     inner join  tb_post_comment_like b on b.isread='N' and  a.id=b.comment_id   where a.member_id=$member_id "));    $result["likeunreadcount"]=$unreadcount["ct"]+0;            $unreadcount=$dbmgr->fetch_array($dbmgr->query("select count(1) ct from tb_member_chat    where received_member_id=$member_id and isread='N' "));    $result["chatunreadcount"]=$unreadcount["ct"]+0;            $unreadcount=$dbmgr->fetch_array($dbmgr->query("select count(1) ct from tb_post a    left join tb_post_view b on a.id=b.post_id and b.member_id=$member_id  where b.id is null and a.inst_id=$inst_id and a.status='A' "));    $result["postunreadcount"]=$unreadcount["ct"]+0;            outputJSON($result);




?>