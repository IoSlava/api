<?php
namespace Api\Library\AmoCrm\Services\Requests;

use Api\Library\AmoCrm\Entities\Contact;
use Api\Library\AmoCrm\Entities\Task;
use Api\Library\AmoCrm\Entities\Note;

class Contacts extends BaseRequests
{
	protected $client;
	protected $entity;

	public function __construct($client)
	{
		$this->client = $client;
		$this->entity = 'contacts';
	}

	public function createEntity($array)
	{
		$contact = new Contact();
		if (isset($array)) $contact->setFields($array);
		return $contact;
	}
}