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
			'code' => 'def50200856bbe872eca8c6e4b874acac28b5cd0814164cb2cf4924ab23f15a9fd5e3b15cad0a5541e566101629cd5f95e4d7c2b6dd0e10eaa2f725a4e9fc6b7d06260acaa9df0e75a9431328221a9be721c84aef5590c971b447b3ce528677f877da46a4cdabcf5d4e74b4635aed81f4db931832a4534675ecbe72d4cc374f99d270442ec40fbf3d7541a0aff660b599d15fb463cc4a92bd3d8835c6baa487e6ba78397a9c8f495c7d08e9fe6cb6ac598001072363e82bc0580df1639432bf70c68e9a6896ef54092ffe789187e80a042493e544ab5837b1f035c4623955dfb61cca6fedae43f61f68d931ae7437138498204a51b37f5c6bfc9164dd438678483d79cb285bc8b44e35ca2139873cc236a2fd4433b3393c51ac54a53665978c3f1f98845bab68a330d02d4dcba5762014a01891eda4ac719241bad53b1a78e3b205f794eb8135b18b4e31321bc5f9f8b56fb9d5a0d6d41e7f3c173ccfb446b40aa04a235dcd9056a9fb42403eba157adc1a3b5971fb92f90f5e0160737770f9d9d2f2a5385fcbe4bfc72d8835837145ff773403b5180596182ea510093fc987ef8cf2dac1ae426525514e528f6897e8607a2be10e113d62dc5a02b',
			'redirect_uri' => 'https://example.com'
	    ]
	];
}

function getShowError()
{
	return $showError = true;
}