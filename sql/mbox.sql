-- 
-- Table structure for table mbox 
-- 

DROP TABLE IF EXISTS mbox;

CREATE TABLE mbox (
  id int(11) 	not null AUTO_INCREMENT,
  facebookid	varchar(25) NOT NULL,
  email 		varchar(25) NOT NULL,
  collect_dt	timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  visit_dt 		timestamp NULL,
  mail_gubun 	varchar(10),
  coupon_num	varchar(20) NULL,
  coupon_dt		timestamp NULL,
  receipt_dt	timestamp NULL,
  mail_receipt	varchar(5) NULL,
  coupon_use_dt timestamp NULL,

  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;

insert into mbox (facebookid,email,mail_gubun,coupon_num,coupon_dt,mail_receipt,receipt_dt,coupon_use_dt) values 
('fbid01','6ave54street@gmail.com','1st','XFDFXDFD00',now(),'N',null,now()),
('fbid02','6ave54street@gmail.com','2nd','FGDSFG0000',now(),'Y',now(),null),
('fbid03','6ave54street@gmail.com','3rd','cp10XDFDF0',NULL,'Y',now(),null),
('fbid04','6ave54street@gmail.com','coupon','SDFFD00000',null,'N',null,now()),
('fbid05','6ave54street@gmail.com','2nt','Xp10DFSD00',now(),'N',null,null), 
('fbid06','6ave54street@gmail.com','3rd','Op1XDFD000',now(),'Y',now(),null),
('fbid07','6ave54street@gmail.com','1st','Gp100SD000',now(),'Y',now(),null),
('fbid08','6ave54street@gmail.com','1st','Fp100SDFSD',null,'N',null,null),
('fbid09','6ave54street@gmail.com','couput','Xp10SXZ000',null,'N',null,now()),
('fbid10','6ave54street@gmail.com','2nt','Xp10SDFFD0',now(),'Y',now(),null);




