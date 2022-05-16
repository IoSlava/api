<?php 
namespace Api\Library\AmoCrm\Entity;
use  Api\Library\AmoCrm\Services\CustomFields;


class Leads 
{
	public $fields =  [
		"id"   => "0",
		"name" => "name",
		"price" => 0,
  		"responsible_user_id" => 0,
  		"group_id" => 0,
  		"status_id" => 0,
  		"pipeline_id" => 0
	];

	public $custom_fields = [];

	public function __construct()
	{

	}

	public function setField($array)
	{
		if (!is_array($array)) return false;

		if (!empty($array['custom_fields_values'])) {
			foreach ($array['custom_fields_values'] as $item) {
				$this->custom_fields = array_merge($this->custom_fields, [new CustomFields($item)]);
			}
		} 
		foreach ($this->fields as $key => $value) {
			$this->fields[$key] = $array[$key];
		}
		return $this;
	}

	public function getID()
	{
		return $this->fields['id'];
	}

	public function getCustom()
	{
		$result = [];
		foreach ($this->custom_fields as $field) {
			$result = array_merge($result, [$field->getFields()]);
		}
		return $result;
	}
}