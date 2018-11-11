<?php
/*
 * Copyright 2018, LEE& COMPANY, INC. 
 *
 *     http://waffle.at
 *
 */

class visitor
{
  public $id;
  public $sns;
  public $email;
  public $collect_dt;
  public $visit_cnt;
  public $visit_dt;
  public $mail_ty;
  public $coupon_num;
  public $coupon_mail_dt;
  public $coupon_issue_dt;
  public $coupon_sent_dt;
  public $coupon_used_dt;

  function __construct(
      $id,
      $sns,
      $email,
      $collect_dt,
      $visit_cnt,
      $visit_dt,
      $mail_ty,
      $coupon_num,
      $coupon_mail_dt,
      $coupon_issue_dt,
      $coupon_sent_dt,
	  $coupon_used_dt) { 
  	$this->id=$id;
  	$this->sns=$sns;
  	$this->email=$email;
    $this->collect_dt=$collect_dt;
 	$this->visit_cnt=$visit_cnt;
    $this->visit_dt=$visit_dt;
    $this->mail_ty=$mail_ty;
    $this->coupon_num=$coupon_num;
    $this->coupon_mail_dt=$coupon_mail_dt;
    $this->coupon_issue_dt=$coupon_issue_dt;
    $this->coupon_sent_dt=$coupon_sent_dt;
    $this->coupon_used_dt=$coupon_used_dt;
  }

  function print() {
    print("$this->id\n");
    print("$this->sns\n");
    print("$this->email\n");
    print("$this->collect_dt\n");
    print("$this->visit_cnt\n");
    print("$this->visit_dt\n");
    print("$this->mail_ty\n");
    print("$this->coupon_num\n");
    print("$this->coupon_mail_dt\n");
    print("$this->coupon_issue_dt\n");
    print("$this->coupon_sent_dt\n");
    print("$this->coupon_used_dt\n");
  }

  function print2() {
	printf("%s %s %s %s %s %s %s %s %s %s %s %s\n", 
      $this->id,
      $this->sns,
      $this->email,
      $this->collect_dt,
      $this->visit_cnt,
      $this->visit_dt,
      $this->mail_ty,
      $this->coupon_num,
      $this->coupon_mail_dt,
      $this->coupon_issue_dt,
      $this->coupon_sent_dt,
      $this->coupon_used_dt);
  }



}
