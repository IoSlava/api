<?php 
/**
 * 
 */
namespace Api\Library\AmoCrm;
use Exception;// Не до конца понял как и что, но помогла избежать ошибки, что Api\Library\AmoCrm\Load\Exception класса нет

class AmoApi  
{
	protected $token;
	protected $absolutePathTokenFile = ROOT."/Token/"."token.json";
	protected $dataAmo;

	public function __construct($dataAmo)
	{
		$this->dataAmo = $dataAmo;
	}

	public function saveToken()// Если файла нет, то вернет ложь и не сохранит токен
	{
		if(!file_exists($this->absolutePathTokenFile)) return false;
		$tokenJsonString = json_encode($this->token);
			// Пишем содержимое в файл
			// и флаг LOCK_EX для предотвращения записи данного файла кем-нибудь другим в данное время
		file_put_contents($this->absolutePathTokenFile, $tokenJsonString,LOCK_EX);
			return true;
	}

	public function loadDataAmo()//абстракный метод
	{
		return true;
	}

	public function loadToken()// Загрузит токен, вернет правду
    {
			if(file_exists($this->absolutePathTokenFile))
			{
				$token = file_get_contents($this->absolutePathTokenFile);
				if($token)
				{   // Здесь обязательно нужно преобразовывать явно результат json_decode  в массив, иначе access получит тип stdClass
					$this->token = (Array)json_decode($token);
					echo "Токен есть";
					// Aprint_r($this->token);
					$this->loadDataAmo();
					return true;
				}
		}
		return false;
	}

	public function firstAuth()
	{
		 // echo "<br>...firstAuth()<br>";
		// if(file_exists($this->absolutePathTokenFile) && file_get_contents($this->absolutePathTokenFile))
		// {
		// 	die('Токен уже есть!');
		// }
		$this->domain = $this->dataAmo['domain'];

		$link = 'https://' . $this->domain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

		/** Соберем данные для запроса */
		$data = [
		    'client_id' => $this->dataAmo['cliend_id'],
		    'client_secret' => $this->dataAmo['cliend_secret'],
		    'grant_type' => $this->dataAmo['grant_type'],
		    'widget' => $this->dataAmo['widget'],
		    'code' => $this->dataAmo['code'],
		    'redirect_uri' => $this->dataAmo['redirect_uri']
		];
	 //    echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		/**
		 * Нам необходимо инициировать запрос к серверу.
		 * Воспользуемся библиотекой cURL (поставляется в составе PHP).
		 * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
		 */
		$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
		/** Устанавливаем необходимые опции для сеанса cURL  */
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
		curl_setopt($curl,CURLOPT_URL, $link);
		curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
		curl_setopt($curl,CURLOPT_HEADER, false);
		curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
		$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
		$code = (int)$code;
		$error = new Error($code);

		/**
		 * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
		 * нам придётся перевести ответ в формат, понятный PHP
		 */
		$response = json_decode($out, true);

		$access['access_token'] = $response['access_token']; //Access токен
		$access['refresh_token'] = $response['refresh_token']; //Refresh токен
		$access['token_type'] = $response['token_type']; //Тип токена
		$access['expires_in'] = $response['expires_in']; //Через сколько действие токена истекает
		$access["endTokenTime"] = time() + $response["expires_in"];
		// echo "<pre>";
		// print_r($response);s
		// echo "</pre>";
		$this->token=$access;
		$this->loadDataAmo();
		$this->saveToken();
		// echo "---------------------------------------------------<br>";
		return true;
	}
	public function IsActual()
	{
		if($this->token['endTokenTime'] <= time()) return false;

		return true;
	}

	public function putToken($token)
	{
		$this->token = $access;
		$this->saveToken();
	}

	public function getAccessToken()
	{
		return $this->token['access_token'];
	}

	public function getRefreshToken()
	{
			// echo "<pre>";
			// print_r($this->access);
			// echo "</pre>";
			// echo "<br>".$this->access['refresh_token'];
			// var_dump(access['refresh_token']);
			return $this->token['refresh_token'];
	}

	public function getDomain()
	{
		return $this->dataAmo['domain'];
	}

	public function updateToken()
	{
		// echo "<br>...updateToken()";
		// echo "<pre>";
		// print_r($this->dataAmo);
		// echo "</pre>";
		$link = 'https://' . $this->dataAmo['domain'] . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

		/** Соберем данные для запроса */
		$data = [
			'client_id' => $this->dataAmo['client_id'],
			'client_secret' =>$this->dataAmo['client_secret'],
			'grant_type' => 'refresh_token',
			'refresh_token' => $this->getRefreshToken(),
			'redirect_uri' => $this->dataAmo['redirect_uri'],
		];

		/**
		 * Нам необходимо инициировать запрос к серверу.
		 * Воспользуемся библиотекой cURL (поставляется в составе PHP).
		 * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
		 */
		$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
		/** Устанавливаем необходимые опции для сеанса cURL  */
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
		curl_setopt($curl,CURLOPT_URL, $link);
		curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
		curl_setopt($curl,CURLOPT_HEADER, false);
		curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
		$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
		$code = (int)$code;
		$error = new Error($code);
		/**
		 * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
		 * нам придётся перевести ответ в формат, понятный PHP
		 */

		$response = json_decode($out, true);

		if($response) {

			/* записываем конечное время жизни токена */
			$response["endTokenTime"] = time() + $response["expires_in"];
			$this->token=$response;
			$this->saveToken();
			return $this->token['access_token'];
		}
		else {
			return false;
		}
	}
}

