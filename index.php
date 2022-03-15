<?php
namespace Api\Index;
use Api\Library\AmoCrm\Api as Client;


define('ROOT', __DIR__);

include ROOT.'/config/amoCrm.php';
include ROOT.'/config/site.php';
include ROOT.'/config/mysql.php';
include ROOT.'/Library/AmoCrm/load.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?= $title;?></title>
		<link rel="stylesheet" type="text/css" href="style/index.css">
	</head>
<body>
	<div class="content">
	<?php
	function start()
	{
		$client = new Client(getConfig());

		if($client->loadToken()){ }
		else 
		{
			$client->firstAuth();
			$client->saveToken();
		}	

		$lead = $contacts = $client->leads()->getById(28742313);
		// $lead->fields['name'] = 'Много денег';
		// $client->leads()->update($lead);
		// $lead = $client->leads()->create('Ура');
		$params = [
			'text' => 'Привет'
		];
		$client->leads()->attachNote($lead,"common",$params);
		// Aprint_r($lead);

		// Aprint_r($lead);
		//if($lead !== false) $client->leads()->attachNote($lead,"Отдохни","common");
	}

	function middleware()
	{
		try 
		{
			start();
		}
		catch (\Throwable $e) 
		{
			echo "<div class = 'error'>";
			echo $e;
			echo "</div>";
		}
	}

	function main()
	{
		middleware();
	}

	main();
	?>
	</div>	
</body>
</html>