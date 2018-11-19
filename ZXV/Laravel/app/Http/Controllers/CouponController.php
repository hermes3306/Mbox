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

    function show($type=0)
    {
		$sql = 'select coupon,type,userid,email,created_at,issued_at,sent_at,used_at from Coupons where type';
		if($type==0) $sql = $sql . ' > ?';
		else $sql = $sql . ' = ?';
		
		$coupons =	DB::connection()->select($sql, [$type]);
		return view('coupon.show', ['coupons' => $coupons] );
    }

	function sheetview()
	{
		$ggsheet = new ggsheet();
		$ggsheet->spreadsheetId = '1oyKX1Vkls8vri7GbCagxYNB_zN6SPnpPN6xlrtwbxeA';
		$visitors = $ggsheet->info();
		return view('coupon.sheetview', ['visitors' => $visitors] );
		return "OK"; 
	}



}
