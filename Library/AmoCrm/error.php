<?php
namespace Api\Library\AmoCrm;
use Exception;

class Error 
{
	public function __construct($code,$response)
	{
		$code = (int)$code;
		$errors = [
			400 => 'Bad request',
			401 => 'Unauthorized',
			403 => 'Forbidden',
			404 => 'Not found',
			500 => 'Internal server error',
			502 => 'Bad gateway',
			503 => 'Service unavailable',
		];
		try{
			if ($code < 200 || $code > 204) {
				$message = isset($errors[$code]) ? "Ошибка ".$code." - ".$errors[$code] : "Неизвестная ошибка";
				$message .= "<br>Детали:<br>";
				$e = $message;
				//$e['detail'] = $response;
				throw new Exception($e);
			}	
		}	
		catch(Exception $e){
			echo $e;
			Aprint_r($response);
		}
	}
}