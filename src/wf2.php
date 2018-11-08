<?php
	$mbox_home	=	getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
	require 	$mbox_home . '/vendor/autoload.php';
	require 	$mbox_home . '/src/mbox.php';

	$mbox = new mbox($mbox_home . '/wfmail.ini');
	$add_list = $mbox->getAddressFromDB('User2','email');
	foreach($add_list as $addr) {
		print($addr."\n");
	}

	$mbox->sendFromDB($add_list,'mail_log','title','content');
?>
	

