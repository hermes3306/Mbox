<?php

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}


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


	$files = array();
	$dir = opendir($mbox_home);
	while(false != ($file = readdir($dir))) {
		if(startsWith($file,'ggv-')) $files[] = $file;
	}

	natsort($files);
	foreach($files as $file) {
		$s = file_get_contents($file);
		$visitors2 = unserialize($s);

		if($visitors == $visitors2) {
			printf("$file--OK\n");
		}else {
			printf("$file--Not OK\n");
		}
	}

	

?>
	

