<?php
/*
 * Copyright 2018, LEE& COMPANY, INC. 
 *
 *     http://waffle.at
 *
 */

class ggdriver
{
  public $client;
  public $driver;

  public function __construct()
  { 
	$this->client 	       = $this->getClient();
	$this->driver = new Google_Service_Drive($this->client);
  }

  function getClient() {
    $client = new Google_Client();
    $client->setApplicationName('Google Driver API PHP Quickstart');

    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) { throw new Exception(join(', ', $accessToken)); }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
  }

  public function upload($path) {
    $driver = $this->driver;
    $file = new Google_Service_Drive_DriveFile();
    $result = $driver->files->insert($file, array(
  	'data' => file_get_contents($path),
 	 'mimeType' => 'application/octet-stream',
 	 'uploadType' => 'media'
    ));
  } 



}
