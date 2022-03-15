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

	public function __construct($domain,$access_token,$type)
	{
		$this->access_token = $access_token;
		$this->domain = $domain;
		$this->type = $type;

			// Изменил лимит, чтобы достать все сделки
		$link="https://".$this->domain.".amocrm.ru/api/v4/".$type.'?limit=250';

		$Response= $this->curl($link,$this->access_token);

		$className = ucfirst($type);
		$className ='Api\Library\AmoCrm\\'.$className;
		$this->className = $className;

		foreach($Response['_embedded'][$type] as $item)
		{
			$this->items = array_merge($this->items,[new $className($item,$type)]);
		}
	}

	public function getById($id)
	{
		if(empty($id))
		{
			throw new Exception('Передан пустой параметр.');
		}
		if(gettype($id) != 'integer')
		{
			throw new Exception('Передан тип '.gettype($id).' вместо integer.');
		}

		if($id <= 0)
		{
		    throw new Exception('Передан некорректный ID.');
		}
		foreach($this->items as $item)
		{
			if($item->getId() == $id) return $item;
		}
		return false;
	}
	public function update($item)
	{
		if(empty($item)) echo "Передан не существующий элемент.";
		$data['update'] = [];
		foreach ($item->fields as $key => $value)
		{
			if($key == '_links' || $key == '_embedded') continue;
			 $data['update'] = array_merge($data['update'],[$key=> $value]);
		}

		$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.$this->type;
		$Response=$this->curl($link,$this->access_token,"PATCH",$data);
		// Aprint_r($Response);
		return true;

	}

	public function create($name)
	{
		$item = new $this->className(-1,$this->type);
		$item->fields['name'] = $name;

		$data['add'] = $item->fields;

		Aprint_r($data);

    	$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.$this->type;
	    $result = $this->curl($link,$this->access_token,"POST",$data);
	    // Aprint_r($result);
	    $item->fields['id'] = $result['_embedded'][$this->type][0]['id'];
	    $this->items = array_merge($this->items,[$item]);

	    return $item;
	}

	public function attachTask($item,$text,$duration,$task_type)
	{
		if(empty($item)) echo "Передан не существующий элемент.";
		$task = new Task($text,$duration,$item->getId(),$item->name,$task_type);

		$data['add'] = $task->fields;
		$item->task = $task;
		Aprint_r($data);

    	$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.'tasks';
	    $result = $this->curl($link,$this->access_token,"POST",$data);
	    // Aprint_r($result);
	    $item->task->fields['id'] = $result['_embedded']['tasks'][0]['id'];
	}

	public function attachNote($item,$note_type,$params)
	{
		if(empty($item)) echo "Передан не существующий элемент.";

		$note = new Note($note_type,$item->getId(),$params);

		$data['add'] = $note->fields;
		$item->note = $note;
		Aprint_r($data);

    	$link='https://'.$this->domain.'.amocrm.ru/api/v4/'.$this->type.'/notes';
	    $result = $this->curl($link,$this->access_token,"POST",$data);
	    // Aprint_r($result);
	    $note->fields['id'] = $result['_embedded']['notes'][0]['id'];
	}
}