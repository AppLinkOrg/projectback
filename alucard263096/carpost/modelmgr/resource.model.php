<?php
if($CONFIG['fileupload']['oss']==true){
	require ROOT.'/classes/obj/ossupload.php';
}else{
	require ROOT.'/classes/obj/upload.php';
}


function GrabImage($url, $filename = "") {
	 
	 ob_start();//打开输出
	 readfile($url);//输出图片文件
	 $img = ob_get_contents();//得到浏览器输出
	 ob_end_clean();//清除输出并关闭
	 $size = strlen($img);//得到图片大小
	 $fp2 = @fopen($filename, "a");
	 fwrite($fp2, $img);//向当前目录写入图片文件，并重新命名
	 fclose($fp2);
	 return $filename;//返回新的文件名
	}


class resourceXmlModel extends XmlModel
{
  
  //模型数据
  //public $XmlData;
  
  //构造函数完成
  public function fixModelData($xmldata){
	parent::fixModelData($xmldata);
  }
  
  
  //重新修改传入的请求
  public function resetRequestData($dbMgr,$request){
    
    return $request;
  }
  
  //每次调用显示列表界面
  public function fixShowList($data){
	  return $data;
  }
  
  //列表界面点击搜索之后，重置sql语句
  public function fixListSearchSql($sql){
	  return $sql;
  }
  
  //运行搜索的sql语句之后，再手动加工显示的结果
  public function fixListSearchResult($result){
	  return $result;
  }
  
  //模型显示为子集数据时使用的搜索结果
  public function fixGridSearchSql($sql){
	  return $sql;
  }
  
  //模型显示为子集数据时，再手动加工显示的结果
  public function fixGridSearchResult($result){
	  return $result;
  }
  
  //重写打开编辑界面时的id
  public function fixEditId($id){
  	return $id;
  }
  
  //重写打开编辑时候加载的数据sql
  public function fixEditSql($sql){
  	return $sql;
  }
  
  //重写打开编辑时候加载的数据结果
  public function fixEditData($result){
  	return $result;
  }
  
  //保存前的数据验证
  public function saveValidate($dbmgr,$request){
	  $error=parent::saveValidate($dbmgr,$request);
	  if(MODULE=="api"){
		  //api调用保存
	  }else{
		  //admin后台调用保存
	  }
	  return $error;
  }
  
  //新增的insert语句的重写
  public function fixInsertSql($sql){
  	return $sql;
  }
  
  //保存的update语句的重写
  public function fixUpdateSql($sql){
  	return $sql;
  }
  
  //保存成功时做的事情
  public function afterSave($dbmgr,$id){
	 Global $CONFIG;
	  
  	if(MODULE=="api"){
		  //api调用保存
	}else{
		  //admin后台调用保存
		  $filename=parameter_filter($_REQUEST["filename"]);
		  $url=parameter_filter($_REQUEST["url"]);
		  $module="resource";
		  if($CONFIG['fileupload']['oss']==true){
			 $filealiurl=$CONFIG['fileupload']['upload_path']."/".USER_PATH2."$module/$url";
			 GrabImage($filealiurl, USER_ROOT."logs/".$filename);
			 $file["name"]=$filename;
			 $file["tmp_name"]=USER_ROOT."logs/".$filename;
			 $file=new OssUpload($file,$filename,USER_PATH2."$module/",false);
			 $file->safetyUpload();
		 }else{
			 
			 $folder=USER_ROOT.$CONFIG['fileupload']['upload_path']."/$module/";
			 $filefullname=$folder.$url;
			 rename($folder.$url,$folder.$filename);
		 }
		  
		  
		  
		  $sql="update tb_resource set url='$filename' where id=$id ";
		  $dbmgr->query($sql);
	}
  }
  
  //单数据模式的id
  public function GetNoListId(){
  	return 0;
  }
  
  //导入数据的修正
  public function fixImportDataCheck($dataarr,$dbmgr){
  	return $dataarr;
  }
  
  //删除的id数组
  public function deleteId($id_array){
  	return $id_array;
  }
  
  //删除之前的校验
  public function deleteVaild($id_array,$dbmgr){
  	return "";
  }
  //删除之后的更新
  public function afterDelete($id_array,$dbmgr){
  	
  }

  //请求列表前的数据过滤
 public function fixApiListRequest($dbMgr,$request){
  return $request;
 }
  
  //修正api请求list时候的sql
 public function fixApiListSql($sql){
 	return $sql;
 }
 //修正api请求list时候的sql搜索的结果
 public function fixApiListResult($result){
 	return $result;
 }
 
  //修正api请求get时候请求的id
  public function fixApiGetId($id){
  	return $id;
  }
 
  //修正api请求get时候请求的sql
  public function fixApiGetSql($sql){
  	return $sql;
  }
  
  //修正api请求get时候请求的sql的数据结果
  public function fixApiGetData($result){
  	return $result;
  }

}

?>