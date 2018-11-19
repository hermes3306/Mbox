<?php
/*
 * Copyright 2018, LEE& COMPANY, INC.
 *
 *     http://waffle.at
 *
 */
        $mbox_home      =       __DIR__;
	require     $mbox_home . '/vendor/autoload.php';
	require     $mbox_home . '/visitor.php';
	require     $mbox_home . '/ggsheet.php';

	$pdo_cons = "sqlite:". __DIR__ . "/coupons.sqlite3";


        $db = new PDO($pdo_cons);

	$ggsheet = new ggsheet();
	$ggsheet->spreadsheetId = '1oyKX1Vkls8vri7GbCagxYNB_zN6SPnpPN6xlrtwbxeA';
	$ggsheet->backup($db);
	$db = null;
?>
