<?php 

function Aprint_r($array)
{
	echo "<pre>";
	print_r($array);
	echo "</pre>";
	return true;
}

function getConfig()
{
	return $AmoConfig = [
		'domain' => 'dlatestov',
		'login' => [
			'client_id' => 'a35a5499-f0c8-4b3a-b744-3f3de76dd8b9',
			'widget' => 'wcdlu1koh7xyxqpwpk5m4arlkbcdknsz9jmrrao4',
			'client_secret' => 'EjR8dDAu5KLrRM0MwqFZaKbumFC5o4bfezEvgNrWNXT6EiIDZjiOSNtYFqNg7v4q',
			'grant_type' => 'authorization_code',
			'code' => 'def50200aff21041f35a12e98a51b7c4502de0a5db2467bc8ca2939d6de3abb23317f7082ae52d7b22524ae0b6546495a6a34e84e68717c0ad2791605fb18c09fa59c1ccbfaf1566d630169499f3ebd65753f076695acd650d1825628cf4103398f4fc9a36cd5a4893e7249ad51b9651fa1e05e521b1f8b2b1d0e6492f4d395dcd87571dbee001b3aa9fc926c9adb00ed09780067de7a349ae5ef19b134f40a4406376fcd59df51276d59b5f7fda3230a4c8a5851027d2d22a7eb1d35f2327e16d6768fb3bb97973e64f2d1b71fa36e98de293370f3e15d04a2369859fd5e599336b10bcc3f579cfd3bcc1c23fdda72704591dbadc07499d2cde75fc094f8eadc94f56282c6d00762c65097e6c44f1ea166d4255dee381a9a814349d17e3d68ee11efc2422ffac0362e14433afc73f75dd82d0a26b12a9ef936a156a0ca0c5248278f5d34c396bc86c309ee41fe308b7a5fea51896e991f4690242639bb0f9d5aecc4c830725d1ef85ec2b06f7cafe82987359795ca92c8dc9207c11fbc08bcc51378524dcd28015c583a758f5c8d996dd5ae1374cf40f445993c89320a32cac57d63eaa9e144605a5fa0fc7338441713a0f1b3bfb6718127b48bb',
			'redirect_uri' => 'https://example.com'
	    ]
	];
}

function getShowError()
{
	return $showError = false;
}

function Aecho($value)
{
	echo "<br>".$value."<br>";
}