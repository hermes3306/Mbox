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
	$today = date("ymd");

	$ggsheet = new ggsheet();
	$ggsheet->spreadsheetId = '1oyKX1Vkls8vri7GbCagxYNB_zN6SPnpPN6xlrtwbxeA';

	$visitors = $ggsheet->info();
        $db = new PDO($pdo_cons);


        $db->setAttribute(PDO::ATTR_ERRMODE,
                              PDO::ERRMODE_EXCEPTION);

	$sql = "CREATE TABLE IF NOT EXISTS Visitors(
		yymmdd 		varchar(10) 	NOT NULL,
		id		integer		NOT NULL,
		sns		varchar(20)	NOT NULL,
		email		varchar(30)	NOT NULL,
		collect_dt	datetime	NOT NULL,
		visit_cnt	integer		NOT NULL,
		visit_dt	datetime	default NULL,
		mail_ty		varchar(10)	default NULL,
		coupon_num	varchar(15)	default NULL,
		fv_mail_dt	datetime	default NULL,
		rv_mail_dt	datetime	default NULL,
		lv_mail_dt	datetime	default NULL,
		hv_mail_dt	datetime	default NULL,
		coupon_used_dt  datetime	default NULL)";

	print_r("$sql \n");
	try {
		$db->exec($sql);
		print("Visitors table created!\n");
	}catch(Exception $e) {
		print_r($db->errorInfo());
		die($e);
	}

	$sql = "DELETE FROM Visitors WHERE yymmdd = $today";
	print_r("$sql \n");
	try {
		$db->exec($sql);
		print("Duplicate deleted for today($today)!\n");
	}catch(Exception $e) {
		die($e);
	}

	$sql = "INSERT INTO Visitors(
			yymmdd,
			id,
			sns,
			email,
			collect_dt,
			visit_cnt,
			visit_dt,
			mail_ty,
			coupon_num,
			fv_mail_dt,
			rv_mail_dt,
			lv_mail_dt,
			hv_mail_dt,
			coupon_used_dt)
		VALUES(
			:yymmdd,
			:id,
			:sns,
			:email,
			:collect_dt,
			:visit_cnt,
			:visit_dt,
			:mail_ty,
			:coupon_num,
			:fv_mail_dt,
			:rv_mail_dt,
			:lv_mail_dt,
			:hv_mail_dt,
			:coupon_used_dt
		)";

	print_r("$sql \n");

	$stmt = null;
	try {
		$stmt =  $db->prepare($sql);
	}catch(Exception $e) {
		print_r($db->errorInfo());
		die($e);
	}

	foreach($visitors as $v) {
		try {
			$stmt->bindParam(":yymmdd", 	$today);
			$stmt->bindParam(":id",		$v->id);
			$stmt->bindParam(":sns",	$v->sns);
			$stmt->bindParam(":email",	$v->email);
			$stmt->bindParam(":collect_dt",	$v->collect_dt);
			$stmt->bindParam(":visit_cnt",	$v->visit_cnt);
			$stmt->bindParam(":visit_dt",	$v->visit_dt);
			$stmt->bindParam(":mail_ty",	$v->mail_ty);
			$stmt->bindParam(":coupon_num",	$v->coupon_num);
			$stmt->bindParam(":fv_mail_dt",	$v->fv_mail_dt);
			$stmt->bindParam(":rv_mail_dt",	$v->rv_mail_dt);
			$stmt->bindParam(":lv_mail_dt",	$v->lv_mail_dt);
			$stmt->bindParam(":hv_mail_dt",	$v->hv_mail_dt);
			$stmt->bindParam(":coupon_used_dt", $v->coupon_used_dt);

			$stmt->execute();
			print_r($v);

		}catch(Exception $e) {
			print_r($db->errorInfo());
			die($e);
		}	
	}
	$db = null;
?>
