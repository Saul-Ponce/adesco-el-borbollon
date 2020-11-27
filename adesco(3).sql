-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-11-2020 a las 05:15:17
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
(18, 'admin123', 'admin123', 'e@e.e', 'Administrador'),
(19, 'user1234', 'user1234', 'e@e.e', 'Cliente');

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
  ADD UNIQUE KEY `id_usuario_UNIQUE` (`id_usuario`),
  ADD KEY `usuario_fk_idx` (`id_usuario`),
  ADD KEY `idcanton` (`idcanton`);

--
-- Indices de la tabla `consumoagua`
--
ALTER TABLE `consumoagua`
  ADD PRIMARY KEY (`codcosumoagua`),
  ADD UNIQUE KEY `fk_tarifa` (`idtarifa`),
  ADD KEY `idcliente` (`idcliente`);

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
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canton`
--
ALTER TABLE `canton`
  MODIFY `idcanton` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargosextras`
--
ALTER TABLE `cargosextras`
  MODIFY `idcargoextra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consumoagua`
--
ALTER TABLE `consumoagua`
  MODIFY `codcosumoagua` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `idcobroagua` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
