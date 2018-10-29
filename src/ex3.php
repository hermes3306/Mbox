<?php 
	$mbox_home	=	getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
	require 	$mbox_home . '/vendor/autoload.php';
	require 	$mbox_home . '/src/mbox.php';

	$mbox = new mbox($mbox_home . '/mbox.ini');

	$mbox->campaign(1, "Campaign 1 - Waffle Visiters Log");
	$mbox->send();

	$mbox->campaign(2, "Campaign 2 - Waffle Mail/Coupon Type");
	$mbox->send();

	$mbox->campaign(3, "Campaign 3 - Waffle Mail History");
	$mbox->send();

	$mbox->campaign(4, "Campaign 4 - Waffle Mail Receipt Check" );
	$mbox->send();

	$mbox->campaign(5, "Campaign 5 - Waffle Coupon Usage ");
	$mbox->send();
?>
