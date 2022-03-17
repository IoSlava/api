<?php
namespace Api\Library\AmoCrm;

class Note
{
	public $fields = [
        "id" => 0,
        "entity_id" => 0,
        "note_type" => "",
        "params" => ""
	];

	public function __construct($arrray)
	{
		$this->fields = $arrray;
	}
}