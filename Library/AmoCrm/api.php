<?php 
namespace Api\Library\AmoCrm;
use Exception;

class Api extends AmoApi 
{
	protected $leads;
	protected $companies;
	protected $contacts;
	// Вовзрат объекта коллекции сделок
	public function leads()
	{
		return $this->middleware($this->leads);
	}
	// Вовзрат объекта коллекции компаний
	public function companies()
	{
		return $this->middleware($this->companies);
	}
	// Вовзрат объекта коллекции контактов
	public function contacts()
	{
		return $this->middleware($this->contacts);
	}
	// Проверка актуальности токена, при выполнении последнего условия, возврат переданного объекта
	public function middleware($object)
	{
		if (!$this->IsActual()) $this->updateToken();
		return $object;
	}
	// Проверка актуальности токена, при выполнении последнего условия, создания объектов коллекций
	public function loadDataAmo()
	{
		if (!$this->IsActual()) $this->updateToken();
		$this->leads = new Collection($this->getDomain(), $this->getAccessToken(), "leads");
		$this->companies = new Collection($this->getDomain(), $this->getAccessToken(), "companies");
		$this->contacts = new Collection($this->getDomain(), $this->getAccessToken(), "contacts");
	}
}