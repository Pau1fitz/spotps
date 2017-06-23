<?php

	require 'vendor/autoload.php';

	$session = new SpotifyWebAPI\Session(
		'0166a3ba58ed48c6909baa64b6a1df62',
		'05d07d26d5984c15b75b6ac298399047',
		'http://10.16.214.82/presave/index.html'
	);

	$api = new SpotifyWebAPI\SpotifyWebAPI();

	if (isset($_POST)) {

		try {
			$session->requestAccessToken($_POST['code']);
			$api->setAccessToken($session->getAccessToken());
			$refreshToken = $session->getRefreshToken();
			$userId = $api->me()->id;
			$playlistName = array("name"=> "Artist");
			$playlist = $api->createUserPlaylist($userId, $playlistName);
			$playlistId = $playlist->id;
			$content = file_get_contents('users.json');
			$tempArray = json_decode($content, true);

			if(empty($tempArray)){
				$tempArray = [];
			}

			$newData = [
 				"userId" => $userId,
				"refreshToken" => $refreshToken,
				"playlistId" => $playlistId
			];

			array_push($tempArray, $newData);
			$jsonData = json_encode($tempArray, JSON_PRETTY_PRINT);
			file_put_contents('users.json', $jsonData);
			print_r("success");

		} catch (SpotifyWebAPI\SpotifyWebAPIException $e) {
			echo $e->getMessage();
		}

	}

 ?>
