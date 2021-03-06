<?php
use player128\AmoApi\AmoApi as Client;
use function player128\AmoApi\Support\Aprint_r;
define('ROOT', __DIR__);

include ROOT.'/config/amoCrm.php';
include ROOT.'/player128/amoapi/src/load.php';
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
		$code = 'def50200c300d93c9f22e9788220cf24b27b709503fbdacbe2c04aafeab553bde2b0343d303c110e6fcb761fde4dbc4c5027577e6990fb46335950c5c6ce0f98b27e05686d92c3cff4c8dceaccb7c02df02cd8b04f7d861f2d8e6447a65d75d25b06e598f26e5dbe133acba6c3ec2030946a2ce86db8938839453935db02453c772048f43cd87fd5ca88d3d4b4ae7e4e18123ee347be08764869a2e220bdf31fa02d9de28edc400acb46a6db42f80a7e5682d1e2059c68fe39bcd8f1e9d4b9f37b38a132e44f5f5926f469d4903ea33305670a11528c9475c046070c7c3c450fda7d06ba0f654a3fbcc9f529ce6b1dab69990210b97a8ed77b751eced97ca1da1d36d2f6aa8245cff1d0693476391fc3a4b270e02c3a169027969aa91267eae12c85c7ca15147b715246127f0d979b77bbdb53cbf77713387d7d6e968d5c7a57e330bcf0a22e3615418b1326069c0aabd99b5857d423be84e9b6411cf8138358d91725a5692c39db30f1579b9130087e611877fedea58c0f5bfac38c93a27c70318c31c0bf9fffdc1e1f76ffece67e3091a88d264c4e68b56cd611ebcde4bed717248243d96a98720abb7ae0e1746157afdefa9099a91b90f33492';
		// Создание объекта клиента и передача ему в конструктор данных для доступа к AmoCrm
		if (getConfig('dlatestov')) $client = new Client(getConfig('dlatestov'),$code);
		else exit('Что-то пошло не так');
		
		// $lead = $client->leads()->getById(28892901);//28892901

		//46263893 - comp
		//46263837 - cont
		//28892901 - lead

		//$client->tests()->Test6($client, 3, 46263893, 821947, 'XACV SQUAD', 0); 
		// Aprint_r($client->contacts()->getById(46263837));

		$timeLoad = time() - $timeLoad;
		echo "Время загрузки - ".$timeLoad. " сек.";
	?>
	</div>	
</body>
</html>