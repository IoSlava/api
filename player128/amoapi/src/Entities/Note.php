<?php
namespace player128\AmoApi\Entities;

class Note
{
	public $fields = [
        "id" => 0,
        "entity_id" => 0,
        "note_type" => "",
        "params" => ""
	];

	public function __construct()
	{
		
	}

	public function setFields($array)
	{
		$this->fields = $array;
	}
}