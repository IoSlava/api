<?php
namespace Api\Library\AmoCrm;
use Exception;

class Error {

	public function __construct($code)
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

			try
			{
			    /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
			    if ($code < 200 || $code > 204) {
			        throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
			    }
			}
			catch(Exception $e)
			{
			    die('<br>Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
			}		
	}

}