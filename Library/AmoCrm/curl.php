<?php 
namespace Api\Library\AmoCrm;
use Api\Library\AmoCrm\Error\Error;

class Curl
{
	// Отправка запроса к AmoCrm
	public static function curl($link,$access_token,$method='get',$data=null)
	{
		$headers = [
			"Accept: application/json",
			"Authorization: Bearer " . $access_token
		];
		$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/2.0');
		curl_setopt($curl,CURLOPT_URL, $link);
		// При использовании отличный методов от get, добавление к запросу массив с данными
		if ($method != 'get') {		
			curl_setopt($curl,CURLOPT_CUSTOMREQUEST,$method);
			curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data));
		}	
		// При отсутсвии токена access, задается другой заголовок, такой случай происходит при авторизации 
		if ($access_token == null) curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);			
		else curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl,CURLOPT_HEADER, false);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
		$out=curl_exec($curl); 
		$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		curl_close($curl);
		$response=json_decode($out,true);
		// Создание объекта для перехвата ошибки запроса
		$error = new Error($code,$response);
		return $response;
	}
}