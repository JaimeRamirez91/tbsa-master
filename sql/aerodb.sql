-- MySQL dump 10.13  Distrib 8.0.20, for Win64 (x86_64)
--
-- Host: localhost    Database: aerodb
-- ------------------------------------------------------
-- Server version	5.7.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `empresas`
--

DROP TABLE IF EXISTS `empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresas` (
  `IdEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `CodEmpresa` varchar(45) DEFAULT NULL,
  `NomEmpresa` varchar(250) DEFAULT NULL,
  `NomLegal` varchar(250) DEFAULT NULL,
  `Correo` varchar(45) DEFAULT NULL,
  `IdTipoEmpresa` int(11) NOT NULL,
  `IdEmpresaProvee` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdEmpresa`),
  KEY `fk_Empresas_TipoEmpresa1_idx` (`IdTipoEmpresa`),
  KEY `fk_Empresas_Empresas_idx` (`IdEmpresaProvee`),
  CONSTRAINT `fk_Empresas_Empresas` FOREIGN KEY (`IdEmpresaProvee`) REFERENCES `empresas` (`IdEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Empresas_TipoEmpresa1` FOREIGN KEY (`IdTipoEmpresa`) REFERENCES `tipoempresa` (`IdTipoEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `empresascliente_tipostrabajo`
--

DROP TABLE IF EXISTS `empresascliente_tipostrabajo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresascliente_tipostrabajo` (
  `IdEmpresaCliente` int(11) NOT NULL,
  `IdTipoTrabajo` int(11) NOT NULL,
  PRIMARY KEY (`IdEmpresaCliente`,`IdTipoTrabajo`),
  KEY `fk_EmpresasCliente_has_TiposTrabajo_TiposTrabajo1_idx` (`IdTipoTrabajo`),
  CONSTRAINT `fk_EmpresasCliente_has_TiposTrabajo_EmpresasCliente1` FOREIGN KEY (`IdEmpresaCliente`) REFERENCES `empresas` (`IdEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EmpresasCliente_has_TiposTrabajo_TiposTrabajo1` FOREIGN KEY (`IdTipoTrabajo`) REFERENCES `tipostrabajo` (`IdTipoTrabajo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `equipos`
--

DROP TABLE IF EXISTS `equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipos` (
  `IdEquipo` int(11) NOT NULL AUTO_INCREMENT,
  `IdTipoEquipo` int(11) DEFAULT NULL,
  `Matricula` varchar(45) DEFAULT NULL,
  `NombreEquipo` varchar(45) DEFAULT NULL,
  `IdEmpresaAplicadora` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdEquipo`),
  KEY `fk_equipos_tiposequipó_idx` (`IdTipoEquipo`),
  KEY `fk_equipos_empresas_idx` (`IdEmpresaAplicadora`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estados`
--

DROP TABLE IF EXISTS `estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados` (
  `IdEstado` int(11) NOT NULL,
  `CodEstado` varchar(45) DEFAULT NULL,
  `NomEstado` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`IdEstado`)
) ENGINE=MyInnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ot`
--

DROP TABLE IF EXISTS `ot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ot` (
  `IdOT` bigint(20) NOT NULL AUTO_INCREMENT,
  `ReferenciaOT` varchar(45) DEFAULT NULL,
  `IdEmpresaCliente` int(11) DEFAULT NULL,
  `IdTipoTrabajo` int(11) NOT NULL COMMENT 'Llenado por la empresa aplicadora. Si es servicio de caña, particular urbano, otro...',
  `IdPeriodo` int(11) DEFAULT NULL COMMENT 'Periodo: zafra, cosecha, año... etc',
  `IdPropiedad` int(11) DEFAULT NULL,
  `IdSegmento` int(11) DEFAULT NULL,
  `FechaTrabajo` datetime DEFAULT NULL,
  `CantidadTrabajo` decimal(10,5) DEFAULT NULL,
  `IdUMProd` int(11) DEFAULT NULL,
  `IdTipoAplicacion` int(11) DEFAULT NULL,
  `IdTipoEquipo` int(11) DEFAULT NULL,
  `FechaCrea` datetime DEFAULT CURRENT_TIMESTAMP,
  `IdUsuarioCrea` int(11) DEFAULT NULL,
  `IdEstado` int(11) DEFAULT NULL,
  `FechaCierre` datetime DEFAULT NULL,
  `Observaciones` longtext,
  PRIMARY KEY (`IdOT`),
  KEY `fk_OT_TiposTrabajo1_idx` (`IdTipoTrabajo`),
  KEY `fk_OT_Periodos1_idx` (`IdPeriodo`),
  KEY `fk_OT_TiposAplicacion1_idx` (`IdTipoAplicacion`),
  KEY `fk_OT_TiposEquipo1_idx` (`IdTipoEquipo`),
  KEY `fk_OT_EmpresasCliente1_idx` (`IdEmpresaCliente`),
  KEY `fk_OT_Usuarios1_idx` (`IdUsuarioCrea`),
  KEY `fk_OT_Propiedades1_idx` (`IdPropiedad`),
  KEY `fk_OT_Segmentos1_idx` (`IdSegmento`),
  KEY `fk_OT_Estados_idx` (`IdEstado`),
  KEY `fk_OT_Estados_idx1` (`IdEstado`),
  CONSTRAINT `fk_OT_EmpresasCliente1` FOREIGN KEY (`IdEmpresaCliente`) REFERENCES `empresas` (`IdEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_Periodos1` FOREIGN KEY (`IdPeriodo`) REFERENCES `periodos` (`IdPeriodo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_Propiedades1` FOREIGN KEY (`IdPropiedad`) REFERENCES `propiedades` (`IdPropiedad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_Segmentos1` FOREIGN KEY (`IdSegmento`) REFERENCES `segmentos` (`IdSegmento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_TiposAplicacion1` FOREIGN KEY (`IdTipoAplicacion`) REFERENCES `tiposaplicacion` (`IdTipoAplicacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_TiposEquipo1` FOREIGN KEY (`IdTipoEquipo`) REFERENCES `tiposequipo` (`IdTipoEquipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_TiposTrabajo1` FOREIGN KEY (`IdTipoTrabajo`) REFERENCES `tipostrabajo` (`IdTipoTrabajo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_OT_Usuarios1` FOREIGN KEY (`IdUsuarioCrea`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `otdetalle`
--

DROP TABLE IF EXISTS `otdetalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `otdetalle` (
  `IdOTDetalle` int(11) NOT NULL AUTO_INCREMENT,
  `IdOT` bigint(20) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `Dosis` decimal(10,4) DEFAULT NULL,
  `Cantidad` decimal(10,4) NOT NULL,
  `IdUM` int(11) NOT NULL,
  `Comentario` longtext,
  `IdRolAplicacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdOTDetalle`),
  KEY `fk_OTDetalle_RolAplicacion1_idx` (`IdRolAplicacion`),
  KEY `fk_OTDetalle_OT1_idx` (`IdOT`),
  KEY `fk_OTDetalle_Productos1_idx` (`IdProducto`),
  KEY `fk_OTDetalle_UnidadMedida1_idx` (`IdUM`),
  CONSTRAINT `fk_OTDetalle_OT1` FOREIGN KEY (`IdOT`) REFERENCES `ot` (`IdOT`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_OTDetalle_Productos1` FOREIGN KEY (`IdProducto`) REFERENCES `productos` (`IdProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_OTDetalle_RolAplicacion1` FOREIGN KEY (`IdRolAplicacion`) REFERENCES `rolaplicacion` (`IdRolAplicacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_OTDetalle_UnidadMedida1` FOREIGN KEY (`IdUM`) REFERENCES `unidadmedida` (`IdUM`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `parametros`
--

DROP TABLE IF EXISTS `parametros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parametros` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(45) DEFAULT NULL,
  `Valor` varchar(450) DEFAULT NULL,
  `Descripcion` varchar(45) DEFAULT NULL,
  `Activo` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=MyInnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `perfiles`
--

DROP TABLE IF EXISTS `perfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perfiles` (
  `IdPerfil` int(11) NOT NULL AUTO_INCREMENT,
  `CodPerfil` varchar(45) NOT NULL DEFAULT '',
  `NomPerfil` varchar(45) NOT NULL,
  `EsAdmin` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdPerfil`)
) ENGINE=MyInnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `perfiles_roles`
--

DROP TABLE IF EXISTS `perfiles_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perfiles_roles` (
  `IdPerfil` int(11) NOT NULL,
  `IdRol` int(11) NOT NULL,
  PRIMARY KEY (`IdPerfil`,`IdRol`),
  KEY `fk_Perfiles_Roles_Roles_idx` (`IdRol`)
) ENGINE=MyInnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `periodos`
--

DROP TABLE IF EXISTS `periodos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `periodos` (
  `IdPeriodo` int(11) NOT NULL AUTO_INCREMENT,
  `NomPeriodo` varchar(45) DEFAULT NULL,
  `Default` tinyint(4) DEFAULT '0',
  `IdTipoTrabajo` int(11) DEFAULT NULL COMMENT 'Tipo de trabajo del cual será el periodo',
  PRIMARY KEY (`IdPeriodo`),
  KEY `fk_Periodos_TiposTrabajo1_idx` (`IdTipoTrabajo`),
  CONSTRAINT `fk_Periodos_TiposTrabajo1` FOREIGN KEY (`IdTipoTrabajo`) REFERENCES `tipostrabajo` (`IdTipoTrabajo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pilotos`
--

DROP TABLE IF EXISTS `pilotos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pilotos` (
  `IdPiloto` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(45) DEFAULT NULL,
  `Nombres` varchar(150) DEFAULT NULL,
  `Documento` varchar(45) DEFAULT NULL,
  `IdEmpresaAplicadora` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdPiloto`),
  KEY `fk_pilotos_empresas_idx` (`IdEmpresaAplicadora`)
) ENGINE=MyInnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `productoactivo`
--

DROP TABLE IF EXISTS `productoactivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productoactivo` (
  `IdProducto` int(11) NOT NULL,
  `IdTipoAplicacion` int(11) NOT NULL,
  `Dosis` decimal(10,0) DEFAULT '1',
  PRIMARY KEY (`IdProducto`,`IdTipoAplicacion`),
  KEY `fk_Productos_has_TiposAplicacion_TiposAplicacion1_idx` (`IdTipoAplicacion`),
  KEY `fk_Productos_has_TiposAplicacion_Productos1_idx` (`IdProducto`),
  CONSTRAINT `fk_Productos_has_TiposAplicacion_Productos1` FOREIGN KEY (`IdProducto`) REFERENCES `productos` (`IdProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Productos_has_TiposAplicacion_TiposAplicacion1` FOREIGN KEY (`IdTipoAplicacion`) REFERENCES `tiposaplicacion` (`IdTipoAplicacion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `IdProducto` int(11) NOT NULL AUTO_INCREMENT,
  `NomProducto` varchar(45) NOT NULL,
  `IgredienteActivo` varchar(45) DEFAULT NULL,
  `IdUM` int(11) NOT NULL,
  PRIMARY KEY (`IdProducto`),
  KEY `fk_Productos_UnidadMedida1_idx` (`IdUM`),
  CONSTRAINT `fk_Productos_UnidadMedida1` FOREIGN KEY (`IdUM`) REFERENCES `unidadmedida` (`IdUM`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `propiedades`
--

DROP TABLE IF EXISTS `propiedades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `propiedades` (
  `IdPropiedad` int(11) NOT NULL AUTO_INCREMENT,
  `CodPropiedad` varchar(100) NOT NULL,
  `NomPropiedad` varchar(100) NOT NULL,
  `IdEmpresaCliente` int(11) NOT NULL,
  `IdMunicipio` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdPropiedad`),
  KEY `fk_Propiedades_Empresas1_idx` (`IdEmpresaCliente`),
  CONSTRAINT `fk_Propiedades_Empresas1` FOREIGN KEY (`IdEmpresaCliente`) REFERENCES `empresas` (`IdEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recepcion_producto`
--

DROP TABLE IF EXISTS `recepcion_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recepcion_producto` (
  `IdRecepcion` int(11) NOT NULL AUTO_INCREMENT,
  `IdOTDetalle` int(11) NOT NULL,
  `Cantidad` decimal(10,0) DEFAULT '0',
  `FechaDigita` datetime DEFAULT NULL,
  `FechaSistema` datetime DEFAULT CURRENT_TIMESTAMP,
  `IdUsrDigita` int(11) NOT NULL,
  PRIMARY KEY (`IdRecepcion`),
  KEY `fk_recepcion_otdetalle_idx` (`IdOTDetalle`),
  KEY `fk_recepcion_usuarios_idx` (`IdUsrDigita`)
) ENGINE=MyInnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rolaplicacion`
--

DROP TABLE IF EXISTS `rolaplicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rolaplicacion` (
  `IdRolAplicacion` int(11) NOT NULL AUTO_INCREMENT,
  `NomRolAplicacion` varchar(45) DEFAULT NULL,
  `IdTipoAplicacion` int(11) NOT NULL,
  `IdEmpresaCliente` int(11) NOT NULL,
  PRIMARY KEY (`IdRolAplicacion`),
  KEY `fk_RolAplicacion_Empresas1_idx` (`IdEmpresaCliente`),
  KEY `fk_RolAplicacion_TiposAplicacion1_idx` (`IdTipoAplicacion`),
  CONSTRAINT `fk_RolAplicacion_Empresas1` FOREIGN KEY (`IdEmpresaCliente`) REFERENCES `empresas` (`IdEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_RolAplicacion_TiposAplicacion1` FOREIGN KEY (`IdTipoAplicacion`) REFERENCES `tiposaplicacion` (`IdTipoAplicacion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `IdRol` int(11) NOT NULL AUTO_INCREMENT,
  `NomRol` varchar(45) NOT NULL,
  PRIMARY KEY (`IdRol`)
) ENGINE=MyInnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `segmentos`
--

DROP TABLE IF EXISTS `segmentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `segmentos` (
  `IdSegmento` int(11) NOT NULL AUTO_INCREMENT,
  `CodSegmento` varchar(45) NOT NULL,
  `NomSegmento` varchar(45) NOT NULL,
  `IdPropiedad` int(11) NOT NULL,
  `AreaPerimetral` decimal(10,0) DEFAULT '0',
  `AreaOperable` decimal(10,0) DEFAULT '0',
  `AreaActiva` decimal(10,0) DEFAULT '0',
  PRIMARY KEY (`IdSegmento`),
  KEY `fk_Segmentos_Propiedades1_idx` (`IdPropiedad`),
  CONSTRAINT `fk_Segmentos_Propiedades1` FOREIGN KEY (`IdPropiedad`) REFERENCES `propiedades` (`IdPropiedad`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sesiones`
--

DROP TABLE IF EXISTS `sesiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sesiones` (
  `IdSesion` bigint(20) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(11) NOT NULL,
  `Inicio` datetime NOT NULL,
  `Vencimiento` datetime NOT NULL,
  `Logout` datetime DEFAULT NULL,
  PRIMARY KEY (`IdSesion`),
  KEY `fk_sesione_usuarios_idx` (`IdUsuario`)
) ENGINE=MyInnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sesiones_activas`
--

DROP TABLE IF EXISTS `sesiones_activas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sesiones_activas` (
  `IdUsuario` int(11) NOT NULL,
  `Timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `Token` longtext,
  `Vencimiento` datetime DEFAULT CURRENT_TIMESTAMP,
  KEY `fk_sesiones_activas_usuarios_idx` (`IdUsuario`)
) ENGINE=MyInnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipoempresa`
--

DROP TABLE IF EXISTS `tipoempresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipoempresa` (
  `IdTipoEmpresa` int(11) NOT NULL,
  `NomTipoEmpresa` varchar(45) DEFAULT NULL COMMENT 'Dos posibles valores. Aplicadora/Cliente',
  PRIMARY KEY (`IdTipoEmpresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tiposaplicacion`
--

DROP TABLE IF EXISTS `tiposaplicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tiposaplicacion` (
  `IdTipoAplicacion` int(11) NOT NULL AUTO_INCREMENT,
  `NomTipoAplicacion` varchar(45) DEFAULT NULL,
  `IdEmpresa` int(11) DEFAULT NULL COMMENT 'Empresa aplicadora que definió el tipo de aplicación',
  PRIMARY KEY (`IdTipoAplicacion`),
  KEY `fk_TiposAplicacion_Empresas1_idx` (`IdEmpresa`),
  CONSTRAINT `fk_TiposAplicacion_Empresas1` FOREIGN KEY (`IdEmpresa`) REFERENCES `empresas` (`IdEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tiposequipo`
--

DROP TABLE IF EXISTS `tiposequipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tiposequipo` (
  `IdTipoEquipo` int(11) NOT NULL AUTO_INCREMENT,
  `NomTipoEquipo` varchar(45) DEFAULT NULL,
  `IdEmpresa` int(11) NOT NULL COMMENT 'Tipo de equipo sujeto a disponibilidad de la empresa aplicadora',
  PRIMARY KEY (`IdTipoEquipo`),
  KEY `fk_TiposEquipo_Empresas1_idx` (`IdEmpresa`),
  CONSTRAINT `fk_TiposEquipo_Empresas1` FOREIGN KEY (`IdEmpresa`) REFERENCES `empresas` (`IdEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipostrabajo`
--

DROP TABLE IF EXISTS `tipostrabajo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipostrabajo` (
  `IdTipoTrabajo` int(11) NOT NULL AUTO_INCREMENT,
  `NomTipoTrabajo` varchar(45) DEFAULT NULL,
  `IdEmpresa` int(11) DEFAULT NULL COMMENT 'Empresa aplicadora a la que pertenece el tipo de trabajo',
  `IdUM` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdTipoTrabajo`),
  KEY `fk_TiposTrabajo_Empresas1_idx` (`IdEmpresa`),
  KEY `fk_TiposTrabajos_UM_idx` (`IdUM`),
  CONSTRAINT `fk_TiposTrabajo_Empresas1` FOREIGN KEY (`IdEmpresa`) REFERENCES `empresas` (`IdEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_TiposTrabajos_UM` FOREIGN KEY (`IdUM`) REFERENCES `unidadmedida` (`IdUM`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipostrabajo_tiposaplicacion`
--

DROP TABLE IF EXISTS `tipostrabajo_tiposaplicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipostrabajo_tiposaplicacion` (
  `IdTipoTrabajo` int(11) NOT NULL,
  `IdTipoAplicacion` int(11) NOT NULL,
  PRIMARY KEY (`IdTipoTrabajo`,`IdTipoAplicacion`),
  KEY `fk_TiposTrabajo_has_TiposAplicacion_TiposAplicacion1_idx` (`IdTipoAplicacion`),
  KEY `fk_TiposTrabajo_has_TiposAplicacion_TiposTrabajo1_idx` (`IdTipoTrabajo`),
  CONSTRAINT `fk_TiposTrabajo_has_TiposAplicacion_TiposAplicacion1` FOREIGN KEY (`IdTipoAplicacion`) REFERENCES `tiposaplicacion` (`IdTipoAplicacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_TiposTrabajo_has_TiposAplicacion_TiposTrabajo1` FOREIGN KEY (`IdTipoTrabajo`) REFERENCES `tipostrabajo` (`IdTipoTrabajo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `unidadmedida`
--

DROP TABLE IF EXISTS `unidadmedida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unidadmedida` (
  `IdUM` int(11) NOT NULL AUTO_INCREMENT,
  `CodUM` varchar(45) DEFAULT NULL,
  `NomUM` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`IdUM`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(450) NOT NULL,
  `Password` longtext NOT NULL,
  `FechaCrea` datetime DEFAULT CURRENT_TIMESTAMP,
  `Nombre` varchar(450) DEFAULT '',
  PRIMARY KEY (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios_empresas`
--

DROP TABLE IF EXISTS `usuarios_empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios_empresas` (
  `IdUsuario` int(11) NOT NULL,
  `IdEmpresa` int(11) NOT NULL,
  PRIMARY KEY (`IdUsuario`,`IdEmpresa`),
  KEY `fk_Usuarios_has_Empresas_Empresas1_idx` (`IdEmpresa`),
  KEY `fk_Usuarios_has_Empresas_Usuarios_idx` (`IdUsuario`),
  CONSTRAINT `fk_Usuarios_has_Empresas_Empresas1` FOREIGN KEY (`IdEmpresa`) REFERENCES `empresas` (`IdEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuarios_has_Empresas_Usuarios` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios_perfiles`
--

DROP TABLE IF EXISTS `usuarios_perfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios_perfiles` (
  `IdUsuario` int(11) NOT NULL,
  `IdPerfil` int(11) NOT NULL,
  PRIMARY KEY (`IdUsuario`,`IdPerfil`),
  KEY `fk_usuarios_perfiles_perfiles_idx` (`IdPerfil`)
) ENGINE=MyInnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vuelosdiario`
--

DROP TABLE IF EXISTS `vuelosdiario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vuelosdiario` (
  `IdVuelo` int(11) NOT NULL AUTO_INCREMENT,
  `Matricula` varchar(45) DEFAULT NULL,
  `IdEquipo` int(11) DEFAULT NULL,
  `IdPiloto` int(11) DEFAULT NULL,
  `Piloto` varchar(450) DEFAULT NULL,
  `HorIni` decimal(10,5) DEFAULT NULL,
  `HorFin` decimal(10,5) DEFAULT NULL,
  `HorTotal` decimal(10,5) DEFAULT NULL,
  `AreaAplicada` decimal(10,5) DEFAULT NULL,
  `Observaciones` varchar(500) DEFAULT NULL,
  `FechaVuelo` datetime DEFAULT NULL,
  `FechaRegistro` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`IdVuelo`),
  KEY `fk_vuelosdiario_equipos_idx` (`IdEquipo`),
  KEY `fk_vuelosdiario_pilotos_idx` (`IdPiloto`),
  CONSTRAINT `fk_vuelosdiario_equipos` FOREIGN KEY (`IdEquipo`) REFERENCES `equipos` (`IdEquipo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-12 11:41:09
