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
('12apple','6ave54street@gmail.com','1st','XFDFXDFD00',now(),'N',null,now()),
('pear','At54Street@gmail.com','2nd','FGDSFG0000',now(),'Y',now(),null),
('fb1245','6ave54street@gmail.com','3rd','cp10XDFDF0',NULL,'Y',now(),null),
('Tomcruiser','6ave54street@gmail.com','coupon','SDFFD00000',null,'N',null,now()),
('Brride','6ave54street@gmail.com','2nt','Xp10DFSD00',now(),'N',null,null), 
('Rihard','6ave54street@gmail.com','3rd','Op1XDFD000',now(),'Y',now(),null),
('Charls','6ave54street@gmail.com','1st','Gp100SD000',now(),'Y',now(),null),
('Davaid123','6ave54street@gmail.com','1st','Fp100SDFSD',null,'N',null,null),
('JANGI','6ave54street@gmail.com','couput','Xp10SXZ000',null,'N',null,now()),
('HANTOM','6ave54street@gmail.com','2nt','Xp10SDFFD0',now(),'Y',now(),null),
('NYPOL','6ave54street@gmail.com','1st','XFDFXDFD00',now(),'N',null,now()),
('PPARR','At54Street@gmail.com','2nd','FGDSFG0000',now(),'Y',now(),null),
('FB1245','6ave54street@gmail.com','3rd','cp10XDFDF0',NULL,'Y',now(),null),
('Leon','6ave54street@gmail.com','coupon','SDFFD00000',null,'N',null,now()),
('Xing','6ave54street@gmail.com','2nt','Xp10DFSD00',now(),'N',null,null), 
('KongRihard','6ave54street@gmail.com','3rd','Op1XDFD000',now(),'Y',now(),null),
('TinaCharls','6ave54street@gmail.com','1st','Gp100SD000',now(),'Y',now(),null),
('Davaid3','6ave54street@gmail.com','1st','Fp100SDFSD',null,'N',null,null),
('Regina2','6ave54street@gmail.com','couput','Xp10SXZ000',null,'N',null,now()),
('Gameking2','6ave54street@gmail.com','2nt','Xp10SDFFD0',now(),'Y',now(),null);




