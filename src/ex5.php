<?php 
	$mbox_home	=	getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
	require 	$mbox_home . '/vendor/autoload.php';
	require 	$mbox_home . '/src/mbox.php';

	$mbox = new mbox($mbox_home . '/mbox.ini');

	$inlines = array(
		"{{inline1}}" => "Daily Statistics Information",
		"{{inline2}}" => " of  ". date("l", mktime(0, 0, 0, 7, 1, 2000)),
		"{{inline3}}" => " -- ",
		"{{inline4}}" => $mbox->getCampainData(1),
	);

	$mbox->setTemplate('email1.html', $inlines);
	$mbox->setSubject("Daily Report of ". date("Y/m/d"));

	$mbox->send();
?>
