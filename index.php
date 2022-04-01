<?php
use Api\Library\AmoCrm\Api as Client;
define('ROOT', __DIR__);

function Aprint_r($array)
{
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}
function Aecho($value)
{
	echo "<br>".$value."<br>";
}

include ROOT.'/config/amoCrm.php';
include ROOT.'/Library/AmoCrm/load.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Api</title>
		<link rel="stylesheet" type="text/css" href="style/style.css">
	</head>
<body>
	<div class="content">
	<?php
		$timeLoad = time();
		// Создание объекта клиента и передача ему в конструктор данных для доступа к AmoCrm
		$client = new Client(getConfig());
		// Проверка: был ли загружен токен из файла
		if($client->loadToken()){ }
		// Иначе: происходит первичная авторизация и сохранение токена в файл	
		else {

			$client->firstAuth();
			$client->saveToken();
		}	
		// $item = $client->contacts()->getById(46162243);
		// $item->fields['first_name'] = 'Sweet';
		// $params = [
		// 	'text' => 'Капт территории.'
		// ];
		// $client->contacts()->attachNote($item,'common',$params);
		// Aprint_r($item);
		// $item->fields['name'] = "San Francisco";
		// $client->companies()->update($item);
		// $item->fields['name'] = "Groove Stree Gang";
		// $client->companies()->update($item);
		// Aprint_r($item);
		// $lead->updateCustomFieldById(820263,"YOU");
		//$client->leads()->update($lead);


		function Test1($client,$n,$id)
		{
			switch($n){
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
		function Test2($client,$n,$id,$name)
		{
			switch($n){
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

		function Test3($client,$n,$name)
		{
			switch($n){
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

		function Test4($client,$n,$id,$text)
		{
			$params = [
				'text' => $text
			];
			switch($n){
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

		function Test5($client,$n,$id,$text)
		{
			switch($n){
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

		function Test6($client,$n,$id,$idCustom,$value)
		{
			switch($n){
				case 1: 
				$item = $client->leads()->getById($id);
				$item->updateCustomFieldById($idCustom,$value);
			    $client->leads()->update($item);
				Aprint_r($item);
				break;
				case 2: 
				$item = $client->contacts()->getById($id);
				$item->updateCustomFieldById($idCustom,$value);
			    $client->contacts()->update($item);
				Aprint_r($item);
				break;
				case 3: 
				$item = $client->companies()->getById($id);
				$item->updateCustomFieldById($idCustom,$value);
			    $client->companies()->update($item);
				Aprint_r($item);
				break;								
			}
		}		

		//Test1($client,1,28781491);
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

		Test6($client,1,28224333,820449,'Кастомка');
		// Test6($client,2,45745827,181759,'Кастомка');	
		// Test6($client,3,46042538,181759,'Кастомка');	
		

		$timeLoad = time() - $timeLoad;
		echo "Время загрузки - ".$timeLoad. " сек.";
	?>
	</div>	
</body>
</html>