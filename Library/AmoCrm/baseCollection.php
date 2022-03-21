<?php
namespace Api\Library\AmoCrm;

class BaseCollection extends Curl
{
	protected $items = [];
	protected $access_token;
	protected $domain;
	protected $type;
	protected $className;

	public function attachToEntity($entity,$IsNote = false)
	{
		foreach($this->items as $item){
			$itemID = $item->getId();
			$itemEntity = isset($entity[$item->name]) ? $entity[$item->name] : null;
			if($itemEntity == null) continue; 
			foreach($itemEntity as $key => $value){
				if($itemID != $key) continue;
				$IsNote ? $item->attachTask([$key => $value]) : $item->attachNote([$key => $value]);
			}
		}
	}

	public function loadTasks()
	{
		$link="https://".$this->domain.".amocrm.ru/api/v4/".'tasks'.'?limit=250';
		$response = $this->curl($link,$this->access_token);
		$sorted = $this->sortResponse($response,'tasks');
		$this->attachToEntity($sorted);
	}

	public function loadNotes()
	{
		$link="https://".$this->domain.".amocrm.ru/api/v4/".$this->type.'/notes'.'?limit=250';
		$response = $this->curl($link,$this->access_token);
		$sorted = $this->sortResponse($response,'notes');
		$this->attachToEntity($sorted,true);
	}

	public function sortResponse($response,$typeEntity)
	{
		if(!isset($response['_embedded'][$typeEntity])) return false;
		$sortedTask = [];
		foreach($response['_embedded'][$typeEntity] as $item){
			if(!isset($item['entity_id']) || !isset($item['entity_type']) || $item['entity_type'] != $this->type) continue;
			$idEntity = $item['entity_id'];
			$sortedTask[$this->type][$idEntity] = $item; 
		}
		return $sortedTask;
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
		$this->loadTasks();
		$this->loadNotes();
	}
}