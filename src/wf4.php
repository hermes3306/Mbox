<?php
	$mbox_home	=	getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
	require 	$mbox_home . '/vendor/autoload.php';
	require 	$mbox_home . '/src/mbox.php';
	require 	$mbox_home . '/src/visitor.php';
	require 	$mbox_home . '/src/ggsheet.php';

	$mbox = new mbox($mbox_home . '/wfmail.ini');

	$ggsheet = new ggsheet();

	$visitors = $ggsheet->info();
	foreach($visitors as $v) { $v->print2(); }

	

	$today=date("Ymd-His");
	$s = serialize($visitors);
	file_put_contents("ggv-$today",$s);

	printf("\n\n\n\n\n ----------------------------\n\n\n\n\n");

	$s = file_get_contents("ggv-$today");
	$visitors2 = unserialize($s);
	foreach($visitors2 as $v) { $v->print2(); }

	if($visitors == $visitors2) {
		printf("--\n\n\nOK\n\n");
	}else {
		printf("--\n\n\nNot OK\n\n");
	}

	
	

?>
	

