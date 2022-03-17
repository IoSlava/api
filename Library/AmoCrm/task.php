<?php
namespace Api\Library\AmoCrm;

class Task 
{
	public $fields = [
		"id" => 0,
        "entity_id" => 0,
        "entity_type" => "",
        "task_type_id" => 0,
        "text" => "",
        "complete_till" => ""
	];

	public function __construct($array)
	{
		$this->fields = $array;
	}
}