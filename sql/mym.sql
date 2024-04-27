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

INSERT INTO `mym`.`cuentas_cobrar` (`ctac_nro_documento`, `ctac_tipo_documento`, `ctac_fecha_emision`, `ctac_total`, `ctac_saldo`, `ctac_id_cliente`) VALUES ('FAC03', 'FACTURA', '2020-05-20', '150', '150', '12345678');
INSERT INTO `mym`.`cuentas_cobrar` (`ctac_nro_documento`, `ctac_tipo_documento`, `ctac_fecha_emision`, `ctac_total`, `ctac_saldo`, `ctac_id_cliente`) VALUES ('FAC07', 'FACTURA', '2021-05-10', '79', '79', '12345678');
INSERT INTO `mym`.`cuentas_cobrar` (`ctac_nro_documento`, `ctac_tipo_documento`, `ctac_fecha_emision`, `ctac_total`, `ctac_saldo`, `ctac_id_cliente`) VALUES ('FAC01', 'FACTURA', '2020-02-01', '714', '714', '12345678');
INSERT INTO `mym`.`cuentas_cobrar` (`ctac_nro_documento`, `ctac_tipo_documento`, `ctac_fecha_emision`, `ctac_total`, `ctac_saldo`, `ctac_id_cliente`) VALUES ('FAC05', 'FACTURA', '2020-08-17', '178', '178', '12345678');
INSERT INTO `mym`.`cuentas_cobrar` (`ctac_nro_documento`, `ctac_tipo_documento`, `ctac_fecha_emision`, `ctac_total`, `ctac_saldo`, `ctac_id_cliente`) VALUES ('FAC04', 'FACTURA', '2020-08-16', '112', '112', '12345678');
INSERT INTO `mym`.`cuentas_cobrar` (`ctac_nro_documento`, `ctac_tipo_documento`, `ctac_fecha_emision`, `ctac_total`, `ctac_saldo`, `ctac_id_cliente`) VALUES ('FAC06', 'FACTURA', '2021-04-18', '89', '89', '12345678');
INSERT INTO `mym`.`cuentas_cobrar` (`ctac_nro_documento`, `ctac_tipo_documento`, `ctac_fecha_emision`, `ctac_total`, `ctac_saldo`, `ctac_id_cliente`) VALUES ('FAC02', 'FACTURA', '2020-05-14', '118', '118', '12345678');


CREATE TABLE IF NOT EXISTS `mym`.`cuentas_financiamiento` (
  `id_cuentas_financiamiento` INT NOT NULL AUTO_INCREMENT,
  `ctaf_id_cliente` VARCHAR(11) NOT NULL,
  `ctaf_nro_cuota` INT NOT NULL,
  `ctaf_total_cuota` FLOAT NOT NULL,
  `ctaf_fecha_vencimiento` DATE NOT NULL,
  `ctaf_fecha_pago` DATE NULL,
  PRIMARY KEY (`id_cuentas_financiamiento`))
ENGINE = InnoDB;