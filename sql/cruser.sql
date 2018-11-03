drop database if exists mbox;
create database mbox;
-- drop user 'mbox'@'localhost';
create user 'mbox'@'localhost' identified by 'mbox';
grant all privileges on mbox.* to 'mbox'@'localhost';
flush privileges;

