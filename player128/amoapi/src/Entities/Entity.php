<?php 
namespace player128\AmoApi\Entities;
use  player128\AmoApi\Support\CustomFields;
use  player128\AmoApi\Collection\BaseCollection;

class Entity
{
	public $fields;
	public $custom_fields = [];
	public $tasks;
	public $notes;

	public function __construct()
	{
		$this->tasks = new baseCollection();
		$this->notes = new baseCollection();
	}

	public function setFields($array)
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

	// Изменения кастомного поля по id
	public function updateCustomFieldById($id, $value, $index)
	{
		for ($i = 0; $i < sizeof($this->custom_fields); $i++){
			if ($this->custom_fields[$i]->getId() == $id)$this->custom_fields[$i]->setValue($value,$index);
		}
	}
	// Изменения кастомного поля по наименованию
	public function updateCustomFieldByName($name, $value, $index)
	{
		for ($i = 0; $i < sizeof($this->custom_fields); $i++) {
			if ($this->custom_fields[$i]->getName() == $name)$this->custom_fields[$i]->setValue($value, $index);
		}
	}
}