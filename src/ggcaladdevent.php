<?php
/*
 * Copyright 2018, LEE& COMPANY, INC.
 *
 *     http://waffle.at
 *
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mbox_home  =   getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
require     $mbox_home . '/vendor/autoload.php';
require     $mbox_home . '/src/mbox.php';
require     $mbox_home . '/src/visitor.php';
require     $mbox_home . '/src/ggsheet.php';

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Calendar API PHP Quickstart');
    $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
    $client->setAuthConfig('credentials-cal.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token-cal.json';
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
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
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
$service = new Google_Service_Calendar($client);

// Print the next 10 events on the user's calendar.
$calendarId = 'primary';
$optParams = array(
  'maxResults' => 100,
  'orderBy' => 'startTime',
  'singleEvents' => true,
  'timeMin' => date('c'),
);
$results = $service->events->listEvents($calendarId, $optParams);
$events = $results->getItems();

$nextweek = strtotime("+4 week"); 

$schedule = array();
if (empty($events)) {
    print "No upcoming events found.\n";
} else {
    print "Upcoming events: \n";
    foreach ($events as $event) {
        $start = $event->start->dateTime;
		/*
		printf("%s", gettype($start));
		$newtime = date('Y-m-d H:i:s', $time);
		printf("%s", $newtime);
		*/
		
		$time = strtotime($start);
		if ($time > $nextweek) break;

        if (empty($start)) {
            $start = $event->start->date;
        }

		$yoil = array("일","월","화","수","목","금","토");
		$y = $yoil[date('w',strtotime($start))];
		$start1 = date('m/d', strtotime($start));
		$start2 = date('H:i', strtotime($start));
        printf("%s(%s), %s - %s \n",$start1,$y,$start2,$event->getSummary());
		$evt = $event->getSummary();
		$sche = "$start1($y), $start2 - $evt";
		array_push($schedule, $sche);
    }
}



// Refer to the PHP quickstart on how to setup the environment:
// https://developers.google.com/calendar/quickstart/php
// Change the scope to Google_Service_Calendar::CALENDAR and delete any stored
// credentials.

$event = new Google_Service_Calendar_Event(array(
  'summary' => 'Smart City Business Day 11/29/2018, 14:00~18:00',
  'location' => '창조경제융합센터',
  'description' => 'Smart IoT City Business Reference case studies.',
  'start' => array(
    'dateTime' => '2018-11-29T14:00:00-18:00',
    'timeZone' => 'Asia/Seoul',
  ),
  'end' => array(
    'dateTime' => '2018-11-30T14:00:00-18:00',
    'timeZone' => 'Asia/Seoul',
  ),
  'recurrence' => array(
    'RRULE:FREQ=DAILY;COUNT=2'
  ),
  'attendees' => array(
    array('email' => 'jason.park@altibase.com'),
  ),
  'reminders' => array(
    'useDefault' => FALSE,
    'overrides' => array(
      array('method' => 'email', 'minutes' => 24 * 60),
      array('method' => 'popup', 'minutes' => 10),
    ),
  ),
));


$calendarId = 'primary';
$event = $service->events->insert($calendarId, $event);
printf('Event created: %s\n', $event->htmlLink);
