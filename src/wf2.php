<?php
	$mbox_home	=	getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
	require 	$mbox_home . '/vendor/autoload.php';
	require 	$mbox_home . '/src/mbox.php';
	require 	$mbox_home . '/src/visitor.php';
	require 	$mbox_home . '/src/ggsheet.php';

	$mbox = new mbox($mbox_home . '/wfmail.ini');

	$visitors = $mbox->getvisitors();
	$visitors = $mbox->getvisitorsWithCoupons();
	//var_dump($visitors);

	$ggsheet = new ggsheet();
	//$ggsheet->uploadVisitors($visitors);
	$ggsheet->uploadVisitorsAt($visitors, 2);

	$visotors = $ggsheet->info();
	var_dump($visitors);
	
?>
	

