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

	public function __construct($note_type,$entity_id,$params)
	{
		$this->fields['note_type'] = $note_type;
		$this->fields['entity_id'] = $entity_id;
		$this->fields['params'] = $params;
	}
}