CREATE TABLE `smi`.`auth-basic` (
  `idUser` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR( 16 ) NOT NULL UNIQUE,
  `password` VARCHAR( 64 ) NOT NULL,
  `email` VARCHAR( 128 ) NOT NULL UNIQUE,
  `active` BOOLEAN NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `smi`.`auth-roles` (
  `idRole` INT NOT NULL PRIMARY KEY,
  `friendlyName` VARCHAR( 64 ) NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `smi`.`auth-permissions` (
  `idRole` INT NOT NULL,
  `idUser` INT NOT NULL,
  
  FOREIGN KEY ( `idRole` ) REFERENCES `smi`.`auth-roles` (`idRole`),
  FOREIGN KEY ( `idUser` ) REFERENCES `smi`.`auth-basic` (`idUser`)
  
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `smi`.`auth-challenge` (
  `idUser` INT NOT NULL,
  `challenge` VARCHAR( 32 ) NOT NULL,
  /*`registerDate` DATE NOT NULL,*/
  `registerDate` TIMESTAMP NOT NULL,
  
  FOREIGN KEY ( `idUser` ) REFERENCES `smi`.`auth-basic` (`idUser`)
  
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;


INSERT INTO `smi`.`auth-roles` (`idRole` ,`friendlyName`) VALUES ('1', 'manager');
INSERT INTO `smi`.`auth-roles` (`idRole` ,`friendlyName`) VALUES ('2', 'user');
INSERT INTO `smi`.`auth-roles` (`idRole` ,`friendlyName`) VALUES ('3', 'guest');

INSERT INTO `smi`.`auth-basic` (`name` ,`password`, `email`, `active`) VALUES ( 'user1', 'pass1', 'user1@isel.pt', 1);
INSERT INTO `smi`.`auth-basic` (`name` ,`password`, `email`, `active`) VALUES ( 'user2', 'pass2', 'user2@isel.pt', 1);

INSERT INTO `smi`.`auth-permissions` (`idRole` ,`idUser`) VALUES ('1', '1');
INSERT INTO `smi`.`auth-permissions` (`idRole` ,`idUser`) VALUES ('2', '2');
