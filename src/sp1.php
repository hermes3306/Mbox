<?php
	$mbox_home	=	getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
	require 	$mbox_home . '/vendor/autoload.php';
	require 	$mbox_home . '/src/mbox.php';
	require 	$mbox_home . '/src/visitor.php';
	require 	$mbox_home . '/src/ggsheet.php';
	require 	$mbox_home . '/src/SpreadsheetSnippets.php';

	$mbox = new mbox($mbox_home . '/wfmail.ini');

	$ggsheet = new ggsheet();
	$sss = new SpreadsheetSnippets($ggsheet->service);
	$today=date("YmdHis");
	$id = $sss->create("MySheet.$today");

	$opt = 'USER_ENTERED';
	$visitors = $mbox->getvisitorsWithCoupons();
	$ggvalues = $ggsheet->visitors2GGvalues($visitors);

	$header = ['ID','Facebook ID','email','수집일시','방문횟수','방문일시','메일구분',
			'쿠폰번호','환영메일(1-2회방문)','안내메일(3회이상방문)', 
			'쿠폰발송(쿠폰대상자)','쿠폰사용일시'];
	array_unshift($ggvalues, $header);
	$sss->updateValues($id, "시트1!A1:L", $opt, $ggvalues);
	printf("ID: %s", ($id));

?>
	

