<?php
namespace Api\Library\AmoCrm\Tests;

use Api\Library\AmoCrm\AmoApi as Client;
use function Api\Library\AmoCrm\Support\Aprint_r;

class Tests
{
	public function __construct()
	{

	}

	// Тесты на нахождение сущностей по id
	public function Test1($client,$n,$id)
	{
		switch ($n){
			case 1: 
				$item = $client->leads()->getById($id);
				Aprint_r($item);
				break;
			case 2: 
				$item = $client->contacts()->getById($id);
				Aprint_r($item);
				break;
			case 3: 
				$item = $client->companies()->getById($id);
				Aprint_r($item);
				break;								
		}
	}
	// Тесты на изменение полей сущностей
	public function Test2($client,$n,$id,$name)
	{
		switch ($n){
			case 1: 
				$item = $client->leads()->getById($id);
			    $item->fields['name'] = $name;
			    $client->leads()->update($item);
				Aprint_r($item);
				break;
			case 2: 
				$item = $client->contacts()->getById($id);
			    $item->fields['first_name'] = $name;
			    $client->contacts()->update($item);
				Aprint_r($item);
				break;
			case 3: 
				$item = $client->companies()->getById($id);
			    $item->fields['name'] = $name;
			    $client->companies()->update($item);
				Aprint_r($item);
				break;								
		}
	}
	// Тесты на создание сущностей 
	public function Test3($client,$n,$name)
	{
		switch ($n){
			case 1: 
				$item = $client->leads()->create($name);
				Aprint_r($item);
				break;
			case 2: 
				$item = $client->contacts()->create($name);
				Aprint_r($item);
				break;
			case 3: 
				$item = $client->companies()->create($name);
				Aprint_r($item);
				break;								
		}
	}
	// Тесты на добавление примечания к сущностям
	public function Test4($client,$n,$id,$text)
	{
		$params = [
			'text' => $text
		];
		switch ($n){
			case 1: 
				$item = $client->leads()->getById($id);
				$client->leads()->attachNote($item,'common',$params);
				Aprint_r($item);
				break;
			case 2: 
				$item = $client->contacts()->getById($id);
			    $client->contacts()->attachNote($item,'common',$params);
				Aprint_r($item);
				break;
			case 3: 
				$item = $client->companies()->getById($id);
			    $client->companies()->attachNote($item,'common',$params);
				Aprint_r($item);
				break;								
		}
	}		
	// Тесты на добавление задачи к сущностям
	public function Test5($client,$n,$id,$text)
	{
		switch ($n){
			case 1: 
				$item = $client->leads()->getById($id);
			    $client->leads()->attachTask($item,$text,300,2);
				Aprint_r($item);
				break;
			case 2: 
				$item = $client->contacts()->getById($id);
			    $client->contacts()->attachTask($item,$text,300,2);
				Aprint_r($item);
				break;
			case 3: 
				$item = $client->companies()->getById($id);
			    $client->companies()->attachTask($item,$text,300,2);
				Aprint_r($item);
				break;								
		}
	}
	// Тесты на изменение значения кастомного поля
	public function Test6($client,$n,$id,$idCustom,$value,$index)
	{
		switch ($n){
			case 1: 
				$item = $client->leads()->getById($id);
				$item->updateCustomFieldById($idCustom,$value,$index);
				$client->leads()->update($item);
				Aprint_r($item);				
				break;
			case 2: 
				$item = $client->contacts()->getById($id);
				$item->updateCustomFieldById($idCustom,$value,$index);
			    $client->contacts()->update($item);
				Aprint_r($item);
				break;
			case 3: 
				$item = $client->companies()->getById($id);
				$item->updateCustomFieldById($idCustom,$value,$index);
			    $client->companies()->update($item);
				Aprint_r($item);
				break;								
		}
	}			
}
		// Test1($client,1,28781491);
		// Test1($client,2,46162243);
		// Test1($client,3,46162133);

		// Test2($client,1,28781491,'Москва');
		// Test2($client,2,46162243,'Москва');	
		// Test2($client,3,46162133,'Москва');		

		// Test3($client,1,'Москва');
		// Test3($client,2,'Москва');	
		// Test3($client,3,'Москва');		

		// Test4($client,1,28781491,'Примета');
		// Test4($client,2,46162243,'Примета');	
		// Test4($client,3,46162133,'Примета');		

		// Test5($client,1,28781491,'Сделай');
		// Test5($client,2,46162243,'Сделай');	
		// Test5($client,3,46162133,'Сделай');			

		// Test6($client,1,28224333,820449,'Новый текст',0);
		// Test6($client,2,45745827,181759,'Кастомка',0);	
		// Test6($client,3,46042538,181759,'Кастомка',0);	