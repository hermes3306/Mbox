<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mbox_home = getenv('mbox_home', true) ?  getenv('mbox_home', true) : '.'; 
$mbox_ini  = $mbox_home . '/mbox.ini';

require $mbox_home . '/vendor/autoload.php';
$mail_props = parse_ini_file($mbox_ini);


$mail = new PHPMailer(true);     
/* print_r($mail_props); */

try {
/*
	$mail->setLanguage('kr',	'./PHPMailer/language/');
*/
    $mail->isSMTP();         
    $mail->SMTPDebug = 2;    
    $mail->Host = 			$mail_props['Host'];
    $mail->Port = 			$mail_props['Port'];
    $mail->SMTPSecure = 	$mail_props['SMTPSecure'];
    $mail->SMTPAuth = 		$mail_props['SMTPAuth'];
    $mail->Username = 		$mail_props['Username'];
    $mail->Password = 		$mail_props['Password'];
    $mail->setFrom		   	($mail_props['setFrom']);
	
	foreach ($mail_props['Address'] as $addr) {
		$mail->addAddress	($addr);
	}
	
    $mail->addCC		   	($mail_props['CC']);
    $mail->addBCC		   	($mail_props['BCC']);

	/*
	if(false) {
    	$mail->addAddress	   	($mail_props['Address'][0]);
    	$mail->addAddress	   	($mail_props['Address'][1]);
	}
	*/

    $mail->isHTML			($mail_props['isHtml']);
    $mail->Subject = 		$mail_props['Subject'];

	foreach ($mail_props['Attachment'] as $attach) {
		$mail->addAttachment($attach);
	}

	$conn = mysqli_connect( 
							$mail_props['db.host'],
							$mail_props['db.id'],
							$mail_props['db.pwd'],
							$mail_props['db.db']);

	$sql = $mail_props['db.sql'];
	$result = mysqli_query($conn, $sql);

	$body=		'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
	$body.= 	"<html>";
	$body.=		"<head>";
	$body.=		'<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';
	$body.=		'<link href="https://waffle.at/wp-content/uploads/2013/08/favicon.ico" rel="shortcut icon" type="image/x-icon" />';
	$body.=		'<link id="default-css" href="https://waffle.at/wp-content/themes/waffle/style.css" rel="stylesheet" media="all" />';
	$body.=		"</head>";
	$body.=		"<body>";
	$body.=		'<div class="w3-container">';
	$body.=		"<h1>Daily Summary</h1>";
	$body.=		'<table class="w3-table">';
	$body.=		'<tr class="w3-light-grey">';
	
	foreach ($mail_props['db.field'] as $field) {
		$body.=	"<th>" . $field . "</th>";
	}

	$body.=		"</tr>";

	while($row = mysqli_fetch_array($result)) {
		$body.=		"<tr>";
		foreach ($mail_props['db.field'] as $field) {
			$body.=	"<td>" . $row[$field] . "</td>";
		}
		$body.=		"</tr>";
	}

	$body.=		"</table>";
	$body.=		"</div>";
	$body.=		"</body>";
	$body.=		"</html>";

	/* $mail->msgHTML($body); */
	$mail->Body = html_entity_decode($body);
    $mail->send();

    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}

