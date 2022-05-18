<?php
namespace Api\Library\AmoCrm\Services\Requests;

use Api\Library\AmoCrm\Entities\Lead as Elead;
use Api\Library\AmoCrm\Entities\Task;
use Api\Library\AmoCrm\Entities\Note;

class Lead extends BaseRequests
{
	protected $client;
	protected $entity;

	public function __construct($client)
	{
		$this->client = $client;
		$this->entity = 'leads';
	}

	public function createEntity($array)
	{
		$lead = new ELead();
		if (isset($array)) $lead->setFields($array);
		return $lead;
	}
}