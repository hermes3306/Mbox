<?php
/*
 * Copyright 2018, LEE& COMPANY, INC.
 *
 *     http://waffle.at
 *
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

	$mbox_home	=	__DIR__;
	require     $mbox_home . '/vendor/autoload.php';
	require     $mbox_home . '/mbox.php';
	require     $mbox_home . '/visitor.php';
	require     $mbox_home . '/ggsheet.php';


	$BCC = "6Ave54Street@gmail.com";
	//$BCC = "kwangmin.lee@waffle.at";
	$CC  = "joonho.park@hotmail.com";
 

	$subjects =	[
		"1.html" => "Rating Request",
		"R.html" => "One free beer",
		"L.html" => "10% discount / Special event invitation",
		"B.html" => "Happy Birthday",
		"O.html" => "One free beer and Introducing new beer",
	];
	
	$email_template = [
		"1.html" => [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"Thanks for stopping. Can you please rate us with the below URL:", 
			"{{event}}"	=>	"http://www.zxvcom.com/rating/d",
			"{{con3}}"	=>	"Have a great day!",
			"{{con4}}"	=>	"Thanks again.", 
			"{{con5}}"	=>	"<br><br><br><br>Best regards, <br>ZXV", 
						],
		"R.html" => [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"Great to you see again. You can use our One free beer coupon as below:", 
			"{{coupon}}"	=>	"Coupon #####",
			"{{con3}}"	=>	"Have a great day!",
			"{{con4}}"	=>	"Thanks again.", 
			"{{con5}}"	=>	"<br><br><br><br>Best regards, <br>ZXV", 
						],
		"L.html"	=> [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"It looks like you love GIBH!. We offer a 10% coupon and event invitation in the sense of gratitude.", 
			"{{coupon}}"	=>	"10% Coupont ######",
			"{{event}}"	=>	"http://xxx.xxx.xxx/event/invitation/customerid",
			"{{con4}}"	=>	"Have a great day!",
			"{{con5}}"	=>	"Thanks again.", 
			"{{con6}}"	=>	"<br><br><br><br>Best regards, <br>ZXV", 
						],
		"B.html"	=> [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"Happy Birthday!. We offer a 15% birthday coupon.", 
			"{{coupon}}"	=>	"15% Coupon #####",
			"{{con3}}"	=>	"Have a great day!",
			"{{con4}}"	=>	"Thanks again.", 
			"{{con5}}"	=>	"<br><br><br><br>Best regards, <br>ZXV", 
						],
		"O.html"	=> [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"We have not seen you for a while, We are missing you. We offer One free beer coupon as below and introduct a new new beer as below:",
			"{{coupon}}"	=>	"10% Coupont ######",
			"{{event}}"	=>	"http://xxx.xxx.xxx/event/intro_new_beer/customerid",
			"{{con4}}"	=>	"Have a great day!",
			"{{con5}}"	=>	"Thanks again.", 
			"{{con6}}"	=>	"<br><br><br><br>Best regards, <br>ZXV", 
						],
	];


	$mbox = new mbox(__DIR__ . '/ZXV.ini');
	$ggsheet = new ggsheet();
	$ggsheet->spreadsheetId = '1oyKX1Vkls8vri7GbCagxYNB_zN6SPnpPN6xlrtwbxeA';


	$MYVISITORS = $ggsheet->info();

    $categorizedVisitors = $ggsheet->getCategorizedVisitors();

    printf("\n\n-------------- 1회방문(RR) -------------------- \n");
    $visitors = $categorizedVisitors['1회방문'];
	foreach($visitors as $v) {
		$v->print2();
		$t_name = "1.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);
		$mbox->mail->addCC($CC);

		$mbox->mail->Subject =	$subjects[$t_name] . ' for '. $v->sns ;
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$email_template[$t_name]["{{coupon}}"] = $v->coupon_num;

		$mbox->setTemplate($t_name, $email_template[$t_name]);
		$mbox->send();

		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_mail_dt', $today);
	}


    printf("\n\n-------------- 2~4회방문(C) -------------------- \n");
    $visitors2 = $categorizedVisitors['2회방문'];
    $visitors3 = $categorizedVisitors['3회방문'];
    $visitors4 = $categorizedVisitors['4회방문'];
	$visitorsR = array_merge($visitors2, $visitors3);
	$visitorsR = array_merge($visitorsR, $visitors4);

	foreach($visitorsR as $v) {
		$v->print2();
		$t_name = "R.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);
		$mbox->mail->addCC($CC);

		$mbox->mail->Subject =	$subjects[$t_name] . ' for '. $v->sns ;
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$email_template[$t_name]["{{coupon}}"] = $v->coupon_num;
		//$email_template[$t_name]["{{event}}"] = "http://xx.xx.xx/Revisitor/$v->id";

		$mbox->setTemplate($t_name, $email_template[$t_name]);
		$mbox->send();
		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_mail_dt', $today);
	}

    printf("\n\n-------------- 5회이상 (Loyal, C, U) -------------------- \n");
    $visitors5 = $categorizedVisitors['5회이상'];
    $visitorsL = $categorizedVisitors['우수고객'];
	$visitorsL = array_merge($visitorsL, $visitors5);

	foreach($visitorsL as $v) {
		$v->print2();
		$t_name = "L.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);
		$mbox->mail->addCC($CC);

		$mbox->mail->Subject =	$subjects[$t_name] . ' for '. $v->sns ;
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$email_template[$t_name]["{{coupon}}"] = $v->coupon_num;
		$email_template[$t_name]["{{event}}"] = "http://xx.xx.xx/Loyarlevent/$v->id";

		$mbox->setTemplate($t_name, $email_template[$t_name]);
		$mbox->send();
		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_issue_dt', $today);
	}

    printf("\n\n-------------- LOST C(C,U) -------------------- \n");
    $visitorsH = $categorizedVisitors['휴먼고객'];
	foreach($visitorsH as $v) {
		$v->print2();
		$t_name = "O.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);
		$mbox->mail->addCC($CC);

		$mbox->mail->Subject =	$subjects[$t_name] . ' for '. $v->sns ;
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$email_template[$t_name]["{{coupon}}"] = $v->coupon_num;
		$email_template[$t_name]["{{event}}"] = "http://xx.xx.xx/Invitaion/$v->id";

		$mbox->setTemplate($t_name, $email_template[$t_name]);
		$mbox->send();
		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_sent_dt', $today);
	}

	$ggsheet->uploadVisitorsAt($MYVISITORS,2);


?>
