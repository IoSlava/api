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

	public function attachTaskToEntity($tasks)
	{
		foreach($this->items as $item){
			$itemID = $item->getId();
			$itemTask = isset($tasks[$item->name]) ? $tasks[$item->name] : null;
			if($itemTask == null) continue; 
			foreach($itemTask as $key => $value){
				if($itemID != $key) continue;
				$item->attachTask([$key => $value]);
			}
		}
	}

	public function __construct($domain,$access_token,$type)
	{
		$this->access_token = $access_token;
		$this->domain = $domain;
		$this->type = $type;
		$link="https://".$this->domain.".amocrm.ru/api/v4/".$type.'?limit=250';
		$Response= $this->curl($link,$this->access_token);
		$className = ucfirst($type);
		$className ='Api\Library\AmoCrm\\'.$className;
		$this->className = $className;
		foreach($Response['_embedded'][$type] as $item){
			$this->items = array_merge($this->items,[new $className($item,$type,$domain,$access_token)]);
		}
		//получить массив task и передать его сущности
		//написать комментарии
		$link="https://".$this->domain.".amocrm.ru/api/v4/".'tasks'.'?limit=250';
		$responseTask = $this->curl($link,$this->access_token);
		$sortedTask = [];
		foreach($responseTask['_embedded']['tasks'] as $item){
			if(empty($item['entity_id']) || $item['entity_type'] != $this->type) continue;
			$idEntity = $item['entity_id'];
			$sortedTask[$this->type][$idEntity] = $item; 
		}
		$this->attachTaskToEntity($sortedTask);
	}

	public function getById($id)
	{
		if(empty($id)) throw new Exception('Передан пустой параметр.');
		if(gettype($id) != 'integer') throw new Exception('Передан тип '.gettype($id).' вместо integer.');
		if($id <= 0) throw new Exception('Передан некорректный ID.');
		foreach($this->items as $item){
			if($item->getId() == $id) return $item;
		}
		return false;
	}
	public function update($item)
	{
		if(empty($item)) throw new Exception('Передан не существующий элемент.');
		$data['update'] = [];
		foreach ($item->fields as $key => $value){
			if($key == '_links' || $key == '_embedded') continue;
			 $data['update'] = array_merge($data['update'],[$key=> $value]);
		}
		$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.$this->type;
		$Response=$this->curl($link,$this->access_token,"PATCH",$data);
		return true;

	}

	public function create($name)
	{
		$item = new $this->className(-1,$this->type);
		$item->fields['name'] = $name;
		$data['add'] = $item->fields;
    	$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.$this->type;
	    $result = $this->curl($link,$this->access_token,"POST",$data);
	    $item->fields['id'] = $result['_embedded'][$this->type][0]['id'];
	    $this->items = array_merge($this->items,[$item]);
	    return $item;
	}

	public function attachTask($item,$text,$duration,$task_type)
	{
		if(empty($item)) throw new Exception('Передан не существующий элемент.');
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
	    $result = $this->curl($link,$this->access_token,"POST",$data);
	    $item->task->fields['id'] = $result['_embedded']['tasks'][0]['id'];
	}

	public function attachNote($item,$note_type,$params)
	{
		if(empty($item)) throw new Exception('Передан не существующий элемент.');
		$dataNote = [
	        "entity_id" => $item->getId(),
	        "note_type" => $note_type,
	        "params" => $params
		];
		$note = new Note($note_type,$item->getId(),$params);
		$data['add'] = $note->fields;
		$item->note = $note;
    	$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.$this->type.'/notes';
	    $result = $this->curl($link,$this->access_token,"POST",$data);
	    $note->fields['id'] = $result['_embedded']['notes'][0]['id'];
	}
}