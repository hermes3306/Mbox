<?php
	$mbox_home	=	getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
	require 	$mbox_home . '/vendor/autoload.php';
	require 	$mbox_home . '/src/mbox.php';
	require 	$mbox_home . '/src/visitor.php';
	require 	$mbox_home . '/src/ggsheet.php';
	require 	$mbox_home . '/src/SpreadsheetSnippets.php';
	require 	$mbox_home . '/src/ggdriver.php';

	$ggd = new ggdriver();
	$ggd->upload($mbox_home . '/src/ggsheet.php');

?>
	

