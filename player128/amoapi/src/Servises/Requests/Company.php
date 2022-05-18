<?php
namespace Api\Library\AmoCrm\Services\Requests;

use Api\Library\AmoCrm\Entities\Company;
use Api\Library\AmoCrm\Entities\Task;
use Api\Library\AmoCrm\Entities\Note;

class Companies extends BaseRequests 
{
	protected $client;
	protected $entity;

	public function __construct($client)
	{
		$this->client = $client;
		$this->entity = 'companies';
	}

	public function createEntity($array)
	{
		$company = new Company();
		if (isset($array)) $company->setFields($array);
		return $company;
	}
}