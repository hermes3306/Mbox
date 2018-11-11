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
	$email_template = [
		"1.html" => [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"저희 매장을 처음 방문해주셔서 감사합니다.", 
			"{{con2}}"	=>	"오늘도 즐거운 하루 되세요",
			"{{con3}}"	=>	"감사합니다.", 
						],
		"2.html" => [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"저희 매장을 두번째 방문해주셔서 감사합니다.", 
			"{{con2}}"	=>	"오늘도 즐거운 하루 되세요",
			"{{con3}}"	=>	"감사합니다.", 
						],
		"3.html"	=> [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"저희 매장을 세번째 방문해주셔서 감사합니다.", 
			"{{con2}}"	=>	"오늘도 즐거운 하루 되세요",
			"{{con3}}"	=>	"감사합니다.", 
						],
		"4.html"	=> [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"저희 매장을 네번째 방문해주셔서 감사합니다.", 
			"{{con2}}"	=>	"오늘도 즐거운 하루 되세요",
			"{{con3}}"	=>	"감사합니다.", 
						],
		"5.html"	=> [
			"{{name}}"	=>	"Customer Name",
			"{{con1}}"	=>	"저희 매장을 다섯번 이상 방문해주셔서 감사합니다.", 
			"{{con2}}"	=>	"오늘도 즐거운 하루 되세요",
			"{{con3}}"	=>	"감사합니다.", 
						],
		"c.html" => [
			"{{name}}"	=>	"Customer Name",
			"{{coupon}}"	=>	"Coupon #######",
			"{{con1}}"	=>	"우수 고객님께 저희 특별 쿠폰을 발급 드립니다.", 
			"{{con2}}"	=>  "쿠폰을 제시하시면 무료로 제품을 드실수 있습니다.", 
			"{{con3}}"	=>	"감사합니다.", 
						],		
	];


	$mbox = new mbox($mbox_home . '/wfmail.ini');
	$ggsheet = new ggsheet();

	$MYVISITORS = $ggsheet->info();

    $categorizedVisitors = $ggsheet->getCategorizedVisitors();

    printf("\n\n-------------- 1회방문 -------------------- \n");
    $visitors = $categorizedVisitors['1회방문'];
    foreach($visitors as $v) { $v->print2(); }

	foreach($visitors as $v) {
		$t_name = "1.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$mbox->mail->Subject =	"1회방문($v->sns, $v->email)";
		$mbox->setTemplate($t_name, $email_template[$t_name]);
		//$mbox->send();

		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_mail_dt', $today);
	}


    printf("\n\n-------------- 2회방문 -------------------- \n");
    $visitors = $categorizedVisitors['2회방문'];
    foreach($visitors as $v) { $v->print2(); }

	foreach($visitors as $v) {
		$t_name = "2.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$mbox->mail->Subject =	"2회방문($v->sns, $v->email)";
		$mbox->setTemplate($t_name, $email_template[$t_name]);
		//$mbox->send();
		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_mail_dt', $today);
	}

    printf("\n\n-------------- 3회방문 -------------------- \n");
    $visitors = $categorizedVisitors['3회방문'];
    foreach($visitors as $v) { $v->print2(); }

	foreach($visitors as $v) {
		$t_name = "3.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$mbox->mail->Subject =	"3회방문($v->sns, $v->email)";
		$mbox->setTemplate($t_name, $email_template[$t_name]);
		//$mbox->send();
		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_issue_dt,', $today);
	}

    printf("\n\n-------------- 4회방문 -------------------- \n");
    $visitors = $categorizedVisitors['4회방문'];
    foreach($visitors as $v) { $v->print2(); }

	foreach($visitors as $v) {
		$t_name = "4.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$mbox->mail->Subject =	"4회방문($v->sns, $v->email)";
		$mbox->setTemplate($t_name, $email_template[$t_name]);
		//$mbox->send();
		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_issue_dt', $today);
	}

    printf("\n\n-------------- 5회이상 -------------------- \n");
    $visitors = $categorizedVisitors['5회이상'];
    foreach($visitors as $v) { $v->print2(); }

	foreach($visitors as $v) {
		$t_name = "5.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$mbox->mail->Subject =	"5회방문($v->sns, $v->email)";
		$mbox->setTemplate($t_name, $email_template[$t_name]);
		//$mbox->send();
		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_issue_dt', $today);
	}

    printf("\n\n-------------- 쿠폰 -------------------- \n");
    $visitors = $categorizedVisitors['쿠폰'];
    foreach($visitors as $v) { $v->print2(); }

	foreach($visitors as $v) {
		$t_name = "c.html";
		$mbox->mail->ClearAllRecipients();
		$mbox->mail->addAddress($v->email);
		$mbox->mail->addBCC($BCC);
		$email_template[$t_name]["{{name}}"] = $v->sns;
		$email_template[$t_name]["{{coupon}}"] = $v->coupon_num;
		$mbox->mail->Subject =	"$v->sns 님께 쿠폰($v->coupon_num)을 드립니다. ";
		$mbox->setTemplate($t_name, $email_template[$t_name]);
		//$mbox->send();
		$today=date("Y-m-d H:i:s");
		$ggsheet->replace($MYVISITORS, $v->email, 'coupon_sent_dt', $today);
	}
	$mbox->send();

	$ggsheet->uploadVisitorsAt($MYVISITORS,2);


?>
