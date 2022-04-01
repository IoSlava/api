<?php
namespace Api\Library\AmoCrm;

class BaseCollection extends Curl
{
	protected $items = [];
	protected $access_token;
	protected $domain;
	protected $type;
	protected $className;

	public function __construct($domain,$access_token,$type)
	{
		$this->access_token = $access_token;
		$this->domain = $domain;
		$this->type = $type;
		$link="https://".$this->domain.".amocrm.ru/api/v4/".$type.'?limit=250';
		$Response= $this->curl($link,$this->access_token);
		$className = ucfirst($type);
		$className ='Api\Library\AmoCrm\\'.$className;
		$this->className = $className;
		foreach($Response['_embedded'][$type] as $item){
			$this->items = array_merge($this->items,[new $className($item,$type,$domain,$access_token)]);
		}
	}
}