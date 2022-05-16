<?php 
namespace Api\Library\AmoCrm\Collection;

class BaseCollection
{
	private $items = [];

	public function __construct()
	{

	}

	public function push($items)
	{
		array_push($this->items,$items);
	}

	public function pop()
	{
		$this->items = array_pop($this->items);
	}

	public function getCount()
	{
		return sizeof($this->items);
	}

	public function search($value)
	{
		return array_search($value, $this->items, true);// Объекты должны быть одним и тем же экземпляром
	}

	public function filter($array) // array: [key => value]
	{
		$key = array_keys($array);
		$key = $key[0];
		$value = $array[$key];

		foreach ($this->items as $k => $v) {
			if ($v->fields[$key] == $value) return $this->items[$k];
		}

		return false;
	}

}