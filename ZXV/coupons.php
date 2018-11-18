<?php
/*
 * Copyright 2018, LEE& COMPANY, INC.
 *
 *     http://waffle.at
 *
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/visitor.php';
require __DIR__ . '/ggsheet.php';

class coupons
{
  public $types = [
	"5% DC" 	=> "1",
	"One Beer" 	=> "2",
	"15% DC"	=> "3",
	"10% DC"	=> "4",
  ];

  public $pdo_cons = "sqlite:". __DIR__ . "/coupons.sqlite3";

  public function getvisitors() {
	$host = '127.0.0.1';
	$db   = 'waffle';
	$user = 'waffle';
	$pass = 'waffle';
	$charset = 'utf8mb4';

	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$options = [
    	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    	PDO::ATTR_EMULATE_PREPARES   => false,
	];
	try {
    	$pdo = new PDO($dsn, $user, $pass, $options);
	} catch (\PDOException $e) {
     	throw new \PDOException($e->getMessage(), (int)$e->getCode());
	}

    $sql = "SELECT id,
                name as sns,
                email,
                time as collect_dt,
                if(update_time=null, 1,2) as visit_cnt,
                ifnull(update_time, ifnull(time,'-')) as visit_dt,
                if(update_time=null, '1st visit', 'Re-visit') as mail_ty,
                ifnull(null,'-') as coupon_num,
                ifnull(null,'-') as fv_mail_dt,
                ifnull(null,'-') as rv_mail_dt,
                ifnull(null,'-') as lv_mail_dt,
                ifnull(null,'-') as hv_mail_dt,
                ifnull(null,'-') as coupon_used_dt
            FROM User";
    print("$sql\n");

	$stmt = $pdo->query($sql);
    $visitors = array();
	while ($row = $stmt->fetch())
	{
		$vtype="";
		switch(rand(1,7)) {
			case 1:  $vtype="1회방문"; break;
			case 2:	 $vtype="2회방문"; break;
			case 3:	 $vtype="3회방문"; break;
			case 4:	 $vtype="4회방문"; break;
			case 5:	 $vtype="5회이상"; break;
			case 6:	 $vtype="휴먼고객"; break;
			case 7:	 $vtype="우수고객"; break;
		}

        $visitor = new visitor(
            $row['id'],
            $row['sns'],
            $row['email'],
            $row['collect_dt'],
            $row['visit_cnt'],
            $row['visit_dt'],
            //$row['mail_ty'],
			$vtype,
            $row['coupon_num'],
            $row['fv_mail_dt'],
            $row['rv_mail_dt'],
            $row['lv_mail_dt'],
            $row['hv_mail_dt'],
            $row['coupon_used_dt']
        );
        array_push($visitors, $visitor);
    }
	$db = null;
    return $visitors;
  }

  public function randomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public function gencoupons($num, $type) {
	$arr = array();
	while($num > count($arr)) {
		$i = $this->randomString();
		$arr[$i] = $i;
	}
	return $arr;
  }

  public function dbconn_test() {
	$db = new PDO($this->pdo_cons);
 	$db->setAttribute(PDO::ATTR_ERRMODE, 
                              PDO::ERRMODE_EXCEPTION); 

	/*
	$mdb = new PDO("sqlite::memory:');
    $mdb->setAttribute(PDO::ATTR_ERRMODE, 
                              PDO::ERRMODE_EXCEPTION); 
	*/
	return db;
  }

  public function show() {
	$db = new PDO($this->pdo_cons);
 	$db->setAttribute(PDO::ATTR_ERRMODE, 
                              PDO::ERRMODE_EXCEPTION); 
	$result = $db->query('SELECT * FROM Coupons');
 
	$inx=1;
    foreach($result as $row) {
      echo "" . $inx . " " . $row['coupon'] . " ", $row['type'] . " \n";
	  $inx = $inx + 1;
    }
	$db =null;
  }

  public function getcoupon($userid, $email, $type) {
	$db = new PDO($this->pdo_cons);
 	$db->setAttribute(PDO::ATTR_ERRMODE, 
                              PDO::ERRMODE_EXCEPTION); 

	$coupon = "-" ;
	$sql = "SELECT coupon FROM Coupons WHERE userid like '$userid' and email like '$email' limit 1";
	$stmt = $db->query($sql);
	if($row = $stmt->fetch()) {
		$coupon = $row['coupon'];
 		print("coupon:$coupon \n");
    } else {
        print("No coupon related to ($userid, $email) \n");
    }


	if($coupon=="-") {
		$sql = "SELECT coupon FROM Coupons WHERE userid is null and email is null limit 1";
		$stmt = $db->query($sql);
		if($row = $stmt->fetch()) {
			$coupon = $row['coupon'];
 			print("coupon:$coupon \n");
    	} else {
        	print("No left coupons... \n");
   		}
		
		if($coupon != "-") {
			$sql = "update Coupons set userid = '$userid', email 	= '$email', type 	= $type where coupon = '$coupon'";
            print("$sql\n");
			try {
				$db->exec($sql);
        		print("coupon:$coupon is assigned to ($userid, $email) \n");
			}catch(Exception $e) {
				die($e);
			}
		}	
	$db = null;
	}

	return $coupon;
  }


  public function save($coupons, $type) {
	$db = new PDO($this->pdo_cons);
 	$db->setAttribute(PDO::ATTR_ERRMODE, 
                              PDO::ERRMODE_EXCEPTION); 

	$sql="CREATE TABLE IF NOT EXISTS Coupons(
                               coupon  varchar(10) NOT NULL,
                               type    integer  NOT NULL,
                               userid  varchar(30) default null,
                               email   varchar(45) default null,
                               created_at timestamp DEFAULT CURRENT_TIMESTAMP,
                               issued_at  datetime default null,
                               sent_at    datetime default null,
                               used_at    datetime default null,
                               primary key(coupon)
                    )";
	try {
		$db->exec($sql);
        print("Coupons table created!\n");
	}catch(Exception $e) {
		die($e);
	}

    $sql = "insert into Coupons(coupon,type) values(:c,:t)";
    $stmt = $db->prepare($sql);

    foreach($coupons as $c) {
        $stmt->bindParam(":c", $c);
        $stmt->bindParam(":t", $type);
        $stmt->execute();
    }
	$db = null;
  }
}

$myc = new coupons();
foreach($myc->types as $k => $v) {
	$cs =  $myc->gencoupons(100, $k);
	foreach($cs as $k => &$c) {
		printf("%s => %s \n", $k,$c);
	}
	$myc->save($cs, $v);  
}

$myc->show();
$visitors = $myc->getvisitors();
foreach($visitors as &$v) {
	$ctype = "-";
	switch($v->mail_ty) {
     		case "1회방문": $ctype = $myc->types["5% DC"]; break;
            case "2회방문": 
            case "3회방문":
            case "4회방문": $ctype = $myc->types["One Beer"]; break;
            case "5회이상": 
            case "우수고객": $ctype = $myc->types["15% DC"]; break;
            case "휴먼고객": $ctype = $myc->types["10% DC"]; break;
	}

	$v->coupon_num = $myc->getcoupon($v->sns, $v->email, $ctype);
	$v->email = "wf.".$v->email;
	$v->print2();
}

$ggsheet = new ggsheet();
$ggsheet->spreadsheetId = '1oyKX1Vkls8vri7GbCagxYNB_zN6SPnpPN6xlrtwbxeA';
$ggsheet->uploadVisitorsAt($visitors, 2);
$visotors = $ggsheet->info();
var_dump($visitors);

?>
