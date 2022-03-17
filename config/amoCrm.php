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
			'widget' => 'o36t8jed3tunlxlig58uj58ogisjdjwiovcihahy',
			'client_secret' => 'Naf6OTJbH952lejos8MRqoydXF9nwm7MxIwpuYWcvbcP9HuV1698pMiRURD7x39j',
			'grant_type' => 'authorization_code',
			'code' => 'def50200942463058eb85bf373be82334df4e432066b0e66ed82f2a1644284e249ae283719e9c1cf89282ff07ac8e843d101f83bbcd4be6bddddacdd8db1c81703cbf2d7e8af59c02d9d5d08a1cc5aedd2ad47211ba56d40d01fcc11b96a0ed556b3f6f44f35c6300f0c37359608fcdedfb20a57c77f03e3f5acecf0f2c9f0fa4df8bc01b91041d46763b1c11b4af2c6b975dab4d7243da163865d9af527203f483622e539df47595334bcb4c89f45d10d9eed1d0730f73779cdbac6ebf9ac8cc8b5387b37c315eceeca10d365c5da6266976c62ba343f88ca48b60908be4490c1fab4bf4bce84cad0eb495f55916a53e527b7b02a6b483898346fba670d09404129fc49c0308eae5638fd3977b22edbd97824f8f38c3f42b2803a3d26f927678c0bb04a789375e798b6fb39f64158fad80d1b0f4303a55c70fe2e3b83fd9dde364d6f82d123f6821778c1428aa1d7c96c00291b3eaf3db2a7509dde7ed07a86c2f2bade61b5c76c9d0a1bb64479b0fb95a0c28f32daa11963e80b3a4cbc16ac06e0232320555e1d324e516ff077e40b4589b01ddad20cb736e67c97caba294c72520c0f6011139d7d8619aa028d2422fc9440fbf9b25ad29492fa',
			'redirect_uri' => 'https://example.com'
	    ]
	];
}

function getShowError()
{
	return $showError = true;
}