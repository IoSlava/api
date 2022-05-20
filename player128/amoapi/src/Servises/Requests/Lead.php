<?php
namespace player128\AmoApi\Services\Requests;

use player128\AmoApi\Entities\Lead as ELead;
use player128\AmoApi\Entities\Task;
use player128\AmoApi\Entities\Note;

class Lead extends BaseRequests
{
	protected $client;
	protected $entity;

	public function __construct($client)
	{
		$this->client = $client;
		$this->entity = 'leads';
	}

	public function createEntity($array = null)
	{
		$lead = new ELead();
		if (isset($array)) $lead->setFields($array);
		return $lead;
	}

	public function msgNotresult()
	{
		return 'Сделка не найдена.';
	}
}