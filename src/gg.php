<?php
require './vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    // $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);

    $client->setScopes(array(
        Google_Service_Sheets::SPREADSHEETS,
        Google_Service_Sheets::DRIVE,
        Google_Service_Sheets::DRIVE_FILE)
    );

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


// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
//$spreadsheetId = '1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms';
$spreadsheetId = '1XORhL7axG-4xe0x-EnbiCci11pNwL5OqdlTVdHIMGjI';
$range = 'MBox!A2:L';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

if (empty($values)) {
    print "No data found.\n";
} else {
    print "Name, Major:\n";
    foreach ($values as $row) {
        // Print columns A and E, which correspond to indices 0 and 4.
        printf("%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s\n", 
			$row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], 
			$row[7], $row[8], $row[9], $row[10], $row[11]);
    }
}


$currentRow 	= 2;

foreach($values as $row) {

	$updateRange	= 'H'.$currentRow;
	$updateBody 	= new Google_Service_Sheets_ValueRange([
		'range'	=>	$updateRange,
		'majorDimension' =>	'ROWS',
		'values' => ['values' => date('c')],
	]);

	$service->spreadsheets_values->update(
		$spreadsheetId,
		$updateRange,
		$updateBody,
 		['valueInputOption' => 'USER_ENTERED']
	); 

	$currentRow = $currentRow+1;

}



?>
