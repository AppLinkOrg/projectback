<?php
            

#[Root]
$CONFIG['Title']             = '实车实况';
$CONFIG['URL']="http://cmsdev.app-link.org/alucard263096/carpost"; 
$CONFIG['lang']="zh-cn";//en-us
$CONFIG["SessionName"]="FooterCMS_alucard263096_carpost";
$CONFIG["SupportMultiLanguage"]=false;

$CONFIG['solution_configuration']='debug';
$CONFIG['server']		= 'windows';   //windows or linux


#[Database]
$CONFIG['database']['provider']	= 'mysql';  //mssql,sqlsrv
$CONFIG['database']['host']		= 'mysql.app-link.org';  
$CONFIG['database']['database']	= 'alucard263096_carpost';  
$CONFIG['database']['user']		= 'alucard263096';  
$CONFIG['database']['psw']		= 'a6c3bc0575df7d9d676890e861130a9a'; 


#[File upload]
$CONFIG['fileupload']['upload_path']	= "upload";


$CONFIG['fileupload']['oss']	= true;//改为oss上传的话
if($CONFIG['fileupload']['oss']==true){
	$CONFIG['fileupload']['upload_path']	= "http://applinkupload.oss-cn-shenzhen.aliyuncs.com";
	$CONFIG['fileupload']['accesskeyid']    = "LTAIkBoCGZOPEXFh";
	$CONFIG['fileupload']['accesskeysecret']    = "bN7Gnq1q6l6TDlVK8yQDcjcCzY8sQt";
	$CONFIG['fileupload']['endpoint']    = "oss-cn-shenzhen-internal.aliyuncs.com";
	$CONFIG['fileupload']['bucket']    = "applinkupload";
}


            ?>