<?php
namespace Api\Library\AmoCrm;

class Note
{

	public $fields = [
        "id" => 0,
        "entity_id" => 0,
        "note_type" => "common",
        "params" => [
            "text" => "Текст примечания"
        ]
	];

	public function __construct($text,$note_type,$entity_id)
	{
		$this->fields['params']['text'] = $text;
		$this->fields['note_type'] = $note_type;
		$this->fields['entity_id'] = $entity_id;
	}
}