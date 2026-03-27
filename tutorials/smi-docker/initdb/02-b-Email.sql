CREATE TABLE `smi`.`email-accounts` (
	`id` INT NOT NULL AUTO_INCREMENT ,
	`accountName` VARCHAR( 32 ) NOT NULL ,
	`smtpServer` VARCHAR( 32 ) NOT NULL ,
	`port` INT NOT NULL ,
	`useSSL` TINYINT NOT NULL ,
	`timeout` INT NOT NULL ,
	`loginName` VARCHAR( 128 ) NOT NULL ,
	`password` VARCHAR( 128 ) NOT NULL ,
	`email` VARCHAR( 128 ) NOT NULL ,
	`displayName` VARCHAR( 128 ) NOT NULL ,
	PRIMARY KEY ( `id` ) 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `smi`.`email-contacts` (
	`id` INT NOT NULL AUTO_INCREMENT ,
	`displayName` VARCHAR( 64 ) NOT NULL ,
	`email` VARCHAR( 128 ) NOT NULL ,
	PRIMARY KEY ( `id` ) 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO `smi`.`email-accounts`
	(`accountName`, `smtpServer`, `port`, `useSSL`, `timeout`, `loginName`, `password`, `email`, `displayName`) values
	('Gmail - SMI 15/16', 'smtp.gmail.com', '465', '1', '30', 'smi.isel.1516@gmail.com', 'iffgdsvgsdewgmdt', 'smi.isel.1516@gmail.com', 'Sistemas Multimédia para a Internet');

INSERT INTO `smi`.`email-accounts`
	(`accountName`, `smtpServer`, `port`, `useSSL`, `timeout`, `loginName`, `password`, `email`, `displayName`) values
	('Gmail - SMI 21/22', 'smtp.gmail.com', '465', '1', '30', 'smi.isel.2122@gmail.com', 'rljxlkhvtjjeazfl', 'smi.isel.2122@gmail.com', 'Sistemas Multimédia para a Internet');

INSERT INTO `smi`.`email-contacts`(`email`, `displayName`) values ( 'cgoncalves@deetc.isel.ipl.pt', 'Carlos Gonçalves - IPL' );

INSERT INTO `smi`.`email-contacts`(`email`, `displayName`) values ( 'carlos.goncalves@isel.pt', 'Carlos Gonçalves - ISEL' );


