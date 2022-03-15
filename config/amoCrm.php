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
			'client_id' => '629d8e33-b064-4847-8fe9-3acd5c322272',
			'widget' => 'o36t8jed3tunlxlig58uj58ogisjdjwiovcihahy',//Не знал, однако нужно добавлять данный параметр, если интеграция приватная!
			'client_secret' => 'Naf6OTJbH952lejos8MRqoydXF9nwm7MxIwpuYWcvbcP9HuV1698pMiRURD7x39j',
			'grant_type' => 'authorization_code',
			'code' => 'def5020039e809884602aae04f271e01c1b4c2d3cc020fe217ff3ce119111c832bf01e005ebf4d63d69f7c93a6dcec41f37398c0b134934f2ac3e797286feb2e04aaaaef19b2dc3fe4ab146902459d46f5adf977b63c27ef32e6524d347b8f6faace42f835f0c3b03b0e1cc234835fb644444983c8ba606a4e6fd69ec9157442fc8dd76ae19f6492d6591d3add9227af4c610dbfade946431bd65296971358b14a07c6bbd3970ebde096690ebb271c8ea9056aca1a7bf9c32c13d3698a1b819b337c70297ce4eb28f62bfbdbadb47ea6dd913fdb36a939674f26ca67f06212f7a067452e76f5fe44eee9f2f43f5b9d57e586eae5d456ffb13902e2cd5ac27a65f17142979b511034d4a2337e0499b4dc8f3fad1cd8418db5e92214bfed5abab23ea22be75d666024d3ba46241e41667408ae20f739a6ada40b7ffc7b98bdd62bfbe9c01bcf5a443d3927c75cf7efe60022a53333c19b4a4a31e4a7175183957d1cf6757f8dd3d287e0bd1cdd011f50115689e5100f4d7b1ff21d63ccdbcdb4054198ebe048e645739ddbac27852f805a1da4a4b3b7339160eec369e3c7803737a5af4302cbfa69a3785737e8153153c4e212d0f96cd5c7af56c1a3s',
			'redirect_uri' => 'https://example.com'
	    ]
	];
}