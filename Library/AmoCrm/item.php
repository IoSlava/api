<?php

namespace Api\Library\AmoCrm;


class Item extends Curl
{
	public $fields;
	public $custom_fields;
	protected $id;
	public $name;

	public function getField()
	{
		return $this->$custom_fields;
	}

	public function getName()
	{
		return $this->name;
	}

	// public function loadNotes($domain,$access_token,$type)
	// {
	// 	$link="https://".$domain.".amocrm.ru/api/v4/".$type.'/'.$this->fields['id'].'/'.'notes';
	// 	Aprint_r($link);
	// 	$response = $this->curl($link,$access_token);
	// 	$notes = isset($response['_embedded']) ? $response['_embedded'] : null;
	// 	if($notes == null) return false;
	// 	foreach($notes as $item){
	// 		$this->note = array_merge($this->note,[new Note($item)]);
	// 	}
	// 	return true;
	// }

	public function __construct($array,$type,$domain= null,$access_token = null)
	{
		if(!is_array($array)) return false;
		$this->name = $type;
		$this->custom_fields = $array['custom_fields_values']; 
		foreach ($this->fields as $key => $value) {
			$this->fields[$key] = $array[$key];
		}
		return $this;
	}

	public function attachTask($task)
	{
		$this->tasks = array_merge($this->tasks,[new Task($task)]);
	}

	public function attachNote($note)
	{

		$obj = new Note($note);
		$this->note = array_merge($this->note,[$obj]);
	}

	public function showTasks()
	{
		foreach($this->tasks as $item){
			Aprint_r($item);
		}
	}

	public function showNotes()
	{
		foreach($this->note as $item){
			Aprint_r($item);
		}
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function updateCustomFieldById($id,$value)
	{
		$time = time();
		for($i = 0; $i < sizeof($this->custom_fields);$i++){
			if($this->custom_fields[$i]['field_id'] == $id)$this->custom_fields[$i]['values'][0]['value'] = $value;
		}
	}

	public function updateCustomFieldByName($name,$value)
	{
		for($i = 0; $i < sizeof($this->custom_fields);$i++){
			if($this->custom_fields[$i]['field_name'] == $name)$this->custom_fields[$i]['values'][0]['value'] = $value;
		}
	}
}
