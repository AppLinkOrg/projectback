<?php


if(!function_exists('curl_reset')) {
 function curl_reset(&$ch){
	$ch = curl_init();
}
}


require_once(USER_ROOT.'common/aliyun-dysms-php-sdk/vendor/autoload.php');
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;



class AliyunMNS
{
	//public function SendVerifyCodeSMSMessage($PhoneNumbers, $verifycode){
	//	return PublishBatchSMSMessageDemo::SendSMSMessage("SMS_62440237", $PhoneNumbers, array("name"=>$verifycode));
	//}
	public $endPoint = ""; // eg. http://1234567890123456.mns.cn-shenzhen.aliyuncs.com
    public $accessId = "";
    public $accessKey = "";
    public $signName = "";
	
	function __construct($endPoint,$accessId,$accessKey,$signName){
		$this->endPoint=$endPoint;
		$this->accessId=$accessId;
		$this->accessKey=$accessKey;
		$this->signName=$signName;
	}
	
	public function getAcsClient() {
        //产品名称:云通信流量服务API产品,开发者无需替换
        $product = "Dysmsapi";

        //产品域名,开发者无需替换
        $domain = "dysmsapi.aliyuncs.com";

        // TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
        $accessKeyId = $this->accessId; // AccessKeyId

        $accessKeySecret = $this->accessKey; // AccessKeySecret

        // 暂时不支持多Region
        $region = "cn-hangzhou";

        // 服务结点
        $endPointName = "cn-hangzhou";


        
        //初始化acsClient,暂不支持region化
        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

        // 增加服务结点
        DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);
		

        // 初始化AcsClient用于发起请求
        $acsClient = new DefaultAcsClient($profile);
		
        return $acsClient;
    }
	
    public function SendSMSMessage($SMSTemplateCode, $PhoneNumbers, $SMSparams)
    {
		
        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        // 必填，设置短信接收号码
        $request->setPhoneNumbers($PhoneNumbers);

        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $request->setSignName($this->signName);

        // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $request->setTemplateCode($SMSTemplateCode);

        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
        $request->setTemplateParam(json_encode($SMSparams));

        // 可选，设置流水号
       // $request->setOutId("yourOutId");

        // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
       // $request->setSmsUpExtendCode("1234567");

        // 发起访问请求
        
		try
        {
			$acsResponse = $this->getAcsClient()->getAcsResponse($request);
			$result = array('result'=>1, 'ret'=>$acsResponse);
			//print_r($result);
			return $result;
        }
        catch (MnsException $e)
        {
            //echo $e;
            //echo "\n";
			$result = array('result'=>false, 'errorMsg'=>$e->__toString());
		//echo "bbb?";
			//print_r($result);
			return $result;
        }
		
    }
}


?>