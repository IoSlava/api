<?php
namespace Api\Library\AmoCrm\Entity;

class Tasks 
{
	public $fields = [
		"id" => 0,
        "entity_id" => 0,
        "entity_type" => "",
        "task_type_id" => 0,
        "text" => "",
        "complete_till" => ""
	];

	public function __construct()
	{
		
	}

	public function setFields($array)
	{
		$this->fields = $array;
	}
}