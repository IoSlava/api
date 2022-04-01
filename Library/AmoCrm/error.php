<?php
namespace Api\Library\AmoCrm;
use Exception;

class Error 
{
	public function __construct($code,$response)
	{   
		// Массив с кодами ответов на запрос, которые указывают на ошибку
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
		// Проверка кода ответа, если код, указывает на ошибку, происходит генерация исключения
		try{
			if ($code < 200 || $code > 204) {
				$message = isset($errors[$code]) ? "Error ".$code." - ".$errors[$code] : "Unknow";
				$message .= "<br>";
				throw new Exception($message);
			}	
		}	
		// Вывод информации об ошибке 
		catch(Exception $e){
			Aecho($e->getMessage());
			echo "Detail :";
			Aprint_r($response);
			echo "<br>";
			echo ">> <b>".$e->getTraceAsString()."</b>";  
			exit();
		}
	}
}