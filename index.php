<?php
use Api\Library\AmoCrm\AmoApi as Client;
define('ROOT', __DIR__);
// Функция для 'красивого' вывода массиово и объектов
function Aprint_r($array)
{
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}
// Вывод значения с переносом до и после строки
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
		if (getConfig('dlatestov')) $client = new Client(getConfig('dlatestov'));
		else exit('Что-то пошло не так');
		// Проверка: был ли загружен токен из файла
		if($client->loadToken()){ echo "Токен есть!";}
		// Иначе: происходит первичная авторизация и сохранение токена в файл	
		else {
			$code = 'def50200c300d93c9f22e9788220cf24b27b709503fbdacbe2c04aafeab553bde2b0343d303c110e6fcb761fde4dbc4c5027577e6990fb46335950c5c6ce0f98b27e05686d92c3cff4c8dceaccb7c02df02cd8b04f7d861f2d8e6447a65d75d25b06e598f26e5dbe133acba6c3ec2030946a2ce86db8938839453935db02453c772048f43cd87fd5ca88d3d4b4ae7e4e18123ee347be08764869a2e220bdf31fa02d9de28edc400acb46a6db42f80a7e5682d1e2059c68fe39bcd8f1e9d4b9f37b38a132e44f5f5926f469d4903ea33305670a11528c9475c046070c7c3c450fda7d06ba0f654a3fbcc9f529ce6b1dab69990210b97a8ed77b751eced97ca1da1d36d2f6aa8245cff1d0693476391fc3a4b270e02c3a169027969aa91267eae12c85c7ca15147b715246127f0d979b77bbdb53cbf77713387d7d6e968d5c7a57e330bcf0a22e3615418b1326069c0aabd99b5857d423be84e9b6411cf8138358d91725a5692c39db30f1579b9130087e611877fedea58c0f5bfac38c93a27c70318c31c0bf9fffdc1e1f76ffece67e3091a88d264c4e68b56cd611ebcde4bed717248243d96a98720abb7ae0e1746157afdefa9099a91b90f33492';
			$client->firstAuth($code);
			$client->saveToken();
		}	
		$client->showToken();

		//$lead = $client->lead()->getById(28733589);//28733589
		//$lead->fields['price'] = 1500; 
		//$client->lead()->update($lead);
		$client->lead()->create('Новая сделка');
		//Aprint_r($lead);
		// Тесты на нахождение сущностей по id
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
		// Тесты на изменение полей сущностей
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
		// Тесты на создание сущностей 
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
		// Тесты на добавление примечания к сущностям
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
		// Тесты на добавление задачи к сущностям
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
		// Тесты на изменение значения кастомного поля
		function Test6($client,$n,$id,$idCustom,$value,$index)
		{
			switch($n){
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
		
		$timeLoad = time() - $timeLoad;
		echo "Время загрузки - ".$timeLoad. " сек.";
	?>
	</div>	
</body>
</html>