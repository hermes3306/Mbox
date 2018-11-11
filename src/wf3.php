<?php
	$mbox_home	=	getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
	require 	$mbox_home . '/vendor/autoload.php';
	require 	$mbox_home . '/src/mbox.php';
	require 	$mbox_home . '/src/visitor.php';
	require 	$mbox_home . '/src/ggsheet.php';

	$mbox = new mbox($mbox_home . '/wfmail.ini');

	$ggsheet = new ggsheet();

	printf("\n\n-------------- 1회방문 -------------------- \n");
	$visitors = $ggsheet->search('1회방문');
	foreach($visitors as $v) { $v->print2(); }

	printf("\n\n-------------- 2회방문 -------------------- \n");
	$visitors = $ggsheet->search('2회방문');
	foreach($visitors as $v) { $v->print2(); }

	printf("\n\n-------------- 3회방문 -------------------- \n");
	$visitors = $ggsheet->search('3회방문');
	foreach($visitors as $v) { $v->print2(); }

	printf("\n\n-------------- 4회방문 -------------------- \n");
	$visitors = $ggsheet->search('4회방문');
	foreach($visitors as $v) { $v->print2(); }

	printf("\n\n-------------- 5회이상 -------------------- \n");
	$visitors = $ggsheet->search('5회이상');
	foreach($visitors as $v) { $v->print2(); }

	printf("\n\n-------------- 쿠폰 -------------------- \n");
	$visitors = $ggsheet->search('쿠폰');
	foreach($visitors as $v) { $v->print2(); }


?>
	

