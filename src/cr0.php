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

/*
 * Email properties
 * 
 *
 */
$TO				= "At54Street@Gmail.com";
$CC				= "6ave54street@gmail.com";
$BCC 			= "nice9uy@hotmail.com";

$output = shell_exec('/sbin/ifconfig');
$dt = date("y/m/d, h:i:sa");
$ti = date("h:i:sa");

$hname  = trim(`hostname`);
$myIP   = shell_exec('hostname -I');

$Subject        =   "$hname-$hname($ti)";
$Body           =   nl2br($output);
$Body		=   $dt . "<br><br> - $hname <br>" . $Body;


$props		=   array(
	'Host'       =>   "smtp.gmail.com",
	'Port'       =>   587,
	'SMTPSecure' =>   "tls",
	'SMTPAuth'   =>   true,
	'Username'   =>   "6ave54street@gmail.com",
	'Password'   =>   "dhtlqtkqjsrkdptj",
	'setFrom'    =>   "6ave54street@gmail.com",
	'isHtml'     =>   true,
);

$mail 	= new PHPMailer(true);

$mail->isSMTP();
$mail->SMTPDebug 		= 	2;
$mail->ContentType		= 	"text/html";  
$mail->CharSet			=	"UTF-8"; 
$mail->Encoding 		=	"base64";

$mail->Host 			=  	$props['Host'];
$mail->Port 			= 	$props['Port'];
$mail->SMTPSecure 		=  	$props['SMTPSecure'];
$mail->SMTPAuth 		=  	$props['SMTPAuth'];
$mail->Username 		=  	$props['Username'];
$mail->Password 		=  	$props['Password'];

$mail->setFrom        	($props['setFrom']);
$mail->isHTML          	($props['isHtml']);

$TO_arr = explode(",", $TO);
$CC_arr = explode(",", $CC);
$BCC_arr = explode(",", $BCC);

foreach ($TO_arr as $addr) { $mail->addAddress($addr); }
foreach ($CC_arr  as $addr) { $mail->addCC($addr); }
foreach ($BCC_arr as $addr) { $mail->addBCC($addr); }

$mail->Subject =  		$Subject;
$mail->Body =        	$Body;
$mail->send();

?>
