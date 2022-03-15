<?php 
namespace Api\Library\AmoCrm;
use Exception;

class Api extends AmoApi {

	protected $leads;
	protected $companies;
	protected $contacts;

	public function leads()
	{
		return $this->middleware($this->leads);
	}

	public function companies()
	{
		return $this->middleware($this->companies);
	}

	public function contacts()
	{
		return $this->middleware($this->contacts);
	}

	public function middleware($object)
	{
		if(!$this->IsActual()) $this->updateToken();
		return $object;
	}

	public function loadDataAmo()
	{
		if(!$this->IsActual()) $this->updateToken();
		$this->leads = new Collection($this->getDomain(),$this->getAccessToken(),"leads");
		$this->companies = new Collection($this->getDomain(),$this->getAccessToken(),"companies");
		$this->contacts = new Collection($this->getDomain(),$this->getAccessToken(),"contacts");
	}
}