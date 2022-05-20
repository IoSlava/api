<?php
namespace player128\AmoApi\Services\Requests;

use player128\AmoApi\Entities\Company as ECompany;
use player128\AmoApi\Entities\Task;
use player128\AmoApi\Entities\Note;

class Company extends BaseRequests 
{
	protected $client;
	protected $entity;

	public function __construct($client)
	{
		$this->client = $client;
		$this->entity = 'companies';
	}

	public function createEntity($array = null)
	{
		$company = new ECompany();
		if (isset($array)) $company->setFields($array);
		return $company;
	}

	public function msgNotresult()
	{
		return 'Компания не найдена.';
	}
}