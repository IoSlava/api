<?php

namespace Api\Library\AmoCrm;


class Item extends Curl
{
	public $fields;
	public $custom_fields = [];
	protected $id;
	public $name;
	// Получение кастомных полей
	public function getField()
	{
		return $this->$custom_fields;
	}
	// Получение наименования экземпляра сущности
	public function getName()
	{
		return $this->name;
	}
	// Заполнение объекта данными экземпляра сущности
	public function __construct($array,$type,$domain= null,$access_token = null)
	{
		if(!is_array($array)) return false;
		$this->name = $type;
		if(!empty($array['custom_fields_values'])){
			foreach($array['custom_fields_values'] as $item){
				$this->custom_fields = array_merge($this->custom_fields,[new Custom($item)]);
			}
		} 
		foreach ($this->fields as $key => $value) {
			$this->fields[$key] = $array[$key];
		}
		return $this;
	}
	// Получение id встроенного поля
	public function getId()
	{
		return $this->fields['id'];
	}
	// Изменения кастомного поля по id
	public function updateCustomFieldById($id,$value,$index)
	{
		for($i = 0; $i < sizeof($this->custom_fields);$i++){
			if($this->custom_fields[$i]->getId() == $id)$this->custom_fields[$i]->setValue($value,$index);
		}
	}
	// Изменения кастомного поля по наименованию
	public function updateCustomFieldByName($name,$value,$index)
	{
		for($i = 0; $i < sizeof($this->custom_fields);$i++){
			if($this->custom_fields[$i]->getName() == $name)$this->custom_fields[$i]->setValue($value,$index);
		}
	}
	// Получение массива кастомных полей
	public function getCustom()
	{
		$result = [];
		foreach($this->custom_fields as $field){
			$result = array_merge($result,[$field->getFields()]);
		}
		return $result;
	}
}
