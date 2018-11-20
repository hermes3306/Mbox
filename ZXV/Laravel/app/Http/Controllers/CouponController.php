<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
Use Illuminate\Http\Request;
Use Config;
Use Storage;
Use App\Classes\ggsheet;
Use App\Classes\visitor;

class CouponController extends Controller
{
	function yymmdd() {
		$sql = 'select distinct yymmdd from Visitors';	
		$yymmdds = DB::connection()->select($sql);
		return $yymmdds;
	}

    function show($type=0)
    {
		$sql = 'select coupon,type,userid,email,created_at,issued_at,sent_at,used_at from Coupons where type';
		if($type==0) $sql = $sql . ' > ?';
		else $sql = $sql . ' = ?';
		
		$coupons =	DB::connection()->select($sql, [$type]);

		$yymmdd  = 	date('ymd');
		$yymmdds = $this->yymmdd();
		$params  = ['coupons' 	=> $coupons, 
					'type' 		=> $type, 
					'yymmdd' 	=> $yymmdd, 
					'yymmdds' => $yymmdds ];
	   
		return view('coupon.show',  $params);
    }

	function sheetview()
	{
		$ggsheet = new ggsheet();
		$ggsheet->spreadsheetId = '1oyKX1Vkls8vri7GbCagxYNB_zN6SPnpPN6xlrtwbxeA';
		$visitors = $ggsheet->info();

		$yymmdd  = 	date('ymd');
		$yymmdds = $this->yymmdd();
		$params  = ['visitors' 	=> $visitors, 
					'yymmdd' 	=> $yymmdd, 
					'yymmdds' => $yymmdds ];

		return view('coupon.sheetview', $params);
	}

	function abackup() 
	{
		$ggsheet = new ggsheet();
		$ggsheet->spreadsheetId = '1oyKX1Vkls8vri7GbCagxYNB_zN6SPnpPN6xlrtwbxeA';
		$db = DB::connection()->getPDO();
		
		$visitors = $ggsheet->backup($db);
		return "Total: " . count($visitors) . " backed up...";

	}

	function backup() 
	{
		$ggsheet = new ggsheet();
		$ggsheet->spreadsheetId = '1oyKX1Vkls8vri7GbCagxYNB_zN6SPnpPN6xlrtwbxeA';
		$db = DB::connection()->getPDO();
		
		$visitors = $ggsheet->backup($db);

		$yymmdd  = 	date('ymd');
		$yymmdds = $this->yymmdd();

		$params  = ['visitors' 	=> $visitors, 
					'yymmdd' 	=> $yymmdd, 
					'yymmdds' => $yymmdds ];

		return view('coupon.backup', $params);
	}

    function showbackup($type=0, $yymmdd=0)
    {
		$where_clause = "";
		switch($type) {
			case 1: $where_clause = "where mail_ty = '1회방문'"; break;
			case 2: $where_clause = "where mail_ty in ('2회방문', '3회방문', '4회방문')"; break;
			case 3: $where_clause = "where mail_ty in ('5회이상', '우수고객')"; break;
			case 4: $where_clause = "where mail_ty in ('휴먼고객')"; break;
		}

		if($type != 0) {
			if($yymmdd !=0 ) $where_clause .= " and yymmdd = '$yymmdd'";
		}else {
			if($yymmdd !=0) $where_clause .= "where yymmdd = '$yymmdd'";
		}
		
		$sql = "select * from Visitors " . $where_clause;
		$visitors =	DB::connection()->select($sql);

		$yymmdd  = 	date('ymd');
		$yymmdds = $this->yymmdd();

		$params  = ['visitors' 	=> $visitors, 
					'type'		=> $type,
					'yymmdd' 	=> $yymmdd, 
					'yymmdds' 	=> $yymmdds ];

		return view('coupon.showbackup', $params);
    }
    function sql() {
	    	return view('coupon.sql');
    }

    function asql($sql) {
		$result =	DB::connection()->select($sql);
	    	return "OK";

    }

}
