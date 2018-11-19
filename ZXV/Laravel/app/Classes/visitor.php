<?php
/*
 * Copyright 2018, LEE& COMPANY, INC. 
 *
 *     http://waffle.at
 *
 */
namespace App\Classes;

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
  public $fv_mail_dt;
  public $rv_mail_dt;
  public $lv_mail_dt;
  public $hv_mail_dt;
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
      $fv_mail_dt,
      $rv_mail_dt,
      $lv_mail_dt,
      $hv_mail_dt,
	  $coupon_used_dt) { 
  	$this->id=$id;
  	$this->sns=$sns;
  	$this->email=$email;
    $this->collect_dt=$collect_dt;
 	$this->visit_cnt=$visit_cnt;
    $this->visit_dt=$visit_dt;
    $this->mail_ty=$mail_ty;
    $this->coupon_num=$coupon_num;
    $this->fv_mail_dt=$fv_mail_dt;
    $this->rv_mail_dt=$rv_mail_dt;
    $this->lv_mail_dt=$lv_mail_dt;
    $this->hv_mail_dt=$hv_mail_dt;
  }

  function print2() {
	printf("%s %s %s %s %s %s %s %s %s %s %s %s %s\n", 
      $this->id,
      $this->sns,
      $this->email,
      $this->collect_dt,
      $this->visit_cnt,
      $this->visit_dt,
      $this->mail_ty,
      $this->coupon_num,
      $this->fv_mail_dt,
      $this->rv_mail_dt,
      $this->lv_mail_dt,
      $this->hv_mail_dt,
	  $this->coupon_used_dt);
  }



}
