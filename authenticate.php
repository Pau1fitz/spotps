<?php

	require 'vendor/autoload.php';

	$session = new SpotifyWebAPI\Session(
		'0166a3ba58ed48c6909baa64b6a1df62',
		'05d07d26d5984c15b75b6ac298399047',
		'http://10.16.214.82/presave/index.html'
	);

	$api = new SpotifyWebAPI\SpotifyWebAPI();

	$options = [
		'scope' => [
			'user-read-email',
			'playlist-read-private',
			'playlist-modify-public',
			'playlist-modify-private'
		],
	];

	header('Location: ' . $session->getAuthorizeUrl($options));
	die();

?>
