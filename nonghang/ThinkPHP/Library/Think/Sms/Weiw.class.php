<?php
namespace Think\Sms;
class Weiw{	


	private $send_target = "http://cf.51welink.com/submitdata/Service.asmx/g_Submit"; 
	private $mask_phone = "/^1[0-9]{10}$/";
	private $account = "";
	private $password = "";
	private $smsSign = "";
	private $active = true;

	
	public function __construct($config){
		$this->account = $config['smsAccount'];
		$this->password = $config['smsPassword'];
		$this->smsSign = $config['smsSign'];
	}
	
	//@ param   	phone  电话号码        
	//@ param   	messageId 模板配置key   string
	//@param		content 验证码  array()
	
	public function sendSms($phone, $content) {
		

		if ( !$this->active ) {
			return array('code' => -5, 'text' => '短信接口未激活');
		}
		if ( is_array($phone) ) {
			foreach ($phone as $item) {
				if ( !preg_match($this->mask_phone, $item) ) {
					return array('code' => -3, 'text' => '短信接收号码格式不正确');
				}
			}
			$phone = implode(',', $phone);
		}
		else {
			
			if ( !preg_match($this->mask_phone, $phone) ) {
				return array('code' => -3, 'text' => '短信接收号码格式不正确');
			}
		}

		$content .= '【'.$this->smsSign .'】';
		
		$post_data = "sname=".$this->account."&spwd=".$this->password."&scorpid=&sprdid=1012818&sdst=". $phone ."&smsg=".rawurlencode($content);

		$result = $this->CurlPost($post_data,$this->send_target);
		wlog('手机号：' . $phone . ' 短信内容：' . $content . ' 发送结果：' . json_encode($result), 'Sms');
		if($result['CSubmitState']['State'] == 0){
		
			return array('code'=>1,'text'=> $result['CSubmitState']['MsgState'],'phoneNumber'=> $phone);
		}else{

			return array('code'=>$result['CSubmitState']['State'],'text'=> $result['CSubmitState']['MsgState'],'phoneNumber'=> $phone);
			
		}

	
	}


	private  function CurlPost($data,$url){
		
		$result = $this->xml_to_array($this->Post($data,$url));
		return $result;
	}
	

	private function Post($curlPost,$url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		$return_str = curl_exec($curl);
		curl_close($curl);
		return $return_str;
	}
	
	private function xml_to_array($xml){
		$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
		if(preg_match_all($reg, $xml, $matches)){
			$count = count($matches[0]);
			for($i = 0; $i < $count; $i++){
			$subxml= $matches[2][$i];
			$key = $matches[1][$i];
				if(preg_match( $reg, $subxml )){
					$arr[$key] = $this->xml_to_array( $subxml );
				}else{
					$arr[$key] = $subxml;
				}
			}
		}
		return $arr;
	}
	
}
?>