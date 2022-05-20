<?php
namespace player128\AmoApi\Services\Requests;

use player128\AmoApi\Entities\Contact as EContact;
use player128\AmoApi\Entities\Task;
use player128\AmoApim\Entities\Note;

class Contact extends BaseRequests
{
	protected $client;
	protected $entity;

	public function __construct($client)
	{
		$this->client = $client;
		$this->entity = 'contacts';
	}

	public function createEntity($array = null)
	{
		$contact = new EContact();
		if (isset($array)) $contact->setFields($array);
		return $contact;
	}

	public function msgNotresult()
	{
		return 'Контакт не найден.';
	}
}