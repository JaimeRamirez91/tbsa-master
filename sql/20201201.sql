-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema aerodb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `aerodb` ;

-- -----------------------------------------------------
-- Schema aerodb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `aerodb` DEFAULT CHARACTER SET utf8 ;
USE `aerodb` ;

-- -----------------------------------------------------
-- Table `aerodb`.`tipoempresa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`tipoempresa` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`tipoempresa` (
  `IdTipoEmpresa` INT(11) NOT NULL,
  `NomTipoEmpresa` VARCHAR(45) NULL DEFAULT NULL COMMENT 'Dos posibles valores. Aplicadora/Cliente',
  PRIMARY KEY (`IdTipoEmpresa`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`empresas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`empresas` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`empresas` (
  `IdEmpresa` INT(11) NOT NULL AUTO_INCREMENT,
  `CodEmpresa` VARCHAR(45) NULL DEFAULT NULL,
  `NomEmpresa` VARCHAR(250) NULL DEFAULT NULL,
  `NomLegal` VARCHAR(250) NULL DEFAULT NULL,
  `Correo` VARCHAR(45) NULL DEFAULT NULL,
  `IdTipoEmpresa` INT(11) NOT NULL,
  `IdEmpresaProvee` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`IdEmpresa`),
  INDEX `fk_Empresas_TipoEmpresa1_idx` (`IdTipoEmpresa` ASC) ,
  INDEX `fk_Empresas_Empresas_idx` (`IdEmpresaProvee` ASC) ,
  CONSTRAINT `fk_Empresas_Empresas`
    FOREIGN KEY (`IdEmpresaProvee`)
    REFERENCES `aerodb`.`empresas` (`IdEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Empresas_TipoEmpresa1`
    FOREIGN KEY (`IdTipoEmpresa`)
    REFERENCES `aerodb`.`tipoempresa` (`IdTipoEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`unidadmedida`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`unidadmedida` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`unidadmedida` (
  `IdUM` INT(11) NOT NULL AUTO_INCREMENT,
  `CodUM` VARCHAR(45) NULL DEFAULT NULL,
  `NomUM` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`IdUM`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`tipostrabajo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`tipostrabajo` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`tipostrabajo` (
  `IdTipoTrabajo` INT(11) NOT NULL AUTO_INCREMENT,
  `NomTipoTrabajo` VARCHAR(45) NULL DEFAULT NULL,
  `IdEmpresa` INT(11) NULL DEFAULT NULL COMMENT 'Empresa aplicadora a la que pertenece el tipo de trabajo',
  `IdUM` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`IdTipoTrabajo`),
  INDEX `fk_TiposTrabajo_Empresas1_idx` (`IdEmpresa` ASC) ,
  INDEX `fk_TiposTrabajos_UM_idx` (`IdUM` ASC) ,
  CONSTRAINT `fk_TiposTrabajo_Empresas1`
    FOREIGN KEY (`IdEmpresa`)
    REFERENCES `aerodb`.`empresas` (`IdEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TiposTrabajos_UM`
    FOREIGN KEY (`IdUM`)
    REFERENCES `aerodb`.`unidadmedida` (`IdUM`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`empresascliente_tipostrabajo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`empresascliente_tipostrabajo` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`empresascliente_tipostrabajo` (
  `IdEmpresaCliente` INT(11) NOT NULL,
  `IdTipoTrabajo` INT(11) NOT NULL,
  PRIMARY KEY (`IdEmpresaCliente`, `IdTipoTrabajo`),
  INDEX `fk_EmpresasCliente_has_TiposTrabajo_TiposTrabajo1_idx` (`IdTipoTrabajo` ASC) ,
  CONSTRAINT `fk_EmpresasCliente_has_TiposTrabajo_EmpresasCliente1`
    FOREIGN KEY (`IdEmpresaCliente`)
    REFERENCES `aerodb`.`empresas` (`IdEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_EmpresasCliente_has_TiposTrabajo_TiposTrabajo1`
    FOREIGN KEY (`IdTipoTrabajo`)
    REFERENCES `aerodb`.`tipostrabajo` (`IdTipoTrabajo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`estados`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`estados` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`estados` (
  `IdEstado` INT(11) NOT NULL,
  `CodEstado` VARCHAR(45) NULL DEFAULT NULL,
  `NomEstado` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`IdEstado`))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`periodos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`periodos` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`periodos` (
  `IdPeriodo` INT(11) NOT NULL AUTO_INCREMENT,
  `NomPeriodo` VARCHAR(45) NULL DEFAULT NULL,
  `Default` TINYINT(4) NULL DEFAULT 0,
  `IdTipoTrabajo` INT(11) NULL DEFAULT NULL COMMENT 'Tipo de trabajo del cual será el periodo',
  PRIMARY KEY (`IdPeriodo`),
  INDEX `fk_Periodos_TiposTrabajo1_idx` (`IdTipoTrabajo` ASC) ,
  CONSTRAINT `fk_Periodos_TiposTrabajo1`
    FOREIGN KEY (`IdTipoTrabajo`)
    REFERENCES `aerodb`.`tipostrabajo` (`IdTipoTrabajo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`propiedades`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`propiedades` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`propiedades` (
  `IdPropiedad` INT(11) NOT NULL AUTO_INCREMENT,
  `CodPropiedad` VARCHAR(100) NOT NULL,
  `NomPropiedad` VARCHAR(100) NOT NULL,
  `IdEmpresaCliente` INT(11) NOT NULL,
  `IdMunicipio` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`IdPropiedad`),
  INDEX `fk_Propiedades_Empresas1_idx` (`IdEmpresaCliente` ASC) ,
  CONSTRAINT `fk_Propiedades_Empresas1`
    FOREIGN KEY (`IdEmpresaCliente`)
    REFERENCES `aerodb`.`empresas` (`IdEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`segmentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`segmentos` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`segmentos` (
  `IdSegmento` INT(11) NOT NULL AUTO_INCREMENT,
  `CodSegmento` VARCHAR(45) NOT NULL,
  `NomSegmento` VARCHAR(45) NOT NULL,
  `IdPropiedad` INT(11) NOT NULL,
  `AreaPerimetral` DECIMAL(10,0) NULL DEFAULT 0,
  `AreaOperable` DECIMAL(10,0) NULL DEFAULT 0,
  `AreaActiva` DECIMAL(10,0) NULL DEFAULT 0,
  PRIMARY KEY (`IdSegmento`),
  INDEX `fk_Segmentos_Propiedades1_idx` (`IdPropiedad` ASC) ,
  CONSTRAINT `fk_Segmentos_Propiedades1`
    FOREIGN KEY (`IdPropiedad`)
    REFERENCES `aerodb`.`propiedades` (`IdPropiedad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`tiposaplicacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`tiposaplicacion` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`tiposaplicacion` (
  `IdTipoAplicacion` INT(11) NOT NULL AUTO_INCREMENT,
  `NomTipoAplicacion` VARCHAR(45) NULL DEFAULT NULL,
  `IdEmpresa` INT(11) NULL DEFAULT NULL COMMENT 'Empresa aplicadora que definió el tipo de aplicación',
  PRIMARY KEY (`IdTipoAplicacion`),
  INDEX `fk_TiposAplicacion_Empresas1_idx` (`IdEmpresa` ASC) ,
  CONSTRAINT `fk_TiposAplicacion_Empresas1`
    FOREIGN KEY (`IdEmpresa`)
    REFERENCES `aerodb`.`empresas` (`IdEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`tiposequipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`tiposequipo` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`tiposequipo` (
  `IdTipoEquipo` INT(11) NOT NULL AUTO_INCREMENT,
  `NomTipoEquipo` VARCHAR(45) NULL DEFAULT NULL,
  `IdEmpresa` INT(11) NOT NULL COMMENT 'Tipo de equipo sujeto a disponibilidad de la empresa aplicadora',
  PRIMARY KEY (`IdTipoEquipo`),
  INDEX `fk_TiposEquipo_Empresas1_idx` (`IdEmpresa` ASC) ,
  CONSTRAINT `fk_TiposEquipo_Empresas1`
    FOREIGN KEY (`IdEmpresa`)
    REFERENCES `aerodb`.`empresas` (`IdEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`usuarios` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`usuarios` (
  `IdUsuario` INT(11) NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(450) NOT NULL,
  `Password` LONGTEXT NOT NULL,
  `FechaCrea` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
  `Nombre` VARCHAR(450) NULL DEFAULT '',
  PRIMARY KEY (`IdUsuario`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`ot`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`ot` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`ot` (
  `IdOT` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `ReferenciaOT` VARCHAR(45) NULL DEFAULT NULL,
  `IdEmpresaCliente` INT(11) NULL DEFAULT NULL,
  `IdTipoTrabajo` INT(11) NOT NULL COMMENT 'Llenado por la empresa aplicadora. Si es servicio de caña, particular urbano, otro...',
  `IdPeriodo` INT(11) NULL DEFAULT NULL COMMENT 'Periodo: zafra, cosecha, año... etc',
  `IdPropiedad` INT(11) NULL DEFAULT NULL,
  `IdSegmento` INT(11) NULL DEFAULT NULL,
  `FechaTrabajo` DATETIME NULL DEFAULT NULL,
  `CantidadTrabajo` DECIMAL(10,5) NULL DEFAULT NULL,
  `IdUMProd` INT(11) NULL DEFAULT NULL,
  `IdTipoAplicacion` INT(11) NULL DEFAULT NULL,
  `IdTipoEquipo` INT(11) NULL DEFAULT NULL,
  `FechaCrea` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
  `IdUsuarioCrea` INT(11) NULL DEFAULT NULL,
  `IdEstado` INT(11) NULL DEFAULT NULL,
  `FechaCierre` DATETIME NULL DEFAULT NULL,
  `Observaciones` LONGTEXT NULL DEFAULT NULL,
  PRIMARY KEY (`IdOT`),
  INDEX `fk_OT_TiposTrabajo1_idx` (`IdTipoTrabajo` ASC) ,
  INDEX `fk_OT_Periodos1_idx` (`IdPeriodo` ASC) ,
  INDEX `fk_OT_TiposAplicacion1_idx` (`IdTipoAplicacion` ASC) ,
  INDEX `fk_OT_TiposEquipo1_idx` (`IdTipoEquipo` ASC) ,
  INDEX `fk_OT_EmpresasCliente1_idx` (`IdEmpresaCliente` ASC) ,
  INDEX `fk_OT_Usuarios1_idx` (`IdUsuarioCrea` ASC) ,
  INDEX `fk_OT_Propiedades1_idx` (`IdPropiedad` ASC) ,
  INDEX `fk_OT_Segmentos1_idx` (`IdSegmento` ASC) ,
  INDEX `fk_OT_Estados_idx` (`IdEstado` ASC) ,
  INDEX `fk_OT_Estados_idx1` (`IdEstado` ASC) ,
  CONSTRAINT `fk_OT_EmpresasCliente1`
    FOREIGN KEY (`IdEmpresaCliente`)
    REFERENCES `aerodb`.`empresas` (`IdEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_Periodos1`
    FOREIGN KEY (`IdPeriodo`)
    REFERENCES `aerodb`.`periodos` (`IdPeriodo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_Propiedades1`
    FOREIGN KEY (`IdPropiedad`)
    REFERENCES `aerodb`.`propiedades` (`IdPropiedad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_Segmentos1`
    FOREIGN KEY (`IdSegmento`)
    REFERENCES `aerodb`.`segmentos` (`IdSegmento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_TiposAplicacion1`
    FOREIGN KEY (`IdTipoAplicacion`)
    REFERENCES `aerodb`.`tiposaplicacion` (`IdTipoAplicacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_TiposEquipo1`
    FOREIGN KEY (`IdTipoEquipo`)
    REFERENCES `aerodb`.`tiposequipo` (`IdTipoEquipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_TiposTrabajo1`
    FOREIGN KEY (`IdTipoTrabajo`)
    REFERENCES `aerodb`.`tipostrabajo` (`IdTipoTrabajo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_Usuarios1`
    FOREIGN KEY (`IdUsuarioCrea`)
    REFERENCES `aerodb`.`usuarios` (`IdUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`productos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`productos` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`productos` (
  `IdProducto` INT(11) NOT NULL AUTO_INCREMENT,
  `NomProducto` VARCHAR(45) NOT NULL,
  `IgredienteActivo` VARCHAR(45) NULL DEFAULT NULL,
  `IdUM` INT(11) NOT NULL,
  PRIMARY KEY (`IdProducto`),
  INDEX `fk_Productos_UnidadMedida1_idx` (`IdUM` ASC) ,
  CONSTRAINT `fk_Productos_UnidadMedida1`
    FOREIGN KEY (`IdUM`)
    REFERENCES `aerodb`.`unidadmedida` (`IdUM`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`rolaplicacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`rolaplicacion` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`rolaplicacion` (
  `IdRolAplicacion` INT(11) NOT NULL AUTO_INCREMENT,
  `NomRolAplicacion` VARCHAR(45) NULL DEFAULT NULL,
  `IdTipoAplicacion` INT(11) NOT NULL,
  `IdEmpresaCliente` INT(11) NOT NULL,
  PRIMARY KEY (`IdRolAplicacion`),
  INDEX `fk_RolAplicacion_Empresas1_idx` (`IdEmpresaCliente` ASC) ,
  INDEX `fk_RolAplicacion_TiposAplicacion1_idx` (`IdTipoAplicacion` ASC) ,
  CONSTRAINT `fk_RolAplicacion_Empresas1`
    FOREIGN KEY (`IdEmpresaCliente`)
    REFERENCES `aerodb`.`empresas` (`IdEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_RolAplicacion_TiposAplicacion1`
    FOREIGN KEY (`IdTipoAplicacion`)
    REFERENCES `aerodb`.`tiposaplicacion` (`IdTipoAplicacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`otdetalle`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`otdetalle` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`otdetalle` (
  `IdOTDetalle` INT(11) NOT NULL AUTO_INCREMENT,
  `IdOT` BIGINT(20) NOT NULL,
  `IdProducto` INT(11) NOT NULL,
  `Dosis` DECIMAL(10,0) NULL DEFAULT NULL,
  `Cantidad` DECIMAL(10,0) NOT NULL,
  `IdUM` INT(11) NOT NULL,
  `Comentario` LONGTEXT NULL DEFAULT NULL,
  `IdRolAplicacion` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`IdOTDetalle`),
  INDEX `fk_OTDetalle_RolAplicacion1_idx` (`IdRolAplicacion` ASC) ,
  INDEX `fk_OTDetalle_OT1_idx` (`IdOT` ASC) ,
  INDEX `fk_OTDetalle_Productos1_idx` (`IdProducto` ASC) ,
  INDEX `fk_OTDetalle_UnidadMedida1_idx` (`IdUM` ASC) ,
  CONSTRAINT `fk_OTDetalle_OT1`
    FOREIGN KEY (`IdOT`)
    REFERENCES `aerodb`.`ot` (`IdOT`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OTDetalle_Productos1`
    FOREIGN KEY (`IdProducto`)
    REFERENCES `aerodb`.`productos` (`IdProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OTDetalle_RolAplicacion1`
    FOREIGN KEY (`IdRolAplicacion`)
    REFERENCES `aerodb`.`rolaplicacion` (`IdRolAplicacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OTDetalle_UnidadMedida1`
    FOREIGN KEY (`IdUM`)
    REFERENCES `aerodb`.`unidadmedida` (`IdUM`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`parametros`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`parametros` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`parametros` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Codigo` VARCHAR(45) NULL DEFAULT NULL,
  `Valor` VARCHAR(450) NULL DEFAULT NULL,
  `Descripcion` VARCHAR(45) NULL DEFAULT NULL,
  `Activo` TINYINT(4) NULL DEFAULT 1,
  PRIMARY KEY (`Id`))
ENGINE = MyISAM
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`perfiles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`perfiles` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`perfiles` (
  `IdPerfil` INT(11) NOT NULL AUTO_INCREMENT,
  `CodPerfil` VARCHAR(45) NOT NULL DEFAULT '',
  `NomPerfil` VARCHAR(45) NOT NULL,
  `EsAdmin` TINYINT(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`IdPerfil`))
ENGINE = MyISAM
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`perfiles_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`perfiles_roles` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`perfiles_roles` (
  `IdPerfil` INT(11) NOT NULL,
  `IdRol` INT(11) NOT NULL,
  PRIMARY KEY (`IdPerfil`, `IdRol`),
  INDEX `fk_Perfiles_Roles_Roles_idx` (`IdRol` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`productoactivo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`productoactivo` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`productoactivo` (
  `IdProducto` INT(11) NOT NULL,
  `IdTipoAplicacion` INT(11) NOT NULL,
  `Dosis` DECIMAL(10,0) NULL DEFAULT 1,
  PRIMARY KEY (`IdProducto`, `IdTipoAplicacion`),
  INDEX `fk_Productos_has_TiposAplicacion_TiposAplicacion1_idx` (`IdTipoAplicacion` ASC) ,
  INDEX `fk_Productos_has_TiposAplicacion_Productos1_idx` (`IdProducto` ASC) ,
  CONSTRAINT `fk_Productos_has_TiposAplicacion_Productos1`
    FOREIGN KEY (`IdProducto`)
    REFERENCES `aerodb`.`productos` (`IdProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Productos_has_TiposAplicacion_TiposAplicacion1`
    FOREIGN KEY (`IdTipoAplicacion`)
    REFERENCES `aerodb`.`tiposaplicacion` (`IdTipoAplicacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`recepcion_producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`recepcion_producto` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`recepcion_producto` (
  `IdRecepcion` INT(11) NOT NULL AUTO_INCREMENT,
  `IdOTDetalle` INT(11) NOT NULL,
  `Cantidad` DECIMAL(10,0) NULL DEFAULT 0,
  `FechaDigita` DATETIME NULL DEFAULT NULL,
  `FechaSistema` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
  `IdUsrDigita` INT(11) NOT NULL,
  PRIMARY KEY (`IdRecepcion`),
  INDEX `fk_recepcion_otdetalle_idx` (`IdOTDetalle` ASC) ,
  INDEX `fk_recepcion_usuarios_idx` (`IdUsrDigita` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`roles` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`roles` (
  `IdRol` INT(11) NOT NULL AUTO_INCREMENT,
  `NomRol` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`IdRol`))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`sesiones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`sesiones` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`sesiones` (
  `IdSesion` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `IdUsuario` INT(11) NOT NULL,
  `Inicio` DATETIME NOT NULL,
  `Vencimiento` DATETIME NOT NULL,
  `Logout` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`IdSesion`),
  INDEX `fk_sesione_usuarios_idx` (`IdUsuario` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`sesiones_activas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`sesiones_activas` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`sesiones_activas` (
  `IdUsuario` INT(11) NOT NULL,
  `Timestamp` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
  `Token` LONGTEXT NULL DEFAULT NULL,
  `Vencimiento` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
  INDEX `fk_sesiones_activas_usuarios_idx` (`IdUsuario` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`tipostrabajo_tiposaplicacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`tipostrabajo_tiposaplicacion` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`tipostrabajo_tiposaplicacion` (
  `IdTipoTrabajo` INT(11) NOT NULL,
  `IdTipoAplicacion` INT(11) NOT NULL,
  PRIMARY KEY (`IdTipoTrabajo`, `IdTipoAplicacion`),
  INDEX `fk_TiposTrabajo_has_TiposAplicacion_TiposAplicacion1_idx` (`IdTipoAplicacion` ASC) ,
  INDEX `fk_TiposTrabajo_has_TiposAplicacion_TiposTrabajo1_idx` (`IdTipoTrabajo` ASC) ,
  CONSTRAINT `fk_TiposTrabajo_has_TiposAplicacion_TiposAplicacion1`
    FOREIGN KEY (`IdTipoAplicacion`)
    REFERENCES `aerodb`.`tiposaplicacion` (`IdTipoAplicacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TiposTrabajo_has_TiposAplicacion_TiposTrabajo1`
    FOREIGN KEY (`IdTipoTrabajo`)
    REFERENCES `aerodb`.`tipostrabajo` (`IdTipoTrabajo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`usuarios_empresas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`usuarios_empresas` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`usuarios_empresas` (
  `IdUsuario` INT(11) NOT NULL,
  `IdEmpresa` INT(11) NOT NULL,
  PRIMARY KEY (`IdUsuario`, `IdEmpresa`),
  INDEX `fk_Usuarios_has_Empresas_Empresas1_idx` (`IdEmpresa` ASC) ,
  INDEX `fk_Usuarios_has_Empresas_Usuarios_idx` (`IdUsuario` ASC) ,
  CONSTRAINT `fk_Usuarios_has_Empresas_Empresas1`
    FOREIGN KEY (`IdEmpresa`)
    REFERENCES `aerodb`.`empresas` (`IdEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuarios_has_Empresas_Usuarios`
    FOREIGN KEY (`IdUsuario`)
    REFERENCES `aerodb`.`usuarios` (`IdUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aerodb`.`usuarios_perfiles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aerodb`.`usuarios_perfiles` ;

CREATE TABLE IF NOT EXISTS `aerodb`.`usuarios_perfiles` (
  `IdUsuario` INT(11) NOT NULL,
  `IdPerfil` INT(11) NOT NULL,
  PRIMARY KEY (`IdUsuario`, `IdPerfil`),
  INDEX `fk_usuarios_perfiles_perfiles_idx` (`IdPerfil` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
