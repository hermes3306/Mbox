-- 
-- Table structure for table mbox 
-- 

DROP TABLE IF EXISTS mbox;

CREATE TABLE mbox (
  id int(11) 	not null AUTO_INCREMENT,
  facebookid	varchar(20) NOT NULL,
  email 		varchar(20) NOT NULL,
  collect_dt	timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  visit_dt 		timestamp NULL,
  mail_gubun 	varchar(10),
  coupon_num	timestamp NULL,
  coupon_dt		timestamp NULL,
  receipt_dt	timestamp NULL,
  mail_receipt	varchar(5) NULL,
  coupon_use_dt timestamp NULL,

  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;

insert into mbox (facebookid,email,mail_gubun,coupon_num,mail_receipt) values 
('fbid01','6ave54street1@gmail.com','1st visit','cp10000000','N'),
('fbid02','6ave54street2@gmail.com','2nd visit','cp10000000','N'),
('fbid03','6ave54street3@gmail.com','3rd visit','cp10000000','N'),
('fbid04','6ave54street4@gmail.com','coupon visit','cp10000000','N'),
('fbid05','6ave54street5@gmail.com','2nt visit','cp10000000','N'),
('fbid06','6ave54street6@gmail.com','3rd visit','cp10000000','N'),
('fbid07','6ave54street7@gmail.com','1st visit','cp10000000','N'),
('fbid08','6ave54street8@gmail.com','1st visit','cp10000000','N'),
('fbid09','6ave54street9@gmail.com','couput visit','cp10000000','N'),
('fbid10','6ave54street10@gmail.com','2nt visit','cp10000000','N');




