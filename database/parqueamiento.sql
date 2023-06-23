-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-06-2020 a las 13:32:22
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `parqueamiento`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id_caja` int(200) NOT NULL,
  `estado` varchar(200) NOT NULL,
  `monto` varchar(200) NOT NULL,
  `fecha_apertura` date NOT NULL,
  `fecha_cierre` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(200) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `ruc` varchar(200) NOT NULL,
  `telefono` varchar(200) NOT NULL,
  `dni` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(100) NOT NULL,
  `empresa` varchar(200) NOT NULL,
  `ruc` varchar(100) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `descripcion` varchar(2000) NOT NULL,
  `imagen` varchar(2000) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `simbolo_moneda` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `empresa`, `ruc`, `direccion`, `telefono`, `descripcion`, `imagen`, `correo`, `simbolo_moneda`) VALUES
(1, 'parqueamiento tusolutionweb', '4324', 'av san marino', '242432334', 'empresa de parqueamiento ', 'logo.jpg', 'tusolutionweb@gmail.com', '$./');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id_entrada` int(200) NOT NULL,
  `codigo` varchar(200) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_ingreso` varchar(200) NOT NULL,
  `hora_salida` varchar(200) NOT NULL,
  `vehiculo` int(200) NOT NULL,
  `lugar` int(200) NOT NULL,
  `dia_noche` varchar(200) NOT NULL,
  `time_entrada` varchar(200) NOT NULL,
  `time_salida` varchar(200) NOT NULL,
  `pago` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `espacios`
--

CREATE TABLE `espacios` (
  `id_espacios` int(200) NOT NULL,
  `numero` varchar(200) NOT NULL,
  `estado` varchar(200) NOT NULL,
  `codigo_entrada` varchar(200) NOT NULL,
  `medida` varchar(200) NOT NULL,
  `placa` varchar(200) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `hora_ingreso` varchar(200) NOT NULL,
  `salida` varchar(200) NOT NULL,
  `tipo_espacio` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id_gastos` int(200) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `cantidad` varchar(200) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` int(200) NOT NULL,
  `id_usuario` int(200) NOT NULL,
  `fechaactual` date NOT NULL,
  `fechareserva` date NOT NULL,
  `hora` varchar(200) NOT NULL,
  `estado` varchar(200) NOT NULL,
  `am_pm` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifa`
--

CREATE TABLE `tarifa` (
  `id_tarifa` int(200) NOT NULL,
  `valor_hora` varchar(200) NOT NULL,
  `valor_noche` varchar(200) NOT NULL,
  `valor_mes` varchar(200) NOT NULL,
  `tipo_vehiculo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temporal`
--

CREATE TABLE `temporal` (
  `id_temporal` int(200) NOT NULL,
  `id_vehiculo` int(200) NOT NULL,
  `id_cliente` int(200) NOT NULL,
  `id_espacios` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `temporal`
--

INSERT INTO `temporal` (`id_temporal`, `id_vehiculo`, `id_cliente`, `id_espacios`) VALUES
(1, 0, 0, '55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_vehiculo`
--

CREATE TABLE `tipo_vehiculo` (
  `id_tipo_vehiculo` int(200) NOT NULL,
  `nombre_tipo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(200) NOT NULL,
  `usuario` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `tipo` varchar(200) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `telefono` varchar(200) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `estado` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `password`, `imagen`, `tipo`, `nombre`, `apellido`, `telefono`, `correo`, `estado`) VALUES
(5, 'admin', 'a1Bz20ydqelm8m1wql21232f297a57a5a743894a0e4a801fc3', 'logo.jpg', 'administrador', 'Eduar', 'Elric', '423424234', 'emperatriz@gmail.com', 'activo'),
(6, 'jason', 'a1Bz20ydqelm8m1wql2b877b4b825b48a9a0950dd5bd1f264d', '', 'empleado', 'jason', 'peres', '34534453', '', 'activo'),
(7, 'jose', 'a1Bz20ydqelm8m1wql662eaa47199461d01a623884080934ab', '', 'reserva', 'jose', 'perez', '4235325', 'jose@gmail.com', 'activo'),
(8, 'napoleon', 'a1Bz20ydqelm8m1wql21232f297a57a5a743894a0e4a801fc3', 'dia amistad.jpg', 'administrador', 'napoleon', 'hill', '1231321123', 'napoleon@gmail.com', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `id_vehiculo` int(200) NOT NULL,
  `placa` varchar(200) NOT NULL,
  `tipo` varchar(200) NOT NULL,
  `marca` varchar(200) NOT NULL,
  `modelo` varchar(200) NOT NULL,
  `color` varchar(200) NOT NULL,
  `id_cliente` int(200) NOT NULL,
  `estado_vehiculo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id_caja`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id_entrada`);

--
-- Indices de la tabla `espacios`
--
ALTER TABLE `espacios`
  ADD PRIMARY KEY (`id_espacios`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id_gastos`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`);

--
-- Indices de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  ADD PRIMARY KEY (`id_tarifa`);

--
-- Indices de la tabla `temporal`
--
ALTER TABLE `temporal`
  ADD PRIMARY KEY (`id_temporal`);

--
-- Indices de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  ADD PRIMARY KEY (`id_tipo_vehiculo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`id_vehiculo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_caja` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id_entrada` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `espacios`
--
ALTER TABLE `espacios`
  MODIFY `id_espacios` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id_gastos` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  MODIFY `id_tarifa` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `temporal`
--
ALTER TABLE `temporal`
  MODIFY `id_temporal` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  MODIFY `id_tipo_vehiculo` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `id_vehiculo` int(200) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  ADD CONSTRAINT `tipo_vehiculo_ibfk_1` FOREIGN KEY (`id_tipo_vehiculo`) REFERENCES `vehiculo` (`id_vehiculo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
