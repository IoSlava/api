<?php 
namespace Api\Library\AmoCrm\Entity;
use  Api\Library\AmoCrm\Services\CustomFields;
use Api\Library\AmoCrm\Collection\BaseCollection;

class Lead extends MainEntites
{
	public $fields =  [
		"id"   => "0",
		"name" => "name",
		"price" => 0,
  		"responsible_user_id" => 0,
  		"group_id" => 0,
  		"status_id" => 0,
  		"pipeline_id" => 0
	];
}