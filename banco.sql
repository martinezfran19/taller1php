-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2022 a las 05:47:48
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `banco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `id` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `tipoCuenta` varchar(50) NOT NULL,
  `numeroCuenta` int(15) NOT NULL,
  `ultimoMovimiento` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fechaRegistro` date NOT NULL DEFAULT curdate(),
  `codigoSeguridad` int(11) NOT NULL,
  `saldoDisponible` float NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`id`, `idPersona`, `tipoCuenta`, `numeroCuenta`, `ultimoMovimiento`, `fechaRegistro`, `codigoSeguridad`, `saldoDisponible`, `email`) VALUES
(1, 1, 'Ahorros', 123456789, '2020-05-19 07:45:15', '2017-01-01', 1234, 60500, 'franma.martinez19@gmail.com'),
(2, 1, 'Corriente', 987654321, '2020-05-19 07:45:15', '2022-09-21', 1212, 12000, 'franma.martinez19@gmail.com'),
(3, 2, 'Corriente', 192837465, '2022-09-25 10:05:00', '2022-09-25', 1111, 45670, 'jorge@mail.com'),
(4, 6, 'Ahorros', 129834765, '2022-09-25 10:05:00', '2015-03-21', 2222, 143250, 'nataly@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `identificacion` int(15) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `identificacion`, `nombres`, `apellidos`) VALUES
(1, 1003189162, 'Francisco', 'Martinez Torreglosa'),
(2, 1003189160, 'Jorge Mario', 'Martinez Torreglosa'),
(4, 189189189, 'Alfonso', 'Campos Rodriguez'),
(5, 162162162, 'Maria Elena', 'Diaz Dominguez'),
(6, 1007198178, 'Nataly Andrea', 'Bedoya Arroyo'),
(12, 10011001, 'nombres de', 'prueba insertar');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numeroCuenta` (`numeroCuenta`),
  ADD KEY `fk_persona` (`idPersona`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identificacion` (`identificacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `cuenta_ibfk_1` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`id`),
  ADD CONSTRAINT `fk_persona` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
