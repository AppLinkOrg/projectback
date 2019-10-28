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
//传入primary_id是更新，为空则是新增        //传入primary_id是更新，为空则是新增        //传入primary_id是更新，为空则是新增    //1. （请勿改动的代码）获取数据模型对象    $modelname="dogtest";    $modelmgrpath=USER_ROOT."modelmgr/$modelname.model.php";    $model=new XmlModel($modelname,CURRENT_PATH);    //修正$model的字段默认值，for($model->XmlData["fields"]["field"] as $field)    $request=$_REQUEST;        //2. （请勿改动的代码）获取自动生成的搜索sql语句    $sql=$model->GetSearchSql($request);    //echo $sql;      //$sql=str_replace("select","select distinct",$sql);    $query = $dbmgr->query($sql);    $result = $dbmgr->fetch_array_all($query);         if(count($result)>0){       //echo  $result[0]["content"];        $str='{"a":1,"b":2,"c":3,"d":4,"e":5}';        //outputJSON(json_decode($str,true));         $content=  $result[0]["content"];       // $content='{"master":{"character":"u60a8u662fu6027u683cu6210u719fu3001u7a33u91cdu3001u8c41u8fbeu3001u8c6au723du3001u7cbeu660eu5e72u7ec3u7684u4ebau3002u6709u4e00u79cdu4ee5u4e0du53d8u5e94u4e07u53d8u7684u6de1u5b9auff0cu559cu6b22u5411u56f0u96beu53d1u8d77u6311u6218uff0cu6709u7740u8a93u6b7bu62fcu640fu7684u96c4u5fc3u548cu9738u6c14u3002u60a8u7684u6027u683cu5927u6c14uff0cu9009u62e9u7684u72acu79cdu8f83u4e3au5a07u5c0fuff0cu4e00u5b9au7ec6u5fc3u5173u7231u54e6uff01","time":"u60a8u53efu6295u5165u7167u987eu72acu7684u65f6u95f4u662f0-1u5c0fu65f6uff0cu60a8u9009u62e9u7684u662fu5c0fu578bu72acu3002 u6237u5916u65f6u95f4uff1au5efau8baeu60a8u6bcfu5929u81f3u5c11u5e26u72acu905bu5f2fu4e24u6b21uff0cu6bcfu6b2120u5206u949fu3002 u5ba4u5185u65f6u95f4uff1au5efau8baeu60a8u5ba4u518520u5206u949fu65f6u95f4uff0cu7167u987eu72d7u72d7u996eu98dfu53cau536bu751fuff0cu5e76u4e14u7231u629au60a8u7684u7231u72acu3002","period":"null","baby":"u5efau8baeu60a8u9972u517bu6e29u987auff0cu8f83u4e3au5b89u9759u578bu72acu79cdu3002u8c03u76aeu72acu79cdu5bb9u6613u5728u5b09u620fu4e2du4f24u5230u5b9du5b9duff0cu867du4e0du662fu6545u610fuff0cu4f46u53efu80fdu7531u6b64u5f15u53d1u5bb6u5eadu7684u77dbu76feu3002u5efau8baeu60a8u9972u517bu6e29u987au5ea6u8f83u5f3au7684u72acu79cduff0cu867du7136u53eau8981u662fu72d7u72d7u90fdu4f1au5f88u5fe0u8bdau4e8eu4e3bu4ebauff0cu6bd5u7adfBabyu66f4u91cdu8981uff0cu907fu514du70c8u6027u72acu4f24u5230babyu3002","area":"u60a8u9972u517bu5ba0u7269u73afu5883u8f83u5c0fuff0cu5efau8baeu9972u517bu5c0fu578bu72acu79cdu3002","sunshine":"u60a8u517bu5ba0u9633u5149u6761u4ef6u4e0du5145u8db3uff0cu5efau8baeu60a8u5728u767du5929u591au5e26u5ba0u7269u6237u5916u6d3bu52a8uff0cu4ee5u8865u5145u9633u5149u7167u5c04u3002u786eu4fddu5ba0u7269u5065u5eb7u3002",        //"budget":"u60a8u9009u62e9u5c0fu578bu72acuff0cu5728u5ba0u7269u5582u517bu65b9u9762uff0cu9884u7b97u6349u895fu89c1u8098u5462u3002u5efau8baeu60a8u9002u5f53u7ed9u5ba0u7269u6539u5584u4f19u98dfu5462u3002"}       // ,"dog":[{"breed":"u5df4u54e5","body_type":"u5c0fu578bu72ac","hair":"u77edu6bdb","lively":"u5b89u9759","kindly":"u6e29u987a","combat":"u4f4e","link":"bage","image":"http://pic2.58.com/m58/shaixuan/u5df4u54e5.png"},{"breed":"u51a0u6bdb","body_type":"u5c0fu578bu72ac","hair":"u77edu6bdb","lively":"u5b89u9759","kindly":"u6e29u987a","combat":"u4f4e","link":"guanmaoquan","image":"http://pic2.58.com/m58/shaixuan/u51a0u6bdb.png"}],"noitem":false}';       // $content = trim($content, "\xEF\xBB\xBF");      // $content = str_replace("\r","",$content);      // $content = str_replace("\n","",$content);    //echo   mb_detect_encoding($str,array('GB2312','GBK','UTF-8'));///    //echo $content=mb_convert_encoding($content, 'utf8','gbk');       //$content= preg_replace('/,\s*([\]}])/m', '$1', $content);        //$ret=json_decode($content,true);        //print_r($ret);        // json_last_error_msg();        //outputJSON($ret);        $content=substr($content,1,count($content)-2);        echo $content;        exit;    }    //修正请求的数据    $request=$_REQUEST;//print_r($request);//你可以比较fix前后的区别    $url=$request["url"];    $content=request_get($url);    $content=str_replace("callback(","",$content);    $content=substr($content,0,count($content)-2);        $request=$model->beforeSaveDataFix($request);//print_r($request);//你可以比较fix前后的区别    $request["content"]=$content;    /**************    请在此处编写你对请求值的修正，例如默认值在这里传递    如$request["request_time"]=date('Y-m-d H:i:s');    ****************/    //校验请求的数据正确性    $error=$model->saveValidate($dbmgr,$request);    if($error!=""){        outputJSON(outResult(-1,$error,null));    }    //2. （请勿改动的代码）获取自动生成的搜索sql语句    $return=$dbmgr->begin_trans();    $result=$model->Save($dbmgr,$request);    if(substr($result,0,5)=="right"){        $id=substr($result,5);        /**************        请在此处编写你对在数据保存完成后相关的更新语句        比如：$dbmgr->query("update tb_example set public time=now() where id=$id ");        ****************/        $result=outResult(0,"Save Success",$id);            $dbmgr->commit_trans();    }else{        $result=outResult(-1,"Save fail",$result);            $dbmgr->rollback_trans();    }       $content = str_replace("\r","",$content);       $content = str_replace("\n","",$content);        $ret=json_decode($content,true);        //print_r($ret);        // json_last_error_msg();        $content=json_encode($content);       $dbmgr->query("update tb_dogtest set content='$content' where id=$id");        outputJSON($ret);




?>