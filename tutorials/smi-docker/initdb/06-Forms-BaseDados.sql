CREATE TABLE `smi`.`forms-districts` (
  `idDistrict` INT NOT NULL,
  `nameDistrict` VARCHAR( 128 ) NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `smi`.`forms-counties` (
  `idDistrict` INT NOT NULL,
  `idCounty` INT NOT NULL,
  `nameCounty` VARCHAR( 128 ) NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `smi`.`forms-zips` (
  `idDistrict` INT NOT NULL,
  `idCounty` INT NOT NULL,
  `idLocation` INT NOT NULL,
  `nameLocation` VARCHAR( 128 ) NOT NULL,
  `postalCode` VARCHAR( 4 ) NOT NULL,
  `postalCodeExtension` VARCHAR( 3 ) NOT NULL,
  `postalCodeName` VARCHAR( 128 ) NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

# Inserir districtos
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '1', 'Aveiro');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '2', 'Beja');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '3', 'Braga');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '4', 'Bragança');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '5', 'Castelo Branco');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '6', 'Coimbra');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '7', 'Évora');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '8', 'Faro');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '9', 'Guarda');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '10', 'Leiria');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '11', 'Lisboa');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '12', 'Portalegre');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '13', 'Porto');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '14', 'Santarém');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '15', 'Setubal');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '16', 'Viana do Castelo');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '17', 'Vila Real');
INSERT INTO `smi`.`forms-districts` (`idDistrict`, `nameDistrict`) VALUES ( '18', 'Viseu');

#Inserir concelhos
#de Aveiro
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1',  '1', 'Águeda');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1',  '2', 'Albergaria-a-Velha');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1',  '3', 'Anadia');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1',  '4', 'Arouca');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1',  '5', 'Aveiro');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1',  '6', 'Castelo de Paiva');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1',  '7', 'Espinho');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1',  '8', 'Estarreja');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1',  '9', 'Santa Maria da Feira');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1', '10', 'Ílhavo');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1', '11', 'Mealhada');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1', '12', 'Murtosa');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1', '13', 'Oliveira de Azeméis');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1', '14', 'Oliveira do Bairro');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1', '15', 'Santa Maria da Feira');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1', '16', 'Ovar');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1', '17', 'Sever do Vouga');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1', '18', 'Vagos');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '1', '19', 'Vale de Cambra');

#de Lisboa
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11',  '1', 'Alenquer');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11',  '2', 'Arruda dos Vinhos');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11',  '3', 'Azambuja');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11',  '4', 'Cadaval');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11',  '5', 'Cascais');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11',  '6', 'Lisboa');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11',  '7', 'Loures');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11',  '8', 'Lourinhã');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11',  '9', 'Mafra');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11', '10', 'Oeiras');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11', '11', 'Sintra');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11', '12', 'Sobral de Monte Agraço');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11', '13', 'Torres Vedras');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11', '14', 'Vila Franca de Xira');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11', '15', 'Amadora');
INSERT INTO `smi`.`forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES ( '11', '16', 'Odivelas');
