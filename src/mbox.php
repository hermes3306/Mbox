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

  /**
   * return execute Campaign 
   * @return 
   */
  public function campaign($num, $subject)
  {
	$this->mail->Subject = $subject;
    $conn = mysqli_connect(
		$this->mail_props['db.host'],
		$this->mail_props['db.id'],
      	$this->mail_props['db.pwd'],
      	$this->mail_props['db.db']);

 	$sql = $this->mail_props["camp$num.sql"];
    $result = mysqli_query($conn, $sql);
	$body = $this->getHtmlMsgBody($this->mail_props["camp$num.field"], $result);
	$this->setBody($body);
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
