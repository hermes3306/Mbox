<?php
/*
 * Copyright 2018, LEE& COMPANY, INC. 
 *
 *     http://waffle.at
 *
 */
namespace App\Classes;

use Google_Client;
use Google_Service_Sheets;

class ggsheet
{
  public $client;
  public $spreadsheetId;
  public $range;
  public $sheetName;
  public $colFrom;
  public $colTo;
  public $rowFrom;
  public $service;

  public function __construct()
  { 
	$this->client 	       = $this->getClient();
 	//$this->spreadsheetId   = '1DY4zTKkswLxduWoxywqEWrCrX5MhWGvD-A0iszHoaPI';
 	$this->spreadsheetId   = '1oyKX1Vkls8vri7GbCagxYNB_zN6SPnpPN6xlrtwbxeA';
	$this->sheetName	   = 'Today';
	$this->colFrom 		   = 'A';
	$this->rowFrom 		   = '2';
	$this->colTo 		   = 'L';
	$this->range		   =
			 "$this->sheetName!$this->colFrom$this->rowFrom:$this->colTo";
	$this->service = new Google_Service_Sheets($this->client);
  }

  function getClient() {
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    // $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);

    $client->setScopes(array(
        Google_Service_Sheets::SPREADSHEETS,
        Google_Service_Sheets::DRIVE,
		Google_Service_Sheets::DRIVE_FILE)
    );

    $client->setAuthConfig(__DIR__ . '/credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    $tokenPath = __DIR__ . '/token.json';
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

  public function getRowNum () {
	$service = $this->service;
	$spreadsheetId = $this->spreadsheetId;
	$range = $this->range;
	$response = $service->spreadsheets_values->get($spreadsheetId, $range);
	$values = $response->getValues();
	return count($values);
  }

  public function uploadVisitorsAt($visitors,$rownum) {
	$service = $this->service;
	$spreadsheetId = $this->spreadsheetId;
	$range = "$this->sheetName!$this->colFrom$rownum:$this->colTo";

	$values = array();
	foreach($visitors as $visitor) {
		$arr =  [
			$visitor->id,
      		$visitor->sns,
      		$visitor->email,
      		$visitor->collect_dt,
 		    $visitor->visit_cnt,
     		$visitor->visit_dt,
    	 	$visitor->mail_ty,
      		$visitor->coupon_num,
      		$visitor->fv_mail_dt,
      		$visitor->rv_mail_dt,
      		$visitor->lv_mail_dt,
      		$visitor->hv_mail_dt,
      		$visitor->coupon_used_dt
		];
		array_push($values,$arr);
	}
	$body = new Google_Service_Sheets_ValueRange([
    	'values'    => $values
	]);
	$params = [ 'valueInputOption' => 'USER_ENTERED' ];
	$result = $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
  }

  public function uploadVisitors($visitors) {
	$service = $this->service;
	$spreadsheetId = $this->spreadsheetId; $currentRow = $this->getRowNum() + 1;
	$this->uploadVisitorsAt($visitors, $currentRow);
  }

  public function info() {
	$service = $this->service;
	$spreadsheetId = $this->spreadsheetId;
	$range = $this->range;
	$response = $service->spreadsheets_values->get($spreadsheetId, $range);
	$values = $response->getValues();

	$visitors = array();
	if (empty($values)) {
    	print "No data found.\n";
	} else {
    	foreach ($values as $row) {
    		$visitor = new visitor( 
						(is_null($row[0]) ? "-" : $row[0]),
						(is_null($row[1]) ? "-" : $row[1]),
						(is_null($row[2]) ? "-" : $row[2]),
						(is_null($row[3]) ? "-" : $row[3]),
						(is_null($row[4]) ? "-" : $row[4]),
						(is_null($row[5]) ? "-" : $row[5]),
						(is_null($row[6]) ? "-" : $row[6]),
						(is_null($row[7]) ? "-" : $row[7]),
						(is_null($row[8]) ? "-" : $row[8]),
						(is_null($row[9]) ? "-" : $row[9]),
						(is_null($row[10]) ? "-" : $row[10]),
						(is_null($row[11]) ? "-" : $row[11]),
						 "-","-");

		array_push($visitors, $visitor);
		}
	}
	$currentRow = count($values);
	return $visitors;
  }

  public function getCategorizedVisitors() {
	$visitors = $this->info();

    $visitors1 = array();
    $visitors2 = array();
    $visitors3 = array();
    $visitors4 = array();
    $visitors5 = array();
    $visitorsL = array();
    $visitorsH = array();

    foreach($visitors as $visitor) {
        $newvisitor = new visitor(
			$visitor->id,
      		$visitor->sns,
      		$visitor->email,
      		$visitor->collect_dt,
 		    $visitor->visit_cnt,
     		$visitor->visit_dt,
    	 	$visitor->mail_ty,
      		$visitor->coupon_num,
      		$visitor->fv_mail_dt,
      		$visitor->rv_mail_dt,
      		$visitor->lv_mail_dt,
      		$visitor->hv_mail_dt,
      		$visitor->coupon_used_dt
        );

        switch($visitor->mail_ty) {
            case '1회방문': array_push($visitors1, $newvisitor); break;
            case '2회방문': array_push($visitors2, $newvisitor); break;
            case '3회방문': array_push($visitors3, $newvisitor); break;
            case '4회방문': array_push($visitors4, $newvisitor); break;
            case '5회이상': array_push($visitors5, $newvisitor); break;
            case '우수고객': array_push($visitorsL, $newvisitor); break;
            case '휴먼고객': array_push($visitorsH, $newvisitor); break;
        }
    }
	$ret = [
		'1회방문' => $visitors1, 
		'2회방문' => $visitors2, 
		'3회방문' => $visitors3, 
		'4회방문' => $visitors4, 
		'5회이상' => $visitors5, 
		'우수고객' => $visitorsL, 
		'휴먼고객' => $visitorsH, 
	];
	return $ret;
  }

  public function search($mail_ty) {
	$service = $this->service;
	$spreadsheetId = $this->spreadsheetId;
	$range = $this->range;
	$response = $service->spreadsheets_values->get($spreadsheetId, $range);
	$values = $response->getValues();

	$visitors = array();
	if (empty($values)) {
    	print "No data found.\n";
	} else {
    	foreach ($values as $row) {
    		$visitor = new visitor( $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7],
            			$row[8], $row[9], $row[10], $row[11] );
			if($visitor->mail_ty == $mail_ty) {
				array_push($visitors, $visitor);
			}
		}
	}
	$currentRow = count($visitors);
	print("Total Row: $currentRow \n");
	return $visitors;
  }

  public function replace($visitors, $email, $key, $val) {
	foreach($visitors as $v) {
		if($v->email == $email) {
			switch($key) {
				case "fv_mail_dt"  		: $v->fv_mail_dt = $val; break;
				case "rv_mail_dt"  		: $v->rv_mail_dt = $val; break;
				case "lv_mail_dt"  		: $v->lv_mail_dt = $val; break;
				case "hv_mail_dt"  		: $v->hv_mail_dt = $val; break;
				case "coupon_used_dt"  	: $v->yypcoupon_sent_dt = $val; break;
			}
		}
	}
  }

  public function visitors2GGvalues($visitors) {
	$values = array();
        foreach($visitors as $visitor) {
                $arr =  [
                        $visitor->id,
                $visitor->sns,
                $visitor->email,
                $visitor->collect_dt,
                    $visitor->visit_cnt,
                $visitor->visit_dt,
                $visitor->mail_ty,
                $visitor->coupon_num,
                $visitor->coupon_mail_dt,
                $visitor->coupon_issue_dt,
                $visitor->coupon_sent_dt,
                $visitor->coupon_used_dt
                ];
                array_push($values,$arr);
        }
	return $values;
  }
	
  


}
