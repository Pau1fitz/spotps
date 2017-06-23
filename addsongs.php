<?php

	require 'vendor/autoload.php';

	$session = new SpotifyWebAPI\Session(
		'0166a3ba58ed48c6909baa64b6a1df62',
		'05d07d26d5984c15b75b6ac298399047',
		'http://10.16.214.82/presave/addsongs.php'
	);

	$api = new SpotifyWebAPI\SpotifyWebAPI();

	if (isset($_GET['code'])) {

		try {

			$session->requestAccessToken($_GET['code']);
			$api->setAccessToken($session->getAccessToken());
			$userId = $api->me()->id;
			$content = file_get_contents('users.json');
			$tempArray = json_decode($content, true);

			foreach($tempArray as $item) {

				$session->refreshAccessToken($item["refreshToken"]);
				$accessToken = $session->getAccessToken();
				$api->setAccessToken($accessToken);
				$api->replaceUserPlaylistTracks($item["userId"], $item["playlistId"], "spotify:track:0wQnkKwvtRt4U9MEjOfRMp");

				echo "successfully added for " . $item["userId"] . " ";

			}

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
