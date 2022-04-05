<?php
namespace Api\Library\AmoCrm;
use Exception;

class Collection extends Curl
{
	protected $items = [];
	protected $access_token;
	protected $domain;
	protected $type;
	protected $className;
	// Запрос к AmoCrm для получения массива данных заданной сущности, сохранение их в массив items
	public function __construct($domain, $access_token, $type)
	{
		$this->access_token = $access_token;
		$this->domain = $domain;
		$this->type = $type;
		$link="https://".$this->domain.".amocrm.ru/api/v4/".$type.'?limit=250';
		$Response= $this->curl($link, $this->access_token);
		// Формирование имени необходимго класса для данной сущности
		$className = ucfirst($type);
		$className ='Api\Library\AmoCrm\\'.$className;
		$this->className = $className;
		// Проход по массива ответа на запрос и создание для каждого экземпляра сущности объекта соответствующего типа
		foreach ($Response['_embedded'][$type] as $item) {
			$this->items = array_merge($this->items, [new $className($item,$type,$domain,$access_token)]);
		}
	}
	// Получение экземпляра сущности по id, который был выдан AmoCrm
	public function getById($id)
	{
		if (empty($id)) throw new Exception('Передан пустой параметр.');
		if (gettype($id) != 'integer') throw new Exception('Передан тип '.gettype($id).' вместо integer.');
		if ($id <= 0) throw new Exception('Передан некорректный ID.');
		foreach ($this->items as $item) {
			if ($item->getId() == $id) return $item;
		}
		return false;
	}
	// Изменение экземпляра сущности
	public function update($item)
	{
		// Генерация исключение, если передана пустая переменная
		if (empty($item)) throw new Exception('Передан не существующий элемент.');
		$data['update'] = [];
		// Построение массива, для запроса  
		foreach ($item->fields as $key => $value) {
			if ($key == '_links' || $key == '_embedded') continue;
			 $data['update'] = array_merge($data['update'], [$key=> $value]);
		}
		// Добавление изменений для кастомных полей
		$data['update']['custom_fields_values'] = $item->getCustom();
		$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.$this->type;
		$Response=$this->curl($link, $this->access_token, "PATCH", $data);
		return true;

	}
	// Создание экземпляра сущности 
	public function create($name)
	{
		if (empty($name)) throw new Exception('Передана пустая строка!');
		// Генерация исключение, если передан не верный тип
		if (gettype($name) != 'string') throw new Exception('Передан тип '.gettype($name).' вместо string.');
		// Создание объекта для экземпляра сущности 
		$item = new $this->className(-1,$this->type);
		$item->fields['name'] = $name;
		$data['add'] = $item->fields;
    	$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.$this->type;
	    $result = $this->curl($link, $this->access_token, "POST", $data);
	    $item->fields['id'] = $result['_embedded'][$this->type][0]['id'];
	    // Довабление нового объекта в массив 
	    $this->items = array_merge($this->items, [$item]);
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
    	$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.'tasks';
	    $result = $this->curl($link,b$this->access_token, "POST", $data);
	    // Сохранения id, только что созданной задачи в массив объекта экземпляра сущности
	    $item->task->fields['id'] = $result['_embedded']['tasks'][0]['id'];
	}
	// Прикрепление примечания к экземпляру сущност
	public function attachNote($item, string $note_type, array $params)
	{
		if (empty($item)) throw new Exception('Передан не существующий элемент.');
		$dataNote = [
	        "entity_id" => $item->getId(),
	        "note_type" => $note_type,
	        "params" => $params
		];
		$note = new Note($dataNote);
		$data['add'] = $note->fields;
		$item->note = $note;
    	$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.$this->type.'/notes';
	    $result = $this->curl($link, $this->access_token, "POST", $data);
	    $note->fields['id'] = $result['_embedded']['notes'][0]['id'];
	}
}