<?php

	require 'vendor/autoload.php';

	$session = new SpotifyWebAPI\Session(
	'0166a3ba58ed48c6909baa64b6a1df62',
	'05d07d26d5984c15b75b6ac298399047',
	'REDIRECT_URI'
	);

	$api = new SpotifyWebAPI\SpotifyWebAPI();

	if (isset($_GET['code'])) {
	$session->requestAccessToken($_GET['code']);
	$api->setAccessToken($session->getAccessToken());

	print_r($api->me());
	} else {
	$options = [
		'scope' => [
			'user-read-email',
			'playlist-read-private',
			'playlist-read-collaborative',
			'playlist-modify-public',
			'playlist-modify-private'

		],
	];

	header('Location: ' . $session->getAuthorizeUrl($options));
	die();
	}


 ?>
