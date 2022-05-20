<?php
namespace player128\AmoApi\Support;

class CustomFields 
{
	public $fields;
	// Заполнение кастомных полей
	public function __construct($array)
	{
		$this->fields = $array;
	}
	// Получение id поля
	public function getId()
	{
		return $this->fields['field_id'];
	}
	// Получение наименования
	public function getName()
	{
		return $this->fields['field_name'];
	}
    // Изменение значения поля
	public function setValue($value, $index)
	{
		$this->fields['values'][$index]['value'] = $value;
	}
    // Возврат параметров поля 
	public function getFields()
	{
		$result = [];
        // Выгрузка в result параметров, кроме value
		foreach ($this->fields as $key => $value) {
			if($key == 'values') continue;
			$result = array_merge($result,[$key => $value]);
		}
		$result['values'] = [];
		// Выгрузка в result параметра массива-value, у которого убираются элементы с пустым значением
		foreach ($this->fields['values'] as $value) {
			$buf = [];
			foreach ($value as $key => $val) {
				if(empty($val)) continue;
				$buf = array_merge($buf,[$key => $val]);
			}
			$result['values'] = array_merge($result['values'],[$buf]);
		}
		return $result;
	}
}