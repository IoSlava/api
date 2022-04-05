<?php 
namespace Api\Library\AmoCrm;

class AmoApi  extends Curl
{
	protected $token;
	protected $absolutePathTokenFile = ROOT."/Token/"."token.json";
	protected $dataAmo;
	// Получение данных для подключения к AmoCrm из конфига
	public function __construct($dataAmo)
	{
		$this->dataAmo = $dataAmo;
	}
	// Сохранение токена файл, если последний существует
	public function saveToken()
	{
		if (!file_exists($this->absolutePathTokenFile)) return false;
		$tokenJsonString = json_encode($this->token);
		file_put_contents($this->absolutePathTokenFile, $tokenJsonString,LOCK_EX);
		return true;
	}
	// Загрузка токена из файла, при условии, что файл непустой и существует
	public function loadToken()
    {
		if (file_exists($this->absolutePathTokenFile)) {
			$token = file_get_contents($this->absolutePathTokenFile);
			if ($token) {
				$this->token = (Array)json_decode($token);
				$this->loadDataAmo();
				return true;
			}
		}
		return false;
	}
    // Первичаня авторизация
	public function firstAuth()
	{
		$this->domain = $this->dataAmo['domain'];
		$link = 'https://' . $this->domain . '.amocrm.ru/oauth2/access_token';
		// Получение ответа на запрос, который делает функция curl
		$response = $this->curl($link,null,"POST",$this->dataAmo['login']);
		$access['access_token'] = $response['access_token']; 
		$access['refresh_token'] = $response['refresh_token']; 
		$access['token_type'] = $response['token_type']; 
		$access['expires_in'] = $response['expires_in']; 
		$access["endTokenTime"] = time() + $response["expires_in"];
		$this->token=$access;
		$this->loadDataAmo();
		$this->saveToken();
		return true;
	}
	// Получение данных для подключения к AmoCrm
	public function getDomain()
	{
		return $this->dataAmo['domain'];
	}
	// Проверка токена на его актуальность
	public function IsActual()
	{
		if ($this->token['endTokenTime'] <= time()) return false;
		return true;
	}
	// Получение access токена
	public function getAccessToken()
	{
		return $this->token['access_token'];
	}
	// Получение refresh токена
	public function getRefreshToken()
	{
		return $this->token['refresh_token'];
	}
    // Обновление токена, при успешном запросе сохранение его в файл 
	public function updateToken()
	{
		$link = 'https://' . $this->dataAmo['domain'] . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
		$data = [
			'client_id' => $this->dataAmo['login']['client_id'],
			'client_secret' =>$this->dataAmo['login']['client_secret'],
			'grant_type' => 'refresh_token',
			'refresh_token' => $this->getRefreshToken(),
			'redirect_uri' => $this->dataAmo['login']['redirect_uri'],
		];
		$response = $this->curl($link,null,"POST",$data);
		if ($response) {
			// Установление времени окончания жизни токена
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

