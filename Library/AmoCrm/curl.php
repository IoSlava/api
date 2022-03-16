<?php 
namespace Api\Library\AmoCrm;

class Curl
{
	public function curl($link,$access_token,$method='get',$data=null)
	{
		$headers = [
				"Accept: application/json",
				'Authorization: Bearer ' . $access_token
		];
		$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/2.0');
		curl_setopt($curl,CURLOPT_URL, $link);
		if($method != 'get'){		
			curl_setopt($curl,CURLOPT_CUSTOMREQUEST,$method);
			curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data));
		}	
		if($access_token == 'null')curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);			
		else curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl,CURLOPT_HEADER, false);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
		$out=curl_exec($curl); 
		$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		curl_close($curl);
		$error = new Error($code);
		return $Response=json_decode($out,true);
	}
}