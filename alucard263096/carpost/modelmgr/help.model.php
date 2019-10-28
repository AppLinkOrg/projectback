<?php
                      
class helpXmlModel extends XmlModel
{
  
  //模型数据
  //public $XmlData;
  
  //构造函数完成
  public function fixModelData($xmldata){
	parent::fixModelData($xmldata);
  }
  
  
  //重新修改传入的请求
  public function resetRequestData($dbMgr,$request){
    if(MODULE=="api"){
		  //api调用保存
		  if(FUNC=="update"){
			$request["status"]="A";
			$request["published_date"]=date("Y:m:d H:i:s");
			  
			$request["upcount"]=0;
			  
			$member_id=updateMember($_REQUEST["openid"],$_REQUEST["nickName"],$_REQUEST["avatarUrl"],$_REQUEST["gender"],$_REQUEST["province"],$_REQUEST["city"],$_REQUEST["country"]);
			$request["member_id"]=$member_id;
		  }
	  }
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
  	if(MODULE=="api"){
		//api调用保存
		$photos=$_REQUEST["photos"];
		//outputJSON($photos);
		if(trim($photos)==""){
			return;
		}
		
		$photos=explode(",",$photos);
		$photo_id=$dbmgr->getNewId("tb_helpphoto");
		foreach($photos as $photo){
			$photo_id++;
			$photo=parameter_filter($photo);
			if($photo!=""){
				$sql="insert into tb_helpphoto (id,help_id,photo) values ($photo_id,$id,'$photo')";
				$dbmgr->query($sql);
			}
		}
	}else{
		  //admin后台调用保存
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
	 $lat=$_REQUEST["lat"]+0;
	 $lng=$_REQUEST["lng"]+0;
	 $sql=str_replace( "select","select   ((lat-$lat)*(lat-$lat)+(lng-$lng)*(lng-$lng)) as distance,",$sql);
	 $sql=str_replace( "order by r_main.updated_date desc"," and TIMESTAMPDIFF(HOUR,published_date,now())+ifnull(upcount,0)<=24  order by distance limit 0,100",$sql);
	 
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