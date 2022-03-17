<?php

namespace Api\Library\AmoCrm;


class Item extends Curl
{
	public $fields;
	protected $id;
	public $name;
	public $tasks = [];
	public $note = [];

	public function getField()
	{
		return $this->$custom_fields;
	}

	public function getName()
	{
		return $this->name;
	}

	public function __construct($array,$type,$domain,$access_token)
	{
		if(!is_array($array)) return false;

		$this->name = $type;

		foreach ($this->fields as $key => $value) {
			$this->fields[$key] = $array[$key]; 
		}
		$link="https://".$domain.".amocrm.ru/api/v4/".$type.'/'.$this->fields['id'].'/'.'notes';
		$response = $this->curl($link,$access_token);
		Aprint_r($response);
		foreach($response['_embedded'] as $item){
			$this->note = array_merge($this->note,[new Note($item)]);
		}
		return $this;
	}

	public function attachTask($task)
	{
		$this->tasks = array_merge($this->tasks,[new Task($task)]);
	}

	public function showTasks()
	{
		foreach($this->tasks as $item){
			Aprint_r($item);
			echo"-----------<br>";
		}
	}

	public function getId()
	{
		return $this->fields['id'];
	}
}
