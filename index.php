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
		$client = new Client(getConfig());
		if($client->loadToken()){ }
		else {
			$client->firstAuth();
			$client->saveToken();
		}	
		$item = $client->contacts()->getById(46162243);
		$item->fields['first_name'] = 'Sweet';
		$params = [
			'text' => 'Капт территории.'
		];
		$client->contacts()->attachNote($item,'common',$params);
		Aprint_r($item);
		// $item->fields['name'] = "San Francisco";
		// $client->companies()->update($item);
		// $item->fields['name'] = "Groove Stree Gang";
		// $client->companies()->update($item);
		// Aprint_r($item);
		// $lead->updateCustomFieldById(820263,"YOU");
		//$client->leads()->update($lead);
		$timeLoad = time() - $timeLoad;
		echo "Время загрузки - ".$timeLoad. " сек.";
	?>
	</div>	
</body>
</html>