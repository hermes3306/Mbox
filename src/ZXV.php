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

	$BCC = "6Ave54Street@gmail.com";
	$subjects =	[
		"1.html" => "Rating Request",
		"R.html" => "One free beer",
		"L.html" => "10% discount / Special event invitation",
		"B.html" => "Happy Birthday",
		"O.html" => "One free beer and Introducing new beer",
	]
	
	$email_template = [
		"1.html" => [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"Thanks for stopping. Can you please rate us with the below URL:", 
			"{{url}}"	=>	"http://xxx.xxx.xxx/rate/customerid",
			"{{con3}}"	=>	"Have a great day!",
			"{{con4}}"	=>	"Thanks again.", 
			"{{con5}}"	=>	"--<br> ZXV.", 
						],
		"R.html" => [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"Great to you see again. You can use our One free beer coupon as below:", 
			"{{coupon}}"	=>	"Coupon #####",
			"{{con3}}"	=>	"Have a great day!",
			"{{con4}}"	=>	"Thanks again.", 
			"{{con5}}"	=>	"--<br> ZXV.", 
						],
		"L.html"	=> [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"It looks like you love GIBH!. We offer a 10% coupon and event invitation in the sense of gratitude.", 
			"{{coupon}}"	=>	"10% Coupont ######",
			"{{url}}"	=>	"http://xxx.xxx.xxx/event/invitation/customerid",
			"{{con4}}"	=>	"Have a great day!",
			"{{con5}}"	=>	"Thanks again.", 
			"{{con6}}"	=>	"--<br> ZXV.", 
						],
		"B.html"	=> [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"Happy Birthday!. We offer a 15% birthday coupon.", 
			"{{coupon}}"	=>	"15% Coupon #####",
			"{{con3}}"	=>	"Have a great day!",
			"{{con4}}"	=>	"Thanks again.", 
			"{{con5}}"	=>	"--<br> ZXV.", 
						],
		"O.html"	=> [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"We have not seen you for a while, We are missing you. We offer One free beer coupon as below and introduct a new new beer as below:   
			"{{coupon}}"	=>	"10% Coupont ######",
			"{{url}}"	=>	"http://xxx.xxx.xxx/event/intro_new_beer/customerid",
			"{{con4}}"	=>	"Have a great day!",
			"{{con5}}"	=>	"Thanks again.", 
			"{{con6}}"	=>	"--<br> ZXV.", 
						],
	];


	$mbox = new mbox(__DIR__ . '/ZXV.ini');
	$ggsheet = new ggsheet();

	$MYVISITORS = $ggsheet->info();

    $categorizedVisitors = $ggsheet->getCategorizedVisitors();

    printf("\n\n-------------- 1회방문(RR) -------------------- \n");
    $visitors = $categorizedVisitors['1회방문'];
    foreach($visitors as $v) { $v->print2(); }

	foreach($visitors as $v) {
		$t_name = "1.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);

		$mbox->mail->Subject =	$subjects[$t_name];
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$email_template[$t_name]["{{coupon}}"] = $v->coupon_num;

		$mbox->setTemplate($t_name, $email_template[$t_name]);
		$mbox->send();

		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_mail_dt', $today);
	}


    printf("\n\n-------------- 2회방문(C) -------------------- \n");
    $visitors = $categorizedVisitors['2회방문'];
    foreach($visitors as $v) { $v->print2(); }

	foreach($visitors as $v) {
		$t_name = "R.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);

		$mbox->mail->Subject =	$subjects[$t_name];
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$email_template[$t_name]["{{coupon}}"] = $v->coupon_num;
		//$email_template[$t_name]["{{url}}"] = "http://xx.xx.xx/Revisitor/$v->id";

		$mbox->setTemplate($t_name, $email_template[$t_name]);
		$mbox->send();
		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_mail_dt', $today);
	}

    printf("\n\n-------------- 3회방문(C) -------------------- \n");
    $visitors = $categorizedVisitors['3회방문'];
    foreach($visitors as $v) { $v->print2(); }

	foreach($visitors as $v) {
		$t_name = "R.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);

		$mbox->mail->Subject =	$subjects[$t_name];
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$email_template[$t_name]["{{coupon}}"] = $v->coupon_num;
		//$email_template[$t_name]["{{url}}"] = "http://xx.xx.xx/Revisitor/$v->id";

		$mbox->setTemplate($t_name, $email_template[$t_name]);
		$mbox->send();
		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_issue_dt,', $today);
	}

    printf("\n\n-------------- 4회방문(C) -------------------- \n");
    $visitors = $categorizedVisitors['4회방문'];
    foreach($visitors as $v) { $v->print2(); }

	foreach($visitors as $v) {
		$t_name = "R.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);

		$mbox->mail->Subject =	$subjects[$t_name];
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$email_template[$t_name]["{{coupon}}"] = $v->coupon_num;
		//$email_template[$t_name]["{{url}}"] = "http://xx.xx.xx/Revisitor/$v->id";

		$mbox->setTemplate($t_name, $email_template[$t_name]);
		$mbox->send();
		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_issue_dt', $today);
	}

    printf("\n\n-------------- 5회이상 (Loyal, C, U) -------------------- \n");
    $visitors = $categorizedVisitors['5회이상'];
    foreach($visitors as $v) { $v->print2(); }

	foreach($visitors as $v) {
		$t_name = "L.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);

		$mbox->mail->Subject =	$subjects[$t_name];
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$email_template[$t_name]["{{coupon}}"] = $v->coupon_num;
		$email_template[$t_name]["{{url}}"] = "http://xx.xx.xx/Invitaion/$v->id";

		$mbox->setTemplate($t_name, $email_template[$t_name]);
		$mbox->send();
		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_issue_dt', $today);
	}

    printf("\n\n-------------- LOST C(C,U) -------------------- \n");
    $visitors = $categorizedVisitors['쿠폰'];
    foreach($visitors as $v) { $v->print2(); }

	foreach($visitors as $v) {
		$t_name = "c.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);

		$mbox->mail->Subject =	$subjects[$t_name];
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$email_template[$t_name]["{{coupon}}"] = $v->coupon_num;
		$email_template[$t_name]["{{url}}"] = "http://xx.xx.xx/Invitaion/$v->id";

		$mbox->setTemplate($t_name, $email_template[$t_name]);
		$mbox->send();
		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_sent_dt', $today);
	}
	$mbox->send();

	$ggsheet->uploadVisitorsAt($MYVISITORS,2);


?>
