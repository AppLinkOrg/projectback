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
$poster_id=$_REQUEST["post_id"]+0;$result=$dbmgr->fetch_array($dbmgr->query("select * from tb_post where id=$poster_id "));if($result["id"]==""){   outputJson(outResult(0,"SUCCESS",$filename));}$images=explode(",",$result["images"]);$cover=$images[0];$cover=$CONFIG['fileupload']['upload_path']."/alucard263096/petfind/post/$cover";$title=$result["title"];$address=$result["address"];$qrcode="http://cmsdev.app-link.org/alucard263096/petfind/api/post/qrcode?a=1&id=".$poster_id;$backgroundphoto=USER_ROOT."common/poster.png";$folder=USER_ROOT."/upload/post/";$filename=$folder.$poster_id.".png";if(file_exists($filename)){    //unlink($filename);   outputJson(outResult(0,"SUCCESS",$filename));}$qrcode=downloadImage($qrcode);$photosize=getimagesize($qrcode);$qrcode_w=$photosize[0];$qrcode_h=$photosize[1];//$membercover=createRound($membercover);$qrcode = imagecreatefromstring(file_get_contents($qrcode));imagecopyresized($dst, $qrcode, 55, 580 ,0 ,0, 130, 130 , $qrcode_w, $qrcode_h);imagesavealpha($dst, true);imagepng($dst,$filename);//imagepng($dst);imagedestroy($dst);outputJson(outResult(0,"SUCCESS",$filename));//imagefttext($dst, 20, 0, 210, 380, $yello, $font, $shortname."正在砍价");function downloadImage($url){    $d="ymdhis";    $filename=USER_ROOT.'/logs/'.md5($url).".png";    if(!file_exists($filename)){        $image = file_get_contents($url);         file_put_contents($filename, $image);    }    return $filename;}function outputPhoto($filename){    header("Content-type: octet/stream");    header("Content-disposition:attachment;filename=".md5($filename).".png;");    header("Content-Length:".filesize($filename));    readfile($filename);            exit;    }




?>