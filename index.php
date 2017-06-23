<?php

	require 'vendor/autoload.php';

	$session = new SpotifyWebAPI\Session(
		'0166a3ba58ed48c6909baa64b6a1df62',
		'05d07d26d5984c15b75b6ac298399047',
		'http://10.16.214.82/presave/index.php'
	);

	$api = new SpotifyWebAPI\SpotifyWebAPI();

	if (isset($_GET['code'])) {

		try {
			$session->requestAccessToken($_GET['code']);
			$api->setAccessToken($session->getAccessToken());

			$refreshToken = $session->getRefreshToken();
			$userId = $api->me()->id;
			$content = file_get_contents('users.json');
			$tempArray = json_decode($content, true);

			print_r($userId);
			print_r($refreshToken);

			array_push($tempArray, ["userid"=>$userId, "refreshToken" => $refreshToken]);

			$jsonData = json_encode($tempArray);
			file_put_contents('users.json', $jsonData);

			$playlistName = array("name"=> "Test");

			$api->createUserPlaylist($userId, $playlistName);

		} catch (SpotifyWebAPI\SpotifyWebAPIException $e) {
		    echo $e->getMessage();
		}

	} else {

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
	}

 ?>
