<?php
function NotifyDataValidate($key){
	$xml = file_get_contents('php://input');
	logger_mgr::logInfo($xml);
    $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    
    ksort($arr);
    $buff = "";
    foreach ($arr as $k => $v) {
        if ($k != "sign" && $k != "key" && $v != "" && !is_array($v)){
            $buff .= $k . "=" . $v . "&";
        }
    }
    $buff = trim($buff, "&");
	$string=$buff . "&key=" . $key;
    $sign=md5($string);
    logger_mgr::logInfo($sign."==".$arr["sign"]);
	
    //验证签名失败
    if(1==1||$sign==$arr["sign"]){
        return $arr;
    }else{
        return null;
    }

}


/**
 * Generate a nonce string
 *
 * @link https://pay.weixin.qq.com/wiki/doc/api/app.php?chapter=4_3
 */
function generateNonce()
{
    return md5(uniqid('', true));
}
/**
 * Get a sign string from array using app key
 *
 * @link https://pay.weixin.qq.com/wiki/doc/api/app.php?chapter=4_3
 */
function calculateSign($arr, $key)
{
    ksort($arr);
    $buff = "";
    foreach ($arr as $k => $v) {
        if ($k != "sign" && $k != "key" && $v != "" && !is_array($v)){
            $buff .= $k . "=" . $v . "&";
        }
    }
    $buff = trim($buff, "&");
	$string=$buff . "&key=" . $key;
    return strtoupper(md5($string));
}

/**
 * Get xml from array
 */
function getXMLFromArray($arr)
{
    $xml = "<xml>";
    foreach ($arr as $key => $val) {
        
            $xml .= sprintf("<%s>%s</%s>", $key, $val, $key);
    }
    $xml .= "</xml>";
    return $xml;
}
/**
 * Generate a prepay id
 *
 * @link https://pay.weixin.qq.com/wiki/doc/api/app.php?chapter=9_1
 */
function generatePrepayId($subject,$price,$orderno,$notifyapi)
{
    $params = array(
        'appid'            => APP_ID,
        'mch_id'           => MCH_ID,
        'nonce_str'        => generateNonce(),
        'body'             => $subject,
        'out_trade_no'     => $orderno,
        'total_fee'        => $price*100,
        'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],
        'notify_url'       => $notifyapi,
        'trade_type'       => 'JSAPI',
        'openid'           => OPENID,
    );
    // add sign
    $params['sign'] = calculateSign($params, APP_KEY);
	//print_r($params);
    // create xml
    $xml = getXMLFromArray($params);
	$result=postXmlCurl($xml, "https://api.mch.weixin.qq.com/pay/unifiedorder");
	
    // get the prepay id from response
     $xml = simplexml_load_string($result);
     if((string)$xml->err_code!=""){
         outputJSON(outResult((string)$xml->err_code,(string)$xml->err_code_des));
     }
    return (string)$xml->prepay_id;
}


	function postXmlCurl($xml, $url, $useCert = false, $second = 30)
	{		
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		
		
		curl_setopt($ch,CURLOPT_URL, $url);
//		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
//		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);//严格校验
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	
		if($useCert == true){
			//设置证书
			//使用证书：cert 与 key 分别属于两个.pem文件
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);
			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);
		}
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//运行curl
		$data = curl_exec($ch);
		//返回结果
		if($data){
			curl_close($ch);
			return $data;
		} else { 
			$error = curl_errno($ch);
			curl_close($ch);
			//echo "curl出错，错误码:$error";
		}
		return $data;
	}







?>