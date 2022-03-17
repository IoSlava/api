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

	function start()
	{
		$client = new Client(getConfig());
		if($client->loadToken()){ }
		else {
			$client->firstAuth();
			$client->saveToken();
		}	
		$lead = $client->leads()->getById(28095089);
		//$client->leads()->attachTask($lead,"Dfx",300,2);
	}

	function middleware()
	{
		try {
			start();
		}
		catch (\Throwable $e) {
			if(!getShowError()) die("Что-то пошло не так!");
			?>
			<div class = 'error'>
			<?= $e; ?> 
			</div>
		<?php	
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