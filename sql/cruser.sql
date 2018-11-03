drop database if exists mbox;
create database mbox;
drop user if exists 'mbox'@'localhost';
create user 'mbox'@'localhost' identified by 'mbox';
grant all privileges on mbox.* to 'mbox'@'localhost';
flush privileges;

