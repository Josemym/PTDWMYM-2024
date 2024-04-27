CREATE DATABASE `mym` CHARACTER SET utf8mb4;

CREATE TABLE IF NOT EXISTS `mym`.`cuentas_cobrar` (
  `id_cuentas_cobrar` INT NOT NULL AUTO_INCREMENT,
  `ctac_nro_documento` VARCHAR(30) NOT NULL,
  `ctac_tipo_documento` VARCHAR(15) NOT NULL,
  `ctac_fecha_emision` DATE NOT NULL,
  `ctac_total` FLOAT NOT NULL,
  `ctac_saldo` FLOAT NOT NULL,
  `ctac_id_cliente` VARCHAR(11) NULL,
  PRIMARY KEY (`id_cuentas_cobrar`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mym`.`cuentas_financiamiento` (
  `id_cuentas_financiamiento` INT NOT NULL AUTO_INCREMENT,
  `ctaf_id_cliente` VARCHAR(11) NOT NULL,
  `ctaf_nro_cuota` INT NOT NULL,
  `ctaf_total_cuota` FLOAT NOT NULL,
  `ctaf_fecha_vencimiento` DATE NOT NULL,
  `ctaf_fecha_pago` DATE NULL,
  PRIMARY KEY (`id_cuentas_financiamiento`))
ENGINE = InnoDB;