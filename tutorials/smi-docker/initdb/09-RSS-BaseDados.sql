CREATE TABLE `smi`.`rss-news` (
	`title` VARCHAR( 128 ) NOT NULL,
	`author` VARCHAR( 64 ) NOT NULL,
	`description` VARCHAR( 128 ) NOT NULL,
	`pubDate` DATE NOT NULL,
	`contents` VARCHAR( 2048 ) NOT NULL,
	`idNew` INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY ( `idNew` ) 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;


CREATE TABLE `smi`.`rss-comments` (
	`pubDate` DATE NOT NULL,
	`contents` VARCHAR( 2048 ) NOT NULL,
	`idNew` INT NOT NULL,
	`idComment` INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY ( `idComment` ),
	FOREIGN KEY ( `idNew` ) REFERENCES `smi`.`rss-news` (`idNew`) ON DELETE CASCADE
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
