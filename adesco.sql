-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 19-01-2021 a las 23:41:53
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `adesco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canton`
--

CREATE TABLE `canton` (
  `idcanton` int(11) NOT NULL,
  `nombrecanton` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `canton`
--

INSERT INTO `canton` (`idcanton`, `nombrecanton`) VALUES
(2, 'Los venturas'),
(3, 'Los venturas san Rafael cedros'),
(4, 'Espinal'),
(5, 'Agua Caliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargosextras`
--

CREATE TABLE `cargosextras` (
  `idcargoextra` int(11) NOT NULL,
  `descripcion` varchar(70) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `codcliente` varchar(5) NOT NULL,
  `nombrecliente` varchar(30) NOT NULL,
  `apellidocliente` varchar(30) NOT NULL,
  `dui` varchar(10) NOT NULL,
  `nit` varchar(17) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `idcanton` int(11) NOT NULL,
  `matriculaescritura` varchar(14) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`codcliente`, `nombrecliente`, `apellidocliente`, `dui`, `nit`, `direccion`, `telefono`, `idcanton`, `matriculaescritura`, `id_usuario`) VALUES
('0257', 'Juan e', 'Rodriguez', 'a', 'a', 'a', 'a', 2, 'a', 21),
('1742', 'Juan', 'Jose', '12345678-9', '98446555', 'las lomas', '6519856', 4, '4569853', 20),
('2068', 'Egardo', 'Ramirez', '98765421-3', '1234-123456-123-1', 'las lomas', '4525-6987', 2, '4569853', 35),
('8716', 'Saul', 'Ponce', '12345678-9', '1234-123456-123-1', 'asdassadas', '4525-6987', 5, '4569853', 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumoagua`
--

CREATE TABLE `consumoagua` (
  `codcosumoagua` int(11) NOT NULL,
  `fechadelectura` date NOT NULL,
  `lecturaactual` decimal(10,2) NOT NULL,
  `lecturaanterior` decimal(10,2) NOT NULL,
  `consumodelmes` decimal(10,2) NOT NULL,
  `idcliente` varchar(5) NOT NULL,
  `idtarifa` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `consumoagua`
--

INSERT INTO `consumoagua` (`codcosumoagua`, `fechadelectura`, `lecturaactual`, `lecturaanterior`, `consumodelmes`, `idcliente`, `idtarifa`, `monto`) VALUES
(1, '2020-12-01', '5.00', '2.00', '3.00', '0257', 1, '2.39'),
(6, '2021-01-18', '20.00', '5.00', '15.00', '0257', 2, '3.25'),
(9, '2020-12-18', '10.00', '0.00', '10.00', '1742', 1, '2.39'),
(10, '2021-01-19', '10.00', '0.00', '10.00', '2068', 1, '2.39'),
(11, '2021-01-19', '25.00', '0.00', '25.00', '8716', 6, '10.30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallerecibo`
--

CREATE TABLE `detallerecibo` (
  `iddetallerecibo` int(11) NOT NULL,
  `codrecibo` int(11) NOT NULL,
  `codconsumo` int(11) NOT NULL,
  `idcargos` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadorecibo`
--

CREATE TABLE `estadorecibo` (
  `idestadorecibo` int(11) NOT NULL,
  `idrecibo` int(11) NOT NULL,
  `estado` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagorecibo`
--

CREATE TABLE `pagorecibo` (
  `idpago` int(11) NOT NULL,
  `idrecibo` int(11) NOT NULL,
  `pago` decimal(10,2) NOT NULL,
  `cambio` decimal(10,2) DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo`
--

CREATE TABLE `recibo` (
  `codrecibo` int(11) NOT NULL,
  `fechaemision` date NOT NULL,
  `codcliente` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifa`
--

CREATE TABLE `tarifa` (
  `idcobroagua` int(11) NOT NULL,
  `cantdesde_metroscubicos` decimal(10,2) NOT NULL,
  `preciopormetroscubicos` decimal(10,2) NOT NULL,
  `tarifaalcantarillado` decimal(10,2) NOT NULL,
  `canthasta_metroscubicos` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tarifa`
--

INSERT INTO `tarifa` (`idcobroagua`, `cantdesde_metroscubicos`, `preciopormetroscubicos`, `tarifaalcantarillado`, `canthasta_metroscubicos`) VALUES
(1, '0.00', '2.29', '0.10', '10.00'),
(2, '11.00', '0.21', '0.10', '20.00'),
(3, '21.00', '0.25', '1.80', '22.00'),
(4, '22.00', '0.28', '1.80', '23.00'),
(5, '23.00', '0.31', '1.80', '24.00'),
(6, '24.00', '0.34', '1.80', '25.00'),
(7, '25.00', '0.37', '1.80', '30.00'),
(8, '31.00', '0.42', '3.00', '32.00'),
(9, '32.00', '0.48', '3.00', '33.00'),
(10, '33.00', '0.54', '3.00', '34.00'),
(11, '34.00', '0.64', '3.00', '35.00'),
(12, '35.00', '0.76', '3.00', '40.00'),
(13, '41.00', '0.90', '4.00', '42.00'),
(14, '42.00', '1.05', '4.00', '43.00'),
(15, '43.00', '1.20', '4.00', '44.00'),
(16, '44.00', '1.40', '4.00', '45.00'),
(17, '45.00', '1.65', '4.00', '50.00'),
(18, '51.00', '1.90', '7.50', '60.00'),
(19, '61.00', '2.20', '7.50', '70.00'),
(20, '71.00', '2.50', '7.50', '90.00'),
(21, '91.00', '2.90', '7.50', '100.00'),
(22, '101.00', '3.40', '10.00', '500.00'),
(23, '501.00', '3.90', '20.00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `usuario` varchar(8) NOT NULL,
  `contrasenia` varchar(8) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `usuario`, `contrasenia`, `correo`, `tipo`) VALUES
(18, 'admin123', 'admin123', 'e@e.i', 'Administrador'),
(20, '1742', '1742', 'a@a.a', 'Cliente'),
(21, '0257', 'asd', '1@1.2', 'Cliente'),
(22, '12345678', '12345678', 'a@a.a', 'Administrador'),
(23, '1234567a', '01234567', 'a@a.a', 'Administrador'),
(25, 'user1234', '12345678', 'a@a.a', 'Cliente'),
(27, '9311', '12345678', 'el@es.com', 'Cliente'),
(31, 'admin456', 'admin456', '1@1.2', 'Administrador'),
(33, '8716', '12345678', 'saul@hotmail.com', 'Cliente'),
(35, '2068', '12345678', 'a@a.a', 'Cliente'),
(37, 'medidor1', 'medidor1', 'a@a.a', 'Medidor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `canton`
--
ALTER TABLE `canton`
  ADD PRIMARY KEY (`idcanton`);

--
-- Indices de la tabla `cargosextras`
--
ALTER TABLE `cargosextras`
  ADD PRIMARY KEY (`idcargoextra`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`codcliente`),
  ADD UNIQUE KEY `usuario_fk_idx` (`id_usuario`) USING BTREE,
  ADD KEY `idcanton` (`idcanton`),
  ADD KEY `id_usuario_UNIQUE` (`id_usuario`) USING BTREE;

--
-- Indices de la tabla `consumoagua`
--
ALTER TABLE `consumoagua`
  ADD PRIMARY KEY (`codcosumoagua`),
  ADD KEY `idcliente` (`idcliente`),
  ADD KEY `fk_tarifa` (`idtarifa`) USING BTREE;

--
-- Indices de la tabla `detallerecibo`
--
ALTER TABLE `detallerecibo`
  ADD PRIMARY KEY (`iddetallerecibo`),
  ADD KEY `idcargos` (`idcargos`),
  ADD KEY `codconsumo` (`codconsumo`),
  ADD KEY `codrecibo` (`codrecibo`);

--
-- Indices de la tabla `estadorecibo`
--
ALTER TABLE `estadorecibo`
  ADD PRIMARY KEY (`idestadorecibo`),
  ADD KEY `idrecibo` (`idrecibo`);

--
-- Indices de la tabla `pagorecibo`
--
ALTER TABLE `pagorecibo`
  ADD PRIMARY KEY (`idpago`),
  ADD KEY `idrecibo` (`idrecibo`);

--
-- Indices de la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD PRIMARY KEY (`codrecibo`),
  ADD KEY `codcliente` (`codcliente`);

--
-- Indices de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  ADD PRIMARY KEY (`idcobroagua`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canton`
--
ALTER TABLE `canton`
  MODIFY `idcanton` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cargosextras`
--
ALTER TABLE `cargosextras`
  MODIFY `idcargoextra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consumoagua`
--
ALTER TABLE `consumoagua`
  MODIFY `codcosumoagua` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `detallerecibo`
--
ALTER TABLE `detallerecibo`
  MODIFY `iddetallerecibo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estadorecibo`
--
ALTER TABLE `estadorecibo`
  MODIFY `idestadorecibo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagorecibo`
--
ALTER TABLE `pagorecibo`
  MODIFY `idpago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recibo`
--
ALTER TABLE `recibo`
  MODIFY `codrecibo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  MODIFY `idcobroagua` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`idcanton`) REFERENCES `canton` (`idcanton`),
  ADD CONSTRAINT `usuario_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consumoagua`
--
ALTER TABLE `consumoagua`
  ADD CONSTRAINT `consumoagua_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`codcliente`),
  ADD CONSTRAINT `consumoagua_ibfk_2` FOREIGN KEY (`idtarifa`) REFERENCES `tarifa` (`idcobroagua`);

--
-- Filtros para la tabla `detallerecibo`
--
ALTER TABLE `detallerecibo`
  ADD CONSTRAINT `detallerecibo_ibfk_4` FOREIGN KEY (`idcargos`) REFERENCES `cargosextras` (`idcargoextra`),
  ADD CONSTRAINT `detallerecibo_ibfk_5` FOREIGN KEY (`codconsumo`) REFERENCES `consumoagua` (`codcosumoagua`),
  ADD CONSTRAINT `detallerecibo_ibfk_6` FOREIGN KEY (`codrecibo`) REFERENCES `recibo` (`codrecibo`);

--
-- Filtros para la tabla `estadorecibo`
--
ALTER TABLE `estadorecibo`
  ADD CONSTRAINT `estadorecibo_ibfk_1` FOREIGN KEY (`idrecibo`) REFERENCES `recibo` (`codrecibo`);

--
-- Filtros para la tabla `pagorecibo`
--
ALTER TABLE `pagorecibo`
  ADD CONSTRAINT `pagorecibo_ibfk_1` FOREIGN KEY (`idrecibo`) REFERENCES `recibo` (`codrecibo`);

--
-- Filtros para la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD CONSTRAINT `recibo_ibfk_1` FOREIGN KEY (`codcliente`) REFERENCES `cliente` (`codcliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
