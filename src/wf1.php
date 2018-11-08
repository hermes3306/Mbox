<?php
	$mbox_home	=	getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
	require 	$mbox_home . '/vendor/autoload.php';
	require 	$mbox_home . '/src/mbox.php';

	$mbox = new mbox($mbox_home . '/wfmail.ini');
	$add_list = $mbox->getAddressFromDB('User2','email');
	$add_list = array_unique($add_list);
	foreach($add_list as $addr) {
		print($addr."\n");
	}
	$mbox->setAddress($add_list);
	$mbox->send_ind();
?>
	

