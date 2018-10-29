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

insert into mbox (facebookid,email,mail_gubun,coupon_num,coupon_dt,mail_receipt,receipt_dt) values 
('fbid01','6ave54street1@gmail.com','1st visit','XFDFXDFD00',now(),'N',null),
('fbid02','6ave54street2@gmail.com','2nd visit','FGDSFG0000',now(),'Y',now()),
('fbid03','6ave54street3@gmail.com','3rd visit','cp10XDFDF0',NULL,'Y',now()),
('fbid04','6ave54street4@gmail.com','coupon visit','SDFFD00000',null,'N',null),
('fbid05','6ave54street5@gmail.com','2nt visit','cp10DFSD00',now(),'N',null), 
('fbid06','6ave54street6@gmail.com','3rd visit','cp1XDFD000',now(),'Y',now()),
('fbid07','6ave54street7@gmail.com','1st visit','cp100SD000',now(),'Y',now()),
('fbid08','6ave54street8@gmail.com','1st visit','cp100SDFSD',null,'N',null),
('fbid09','6ave54street9@gmail.com','couput visit','cp10SXZ000',null,'N',null),
('fbid10','6ave54street10@gmail.com','2nt visit','cp10SDFFD0',now(),'Y',now());




