<?php 
namespace player128\AmoApi\Entities;

class Lead extends Entity
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