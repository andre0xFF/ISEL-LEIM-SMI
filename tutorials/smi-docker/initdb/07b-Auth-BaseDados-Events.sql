#
# Run command /opt/lampp/bin/mysql_upgrade
#
# Before running this script
#

SET GLOBAL event_scheduler = 1;

CREATE EVENT IF NOT EXISTS `smi`.`cleanAccounts`
ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 5 MINUTE
ON COMPLETION PRESERVE
DO
	DELETE `smi`.`auth-basic`, `smi`.`auth-challenge` FROM `smi`.`auth-basic` INNER JOIN `smi`.`auth-challenge` ON `smi`.`auth-basic`.`iduser` = `smi`.`auth-challenge`.`idUser` WHERE `smi`.`auth-basic`.`active`=0 AND DATE_ADD( `smi`.`auth-challenge`.`registerDate`, INTERVAL 5 MINUTE) < NOW();


SHOW PROCESSLIST;
