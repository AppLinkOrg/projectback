<?php

$sql="select * from tb_aliyunsms_config";
$aliyunsmsconfig=$dbmgr->fetch_array($dbmgr->query($sql));
//print_r($aliyunsmsconfig);
include USER_ROOT."/common/aliyunmns.cls.php";
$aliyunMNS=new AliyunMNS($aliyunsmsconfig["endpoint"],$aliyunsmsconfig["accessid"],$aliyunsmsconfig["accesskey"],$inst["smssign"]);

function SMSSendVerifyCode($mobile,$type,$verifycodefield="verifycode",$codelength=6){
	Global $aliyunMNS,$dbmgr;	
	if(empty($mobile)){
		return array("result"=>'MOBILE_NULL',"return"=>-400);
	}

	if($dbmgr->checkHave("tb_sms_verifycode"," type='$type' and mobile='$mobile' and TIMESTAMPDIFF(SECOND,senttime,now())<=60 and is_verified='N' ")){
		return array("result"=>'SENT_IN_MINUTE',"return"=>-401);
	}

	$sql="select * from tb_aliyun_sms where type='$type' and status='A'";
	$template=$dbmgr->fetch_array($dbmgr->query($sql));
	if($template["templateid"]==""){
	    return array("result"=>'NO_SMS_TYPE',"return"=>-401);
	}

	$code="";
	for($i=0;$i<$codelength;$i++){
		$code.=rand(0,9);
	}
	
	$expiredtime=date('Y-m-d H:i:s',time()+$template["expiredminite"]*60);

	$sendresult=$aliyunMNS->SendSMSMessage($template["templateid"], $mobile, array($verifycodefield=>$code));
	if($sendresult["result"]==true){
		
		$sql="insert into tb_sms_verifycode (id,type,verifycode,mobile,senttime,is_verified,expired) select ifnull(max(id),0)+1, '$type','$code','$mobile',now(),'N','$expiredtime' from tb_sms_verifycode";
		$dbmgr->query($sql);
		return array("result"=>'SUCCESS',"return"=>0);
	}else{
		return array("result"=>'SMS_SEND_FAIL',"return"=>-1);
	}

}

function SMSCodeVerify($mobile,$code,$type){
	Global $aliyunMNS,$dbmgr;
	
	
	if(empty($mobile)){
		return false;
	}
	
	$sql="select * from tb_sms_verifycode 
	where  type='$type' and mobile='$mobile' and now()<=expired  and is_verified='N' 
	order by senttime desc 
	limit 0,1";
	$result=$dbmgr->fetch_array($dbmgr->query($sql));
	if($result["verifycode"]!=""&&$result["verifycode"]==$code){
		$sql="update tb_sms_verifycode set verified_time=now(),is_verified='Y' where id=".$result["id"];
		$dbmgr->query($sql);
		return true;
	}else{
		return false;
	}
	
}

function SMSSendMessage($mobile,$type,$array){
	
	Global $aliyunMNS,$dbmgr;
	
	if(empty($mobile)){
		return 'MOBILE_NULL';
	}
	$sql="select * from tb_aliyun_sms where type='$type' and status='A'";
	$template=$dbmgr->fetch_array($dbmgr->query($sql));

	$sendresult=$aliyunMNS->SendSMSMessage($template["templateid"], $mobile, $array);
	if($sendresult["result"]==true){
		return "SUCCESS";
	}else{
		return "SENT_FAIL";
	}
	
}

?>