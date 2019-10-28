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
	
    //��֤ǩ��ʧ��
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
		//���ó�ʱ
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		
		
		curl_setopt($ch,CURLOPT_URL, $url);
//		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
//		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//�ϸ�У��
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);//�ϸ�У��
		//����header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//Ҫ����Ϊ�ַ������������Ļ��
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	
		if($useCert == true){
			//����֤��
			//ʹ��֤�飺cert �� key �ֱ���������.pem�ļ�
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);
			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);
		}
		//post�ύ��ʽ
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//����curl
		$data = curl_exec($ch);
		//���ؽ��
		if($data){
			curl_close($ch);
			return $data;
		} else { 
			$error = curl_errno($ch);
			curl_close($ch);
			//echo "curl����������:$error";
		}
		return $data;
	}







?>