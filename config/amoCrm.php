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
			'client_secret' => 'CvmY2z1UjgYV8897vCm2Yf4P4ctWPjrTE2Ae4eDhPmqBszSZrrDHGpv88KnTz3QC',
			'grant_type' => 'authorization_code',
			'code' => 'def502004cced312d723f8fa9ced959c56608d8413261463bdff55a8efd1704b31b041568218341ffdee6c6bb93a923c06661e8df76e6eb006cf7b28c90c4257f9f8fa2dd8b96cc6329b5fe62df432579aa26e51ced8828e529849ab9c65632014fefe07ee403293e4e3272ef5433c412e887a61f1b675a02ad95b3e63a30aa06604ab2ddea7944b9086189368e8380bb54a13bcb8d2b36e458b68296eba87d8bea34cbffa857d8633b9c892b977f06ba64d324c4b3abc872de7ce84d418001c32dfc55f7ea59441937b90807539b45a7f690844026ff12f6ffa9c673ed0ed9facd7b469d2f201b9bd8f57b721a7442eff6b821dcb7962b752ff83dae1914c52e2dc2193f583cba2f60cddc7fe270add97b135b0caeafd252c2eb54f87db32e4045b39546aee7e56ef528241e05954c5ffcc0e00c58130003d2d459ee9fb190f56eba780b898ff5baf1df5e123143f18e592fa284968e1ebc52ee58be96875bd33585e98672117b7a2b853c91b0272b294a56a2011ec5e7a05c9df26dc4b5a537b470000a2f8f06650a2a01b4bdf5c0236db73128ebc0ca1a59a7d5d7efc362a82145665df0338613768f4a6c2ce08c0f1542abbcc01931e64de3fs',
			'redirect_uri' => 'https://example.com'
	    ]
	];
}

function getShowError()
{
	return $showError = false;
}