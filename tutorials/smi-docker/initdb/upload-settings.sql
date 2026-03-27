CREATE TABLE `smi`.`forms-upload-settings`(
                                              `settingName` VARCHAR(64) NOT NULL,
                                              `settingValue` VARCHAR(255) NOT NULL,
                                              PRIMARY KEY (`settingName`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO `smi`.`forms-upload-settings` (`settingName`, `settingValue`)
VALUES ('upload_dir', '/tmp/upload');


INSERT INTO `smi`.`forms-upload-settings` (`settingName`, `settingValue`)
VALUES ('max_file_size_photo', '131072');


INSERT INTO `smi`.`forms-upload-settings` (`settingName`, `settingValue`)
VALUES ('max_file_size_user', '65536');