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
/**************    请在此处编写请求的数据正确性，请求合法性的判断    比如:    if($_REQUEST["mobile"]=="")//手机号码为空    {        outputJSON(Array());    }        ****************/    //1. （请勿改动的代码）获取数据模型对象    $modelname="postcomment";    $modelmgrpath=USER_ROOT."modelmgr/$modelname.model.php";    $model=new XmlModel($modelname,CURRENT_PATH);        //修正$model的字段默认值，for($model->XmlData["fields"]["field"] as $field)    /**************    请在此处编写你对请求值的修正    如$request["request_time"]=date('Y-m-d H:i:s');    ****************/    $request=$_REQUEST;    $request["orderby"]=" comment_time desc";    $request["status"]="A";        //$member_id=1;        //2. （请勿改动的代码）获取自动生成的搜索sql语句    $sql=$model->GetSearchSql($request);        $sql=str_replace("where","      left join tb_post_comment_like a on r_main.id=a.comment_id and a.member_id=$member_id where",$sql);    $sql=str_replace("select"," select  case  when a.id is null then 'N' else 'Y' end as iliked, ",$sql);        $sql=str_replace("select"," select  ifnull(b.ct,0) as likecount, ",$sql);    $sql=str_replace("where","      left join (select kc.comment_id,count(1) ct from tb_post_comment_like kc group by comment_id) b on r_main.id=b.comment_id  where",$sql);    $sql=str_replace("where"," where r_main.reply_comment_id=0 and ",$sql);    $sql=str_replace("select"," select distinct ",$sql);    //echo $sql;          $query = $dbmgr->query($sql);    $result = $dbmgr->fetch_array_all($query);     /**************    请在此处编写你对最终返回数据的修正    如    ****************/    $sql="select a.*,b.nickName member_nickName,b.avatarUrl member_avatarUrl     ,c.nickName reply_member_nickName,c.avatarUrl reply_member_avatarUrl,    ifnull(d.ct,0) as likecount,case  when e.id is null then 'N' else 'Y' end as iliked    from tb_post_comment a     inner join tb_member b on a.member_id=b.id    inner join tb_member c on a.reply_member_id=c.id      left join (select kc.comment_id,count(1) ct from tb_post_comment_like kc group by comment_id) d on a.id=d.comment_id     left join tb_post_comment_like e on a.id=e.comment_id and e.member_id=$member_id       where a.reply_comment_id>0 and a.post_id= ".($request["post_id"]+0)." order by a.comment_time asc";    $query = $dbmgr->query($sql);    $subcomments = $dbmgr->fetch_array_all($query);     //array_splice    for($i=0;$i<count($result);$i++){        $comment_id=$result[$i]["id"]+0;        $result[$i]["subcomments"]=[];        for($j=0;$j<count($subcomments);$j++){            if($subcomments[$j]["reply_comment_id"]==$comment_id){                $subcomments[$j]["comment_time_formatting"]=date("m/d H:i",strtotime($subcomments[$j]["comment_time"]));                $result[$i]["subcomments"][]=$subcomments[$j];                array_splice($subcomments,$j,1);                $j--;            }        }    }            outputJSON($result);




?>