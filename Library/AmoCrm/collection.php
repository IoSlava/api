<?php
namespace Api\Library\AmoCrm;
use Exception;

class Collection extends BaseCollection
{
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
		$custom_fields = [];
		$step = 0;
		foreach($item->custom_fields as $field){
			if(empty($field['values']))continue;
			$custom_fields[$step] = $field;
			$step++; 
		}
		$data['update']['custom_fields_values'] = $custom_fields;
		$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.$this->type;
		$Response=$this->curl($link,$this->access_token,"PATCH",$data);
		return true;

	}

	public function create($name)
	{
		if(empty($name)) throw new Exception('Передана пустая строка!');
		if(gettype($id) != 'string') throw new Exception('Передан тип '.gettype($id).' вместо string.');
		$item = new $this->className(-1,$this->type);
		$item->fields['name'] = $name;
		$data['add'] = $item->fields;
    	$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.$this->type;
	    $result = $this->curl($link,$this->access_token,"POST",$data);
	    $item->fields['id'] = $result['_embedded'][$this->type][0]['id'];
	    $this->items = array_merge($this->items,[$item]);
	    return $item;
	}

	public function attachTask($item,string $text,int $duration,int $task_type)
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

	public function attachNote($item,string $note_type,array $params)
	{
		if(empty($item)) throw new Exception('Передан не существующий элемент.');
		$dataNote = [
	        "entity_id" => $item->getId(),
	        "note_type" => $note_type,
	        "params" => $params
		];
		$note = new Note($dataNote);
		$data['add'] = $note->fields;
		$item->note = $note;
    	$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.$this->type.'/notes';
	    $result = $this->curl($link,$this->access_token,"POST",$data);
	    $note->fields['id'] = $result['_embedded']['notes'][0]['id'];
	}
}