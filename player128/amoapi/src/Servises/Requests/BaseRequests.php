<?php
namespace Api\Library\AmoCrm\Services\Requests;

use function Api\Library\AmoCrm\Support\Aprint_r;
use Api\Library\AmoCrm\Support\Curl;
use Api\Library\AmoCrm\Entities\Task;
use Api\Library\AmoCrm\Entities\Note;

class BaseRequests 
{
	protected $client;
	protected $entity;

	public function __construct($client)
	{
		$this->client = $client;
	}

	public function createEntity($array)
	{

	}

	public function getById($id)
	{
		if (!$this->client->IsActual()) $this->client->updateToken();
		if (empty($id)) throw new Exception('Передан пустой параметр.');
		if (gettype($id) != 'integer') throw new Exception('Передан тип '.gettype($id).' вместо integer.');
		if ($id <= 0) throw new Exception('Передан некорректный ID.');
		$link='https://'.$this->client->getDomain().'.amocrm.ru/api/v4/'.$this->entity.'/'.$id;
		$response = Curl::curl($link, $this->client->getAccessToken(), "GET");
		if (!isset($response)) {
			echo "Сделка не найдена!";
			return false;
		} 
		return $this->createEntity($response);
	}

	public function update($item)
	{
		if (!$this->client->IsActual()) $this->client->updateToken();
		if (empty($item)) throw new Exception('Передан не существующий элемент.');
		$data['update'] = [];
		// Построение массива, для запроса  
		foreach ($item->fields as $key => $value) {
			if ($key == '_links' || $key == '_embedded') continue;
			 $data['update'] = array_merge($data['update'], [$key => $value]);
		}
		// Добавление изменений для кастомных полей
		$data['update']['custom_fields_values'] = $item->getCustom();
		$link='https://'.$this->client->getDomain().'.amocrm.ru/api/v4/'.$this->entity.'leads';
		Aprint_r($data);
		$Response=Curl::curl($link, $this->client->getAccessToken(), "PATCH", $data);
		Aprint_r($Response);
		return true;
	}

	// Создание экземпляра сущности 
	public function create($name)
	{
		if (!$this->client->IsActual()) $this->client->updateToken();
		if (empty($name)) throw new Exception('Передана пустая строка!');
		// Генерация исключение, если передан не верный тип
		if (gettype($name) != 'string') throw new Exception('Передан тип '.gettype($name).' вместо string.');
		// Создание объекта для экземпляра сущности 
		$item = $this->createEntity();
		$item->fields['name'] = $name;
		$data['add'] = $item->fields;
		unset($data['add']['status_id']);
		unset($data['add']['pipeline_id']);
		Aprint_r($data);
    	$link='https://'.$this->client->getDomain().'.amocrm.ru/api/v4/'.$this->entity;
	    $result = Curl::curl($link, $this->client->getAccessToken(), "POST", $data);
	    $item->fields['id'] = $result['_embedded'][$this->entity][0]['id'];
	    Aprint_r($item);
	    return $item;
	}

	// Прикрепление задачи к экземпляру сущности
	public function attachTask($item, string $text, int $duration, int $task_type)
	{
		if (!$this->client->IsActual()) $this->client->updateToken();
		if (empty($item)) throw new Exception('Передан не существующий элемент.');
		$dataTask = [
			'text' => $text,
			'complete_till' => time() + $duration,
			'entity_id' => $item->getID(),
			'entity_type' => $this->entity,
			'task_type' => $task_type 
		];
		$task = new Task();
		$task->setFields($dataTask);
		$data['add'] = $task->fields;
    	$link='https://'.$this->client->getDomain().'.amocrm.ru/api/v4/'.'tasks';
	    $result = Curl::curl($link,$this->client->getAccessToken(), "POST", $data);
	    // Сохранения id, только что созданной задачи в массив объекта экземпляра сущности
	    $tasks->fields['id'] = $result['_embedded']['tasks'][0]['id'];
	    $item->tasks->push($task);
	    Aprint_r($item->tasks);
	}

	// Прикрепление примечания к экземпляру сущност
	public function attachNote($item, string $note_type, array $params)
	{
		if (!$this->client->IsActual()) $this->client->updateToken();
		if (empty($item)) throw new Exception('Передан не существующий элемент.');
		$dataNote = [
	        "entity_id" => $item->getID(),
	        "note_type" => $note_type,
	        "params" => $params
		];
		$note = new Notes();
		$note->setFields($dataNote);
		$data['add'] = $note->fields;
		$item->notes = $note;
    	$link='https://'.$this->client->getDomain().'.amocrm.ru/api/v4/'.$this->entity.'/notes';
	    $result = Curl::curl($link, $this->client->getAccessToken(), "POST", $data);
	    $note->fields['id'] = $result['_embedded']['notes'][0]['id'];
	}
}