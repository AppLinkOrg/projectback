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
//传入primary_id是更新，为空则是新增        //传入primary_id是更新，为空则是新增        //传入primary_id是更新，为空则是新增    //1. （请勿改动的代码）获取数据模型对象    $modelname="memberfriend";    $modelmgrpath=USER_ROOT."modelmgr/$modelname.model.php";    $model=new XmlModel($modelname,CURRENT_PATH);    //修正$model的字段默认值，for($model->XmlData["fields"]["field"] as $field)    //修正请求的数据    $request=$_REQUEST;//print_r($request);//你可以比较fix前后的区别    $request=$model->beforeSaveDataFix($request);//print_r($request);//你可以比较fix前后的区别    $follow_member_id=$_REQUEST["follow_member_id"]+0;    $memberfriend=$dbmgr->fetch_array( $dbmgr->query("select * from tb_member_friend where follow_member_id=$follow_member_id and member_id=$member_id"));    if($memberfriend["id"]!=""){        $result=outResult(0,"Save Success",$id);          outputJSON($result);    }    $request["member_id"]=$member_id+0;    $request["follow_time"]=date("Y-m-d H:i:s");    /**************    请在此处编写你对请求值的修正，例如默认值在这里传递    如$request["request_time"]=date('Y-m-d H:i:s');    ****************/    //校验请求的数据正确性    $error=$model->saveValidate($dbmgr,$request);    if($error!=""){        outputJSON(outResult(-1,$error,null));    }    //2. （请勿改动的代码）获取自动生成的搜索sql语句    $return=$dbmgr->begin_trans();    $result=$model->Save($dbmgr,$request);    if(substr($result,0,5)=="right"){        $id=substr($result,5);        /**************        请在此处编写你对在数据保存完成后相关的更新语句        比如：$dbmgr->query("update tb_example set public time=now() where id=$id ");        ****************/        $result=outResult(0,"Save Success",$id);            $dbmgr->commit_trans();    }else{        $result=outResult(-1,"Save fail",$result);            $dbmgr->rollback_trans();    }    outputJSON($result);




?>