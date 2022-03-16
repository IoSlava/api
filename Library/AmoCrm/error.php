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
		if ($code < 200 || $code > 204) {
			$message = isset($errors[$code]) ? $errors[$code] : 'Undefined error';
			$message .= " - ".$response['hint'];
			throw new Exception($message);
		}		
	}
}