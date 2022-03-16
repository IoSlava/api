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
			'code' => 'def502000acd2510d3947dc7eb78765ec93ae6dfc7aae083597a6c0d0b0fc1a74da7d335ed3d85dfdb9058430285b1591b9119298758e979dafea1d152be00cc79c638b9e0c965d6fb0e3a4c1c3bd526c453dd34eda7e47f409afbd4a3154afb4f913907a4dad89fe996ab71ef45aeda0970ffe6107e59e8f269544ee7f1b262f7311fd1d6c02204cdc23cd0b1b406d3ad10fc0964d9a7043b67827bb2a37c9475a3ceda01c0006b72b03ddc16e5689a7c40ce5c269d624165fe7c4ed3260b0c28c8a9cd488e7241d7f8fd35da48fc0081c7b9d5fdd691252465e9953c2940e435424f30e71436e969c6264aa6730f9081ef154fcb3b2e62a3ef4e27ff195257ba32a07f1930037a145ccaa83442b6fdff154b14ab31503f3dfeb2dcb5bdf8faae588728bd3360ac8ed236b279ae71791314d6ab2e35fa611e572f4fda30ab32df7db4a993a171451f852eef92311f59fb51748a7a53fb7bb61c5cb4c7f01bb10bdc6cea09f50e4808517f9731f2d17ee4f03a78960e455b1ada182d4fc2c90e9134469a52dc1c1df86b4f8cd7b2138236d6b81c3512ad3120de17c462e89b0f0f1c93f9dc2ee9671af84a56e1891a284e6849e3d83b98f38b49eb',
			'redirect_uri' => 'https://example.com'
	    ]
	];
}

function getShowError()
{
	return $showError = true;
}