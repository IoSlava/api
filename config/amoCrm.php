<?php 
function getConfig($name)
{
	$AmoConfig = [
		'dlatestov' => [
			'domain' => 'dlatestov',
			'client_id' => 'a35a5499-f0c8-4b3a-b744-3f3de76dd8b9',
			'client_secret' => 'EjR8dDAu5KLrRM0MwqFZaKbumFC5o4bfezEvgNrWNXT6EiIDZjiOSNtYFqNg7v4q',
			'redirect_uri' => 'https://example.com'	
		]
	];
	return isset($AmoConfig[$name]) ? $AmoConfig[$name] : false;
}

