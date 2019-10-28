<?php
                      
class userroleXmlModel extends XmlModel
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



  Global $MenuArray;

	for($o=0;$o<count($result);$o++){
	
		$right=($result[$o]["accessright"]);
		$right=json_decode(htmlspecialchars_decode( $right),true);

		$str="";
		for($i=0;$i<count($MenuArray["mainmenus"]["mainmenu"]);$i++){
			for($j=0;$j<count($MenuArray["mainmenus"]["mainmenu"][$i]["submenus"]["submenu"]);$j++){
				 $val=$MenuArray["mainmenus"]["mainmenu"][$i]["module"]."_".$MenuArray["mainmenus"]["mainmenu"][$i]["submenus"]["submenu"][$j]["model"];
				if(in_array($val,$right)){
					 $MenuArray["mainmenus"]["mainmenu"][$i]["submenus"]["submenu"][$j]["right"]="1";
					 $str.="<p>".$MenuArray["mainmenus"]["mainmenu"][$i]["name"]."|".$MenuArray["mainmenus"]["mainmenu"][$i]["submenus"]["submenu"][$j]["name"]."<p/>";
				}else{
					 $MenuArray["mainmenus"]["mainmenu"][$i]["submenus"]["submenu"][$j]["right"]="0";
				}
			}
		}
		$result[$o]["accessright"]=$str;
	}
	

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
	Global $MenuArray;
	$right=($result["fields"]["field"][1]["value"]);
	$right=json_decode(htmlspecialchars_decode( $right),true);
	
	for($i=0;$i<count($MenuArray["mainmenus"]["mainmenu"]);$i++){
		for($j=0;$j<count($MenuArray["mainmenus"]["mainmenu"][$i]["submenus"]["submenu"]);$j++){
			 $val=$MenuArray["mainmenus"]["mainmenu"][$i]["module"]."_".$MenuArray["mainmenus"]["mainmenu"][$i]["submenus"]["submenu"][$j]["model"];
			if(in_array($val,$right)){
				 $MenuArray["mainmenus"]["mainmenu"][$i]["submenus"]["submenu"][$j]["right"]="1";
			}else{
				 $MenuArray["mainmenus"]["mainmenu"][$i]["submenus"]["submenu"][$j]["right"]="0";
			}
		}
	}

	$result["fields"]["field"][1]["value"]=json_encode($MenuArray);
	$result["fields"]["field"][1]["default"]=json_encode($MenuArray);
	//print_r($result);
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