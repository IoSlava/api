<?php
namespace Api\Index;
use Api\Library\AmoCrm\Api as Client;
define('ROOT', __DIR__);
include ROOT.'/config/amoCrm.php';
include ROOT.'/Library/AmoCrm/load.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Api</title>
		<link rel="stylesheet" type="text/css" href="style/index.css">
	</head>
<body>
	<div class="content">
	<?php
		$timeLoad = time();
		$client = new Client(getConfig());
		if($client->loadToken()){ }
		else {
			$client->firstAuth();
			$client->saveToken();
		}	
		$lead = $client->leads()->getById(28277453);
	//	$lead->custom_fields[0]['values'][0]['value'] = "NAMES";
		$client->leads()->update($lead);
		// $params = [
		// 	'text' => 'lol'
		// ];
		// $client->leads()->attachNote($lead,'common',$params);
		// $lead->showNotes();
		$timeLoad = time() - $timeLoad;
		echo "Время загрузки - ".$timeLoad. " сек.";
	?>
	</div>	
</body>
</html>