<?php
namespace Api\Library\AmoCrm\Services;
use Api\Library\AmoCrm\Curl;
use Api\Library\AmoCrm\Entity\Leads as Entity;

class Leads 
{
	private $client;

	public function __construct($client)
	{
		$this->client = $client;
	}

	public function getById($id)
	{
		if (!$this->client->IsActual()) $this->client->updateToken();
		if (empty($id)) throw new Exception('Передан пустой параметр.');
		if (gettype($id) != 'integer') throw new Exception('Передан тип '.gettype($id).' вместо integer.');
		if ($id <= 0) throw new Exception('Передан некорректный ID.');
		$link='https://'.$this->client->getDomain().'.amocrm.ru/api/v4/leads/'.$id;
		$response = Curl::curl($link, $this->client->getAccessToken(), "GET");
		if (!isset($response)) {
			echo "Сделка не найдена!";
			return false;
		} 
		//Aprint_r($response);
		$lead = new Entity();
		$lead->setField($response);
		return $lead;
	}

	public function update($item)
	{
		if (!$this->client->IsActual()) $this->client->updateToken();
		if (empty($item)) throw new Exception('Передан не существующий элемент.');
		$data['update'] = [];
		// Построение массива, для запроса  
		foreach ($item->fields as $key => $value) {
			if ($key == '_links' || $key == '_embedded') continue;
			 $data['update'] = array_merge($data['update'], [$key=> $value]);
		}
		// Добавление изменений для кастомных полей
		$data['update']['custom_fields_values'] = $item->getCustom();
		$link='https://'.$this->client->getDomain().'.amocrm.ru/api/v4/leads';
		Aprint_r($data);
		$Response=Curl::curl($link, $this->client->getAccessToken(), "PATCH", $data);
		Aprint_r($Response);
		return true;
	}

	// Создание экземпляра сущности 
	public function create($name)
	{
		if (empty($name)) throw new Exception('Передана пустая строка!');
		// Генерация исключение, если передан не верный тип
		if (gettype($name) != 'string') throw new Exception('Передан тип '.gettype($name).' вместо string.');
		// Создание объекта для экземпляра сущности 
		$item = new Entity();
		$item->fields['name'] = $name;
		$data['add'] = $item->fields;
		unset($data['add']['status_id']);
		unset($data['add']['pipeline_id']);
		Aprint_r($data);
    	$link='https://'.$this->client->getDomain().'.amocrm.ru/api/v4/leads';
	    $result = Curl::curl($link, $this->client->getAccessToken(), "POST", $data);
	    $item->fields['id'] = $result['_embedded']['leads'][0]['id'];
	    Aprint_r($item);
	    return $item;
	}

	// Прикрепление задачи к экземпляру сущности
	public function attachTask($item, string $text, int $duration, int $task_type)
	{
		if (empty($item)) throw new Exception('Передан не существующий элемент.');
		$dataTask = [
			'text' => $text,
			'complete_till' => time() + $duration,
			'entity_id' => $item->getId(),
			'entity_type' =>$item->name,
			'task_type' => $task_type 
		];
		$task = new Task($dataTask);
		$data['add'] = $task->fields;
		$item->task = $task;
    	$link='https://'.$this->client->getDomain().'.amocrm.ru/api/v4/'.'tasks';
	    $result = Curl::curl($link,$this->client->getAccessToken(), "POST", $data);
	    // Сохранения id, только что созданной задачи в массив объекта экземпляра сущности
	    $item->task->fields['id'] = $result['_embedded']['tasks'][0]['id'];
	}
}