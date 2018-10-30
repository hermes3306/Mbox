<?php
/*
 * Copyright 2018, LEE& COMPANY, INC. 
 *
 *     http://waffle.at
 *
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class mbox
{
  public $mail;
  public $mail_props;

  public function __construct($filepath)
  {
	$this->mail_props 		= parse_ini_file($filepath); 

	$this->mail = new PHPMailer(true);
    $this->mail->isSMTP();
    $this->mail->SMTPDebug 	= 		2;
	$this->mail->ContentType= 		"text/html";  
    $this->mail->CharSet	=		"UTF-8"; 
    $this->mail->Encoding 	= 		"base64";
    $this->mail->Host =           	$this->mail_props['Host'];
    $this->mail->Port =           	$this->mail_props['Port'];
    $this->mail->SMTPSecure =     	$this->mail_props['SMTPSecure'];
    $this->mail->SMTPAuth =       	$this->mail_props['SMTPAuth'];
    $this->mail->Username =       	$this->mail_props['Username'];
    $this->mail->Password =       	$this->mail_props['Password'];
    $this->mail->setFrom          	($this->mail_props['setFrom']);

	//$this->mail->addAddress("undisclosed-recipients:;");
    foreach ($this->mail_props['Address'] as $addr) {
        $this->mail->addAddress   ($addr);
    }

    foreach ($this->mail_props['CC'] as $addr) {
        $this->mail->addCC   ($addr);
    }

    foreach ($this->mail_props['BCC'] as $addr) {
        $this->mail->addBCC   ($addr);
    }

    $this->mail->isHTML           	($this->mail_props['isHtml']);
    $this->mail->Subject =       	$this->mail_props['Subject'];
    $this->mail->Body =        		$this->mail_props['Body'];

    foreach ($this->mail_props['Attachment'] as $attach) {
        $this->mail->addAttachment($attach);
    }

  }

  /**
   * Return PHPMailer class.
   * @return PHPMailer
   */
  public function getPHPMailer()
  {
    return $this->mail;
  }

  public function setSubject($subject)
  {
    $this->mail->Subject =		$subject;
  }

  /**
   * set Email Body.
   * @return 
   */
  public function setBody($email_body)
  {
    $this->mail->Body =		$email_body;
  }

  /**
   * set Email Body.
   * @return 
   */
  public function getHtmlMsgBody($fields, $result)
  {
	$dbtable = $this->getTableContent($fields, $result);
	$msgbody = "
		<html>
			<head></head>
			<body>

				$dbtable

			</body>
		</html>
	";
	return $msgbody;
  }

  public function setTemplate($fname, $inlines) {
	$conts = file_get_contents($fname, __DIR__);
	foreach($inlines as $key => $inline) {
		$conts = str_replace($key,$inline,$conts);
	}
	$this->setBody($conts);
  }


  public function getHtmlMsgBody2($fields, $result) 
  {
	$dbtable = $this->getTableContent($fields, $result);
	$template = file_get_contents('email.html', __DIR__);
	$template = str_replace('{{Greeting}}',	'안녕하세요? ', $template);
	$template = str_replace('{{Information1}}','Waffle 쿠폰 사용 현황은 다음과 같습니다', $template);
	$template = str_replace('{{Information2}}', $dbtable, $template);

	$template = str_replace('{{GO}}','세부정보확인', $template);

	$template = str_replace('{{Information3}}','본 서비스에 대해서 추가적인 궁금한점이 있으시면 고객 지원 센터로 연락 부탁합니다', $template);
	$template = str_replace('{{Goodbye}}','Good luck! Hope it works', $template);
	return $template;
  }

	
  public function getTableContent($fields, $result) {
    $body =     '<table class="w3-table">';
    $body.=     '<tr class="w3-light-grey">';
   
    foreach ($fields as $field) {
        $body.= "<th>" . $field . "</th>";
    }
    $body.=     "</tr>";

	while($row = mysqli_fetch_array($result)) {
        $body.=     "<tr>";
        foreach ($fields as $field) {
            $body.= "<td>" . $row[$field] . "</td>";
        }
        $body.=     "</tr>";
    }
	return $body;
  }

  public function getCampainData($num)
  {
    $conn = mysqli_connect(
		$this->mail_props['db.host'],
		$this->mail_props['db.id'],
      	$this->mail_props['db.pwd'],
      	$this->mail_props['db.db']);

 	$sql = $this->mail_props["camp$num.sql"];
    $result = mysqli_query($conn, $sql);
	$body = $this->getTableContent($this->mail_props["camp$num.field"],$result);
	return $body;
  }

  /**
   * return execute Campaign 
   * @return 
   */
  public function campaign($num, $subject)
  {
	$this->mail->Subject = $subject;
    //$this->setSubject("Daily Report of ". date("Y/m/d"));

	switch($num)  {
    	case 1: 
    		$inlines = array(
        		"{{inline1}}" => "Daily Statistics Information",
        		"{{inline2}}" => date('l jS \of F Y h:i:s A'),
        		"{{inline3}}" => "---------------------------------------------- ",
        		"{{inline4}}" => $this->getCampainData($num),
    		);
			$this->setTemplate('email1.html', $inlines);
			break;
		case 2:
		case 3:
    		$inlines = array(
        		"[CLIENTS.COMPANY_NAME]" => "LEE& Company",
        		"[Writer]" => 	"Jason Park",
        		"[[LIST_VIEW]]" => $this->getCampainData($num),
    		);
			$this->setTemplate('email2.html', $inlines);
			break;
		case 4:
    		$inlines = array(
        		"{{inline1}}" => "일간 통계 정보",
        		"{{inline2}}" => date_default_timezone_set('UTC'),
        		"{{inline3}}" => "---------------------------------------------- ",
        		"{{inline4}}" => $this->getCampainData($num),
    		);
			$this->setTemplate('email3.html', $inlines);
			break;
		default:
    		$inlines = array(
        		"{{inline1}}" => "월간 방문자/이메일 현황 통계 정보",
        		"{{inline2}}" =>  date('F Y'),
        		"{{inline3}}" => "---------------------------------------------- ",
        		"{{inline4}}" => $this->getCampainData($num),
    		);
			$this->setTemplate('email3.html', $inlines);
			break;
	}
  }

  /**
   * send emails.
   * @return Result
   */
  public function send()
  {
    return $this->mail->send();
  }

}
