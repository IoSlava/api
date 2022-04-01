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
				$message = isset($errors[$code]) ? "Error ".$code." - ".$errors[$code] : "Unknow";
				$message .= "<br>";
				throw new Exception($message);
			}	
		}	
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