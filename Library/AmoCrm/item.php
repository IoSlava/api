<?php

namespace Api\Library\AmoCrm;


class Item
{
	public $fields;
	protected $id;
	public $name;
	public $task;
	public $note;

	public function getField()
	{
		return $this->$custom_fields;
	}

	public function getName()
	{
		return $this->name;
	}

	public function __construct($array,$type)
	{
		if(!is_array($array)) return false;

		$this->name = $type;

		foreach ($this->fields as $key => $value) {
			$this->fields[$key] = $array[$key]; 
		}
		return $this;
	}

	public function getId()
	{
		return $this->fields['id'];
	}

}
