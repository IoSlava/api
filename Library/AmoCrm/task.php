<?php
namespace Api\Library\AmoCrm;

class Task 
{

	public $fields = [
        "entity_id" => 0,
        "entity_type" => "",
        "duration" => 0,
        "task_type_id" => 0,
        "text" => "",
        "complete_till" => ""
	];

	public function __construct($text,$duration,$entity_id,$entity_type,$task_type)
	{
		$this->fields['text'] = $text;
		$this->fields['duration'] = $duration;
		$this->fields['entity_id'] = $entity_id;
		$this->fields['entity_type'] = $entity_type;
		$this->fields['task_type_id'] = $task_type;
		$this->fields['complete_till'] = time() + $duration;
	}
}