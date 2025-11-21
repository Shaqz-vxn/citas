-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2025 a las 15:18:42
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `citas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `Id` int(11) NOT NULL,
  `Descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibilidades`
--

CREATE TABLE `disponibilidades` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` enum('disponible','reservado') NOT NULL DEFAULT 'disponible',
  `reserva_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Apellidos` varchar(255) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Servicio` varchar(255) NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `MensajeAdicional` text DEFAULT NULL,
  `Estado` enum('confirmado','cancelado') NOT NULL DEFAULT 'confirmado',
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `FechaModificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(2) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `modificado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE cargos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    area_id INT NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    FOREIGN KEY (area_id) REFERENCES areas(id)
);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `disponibilidades`
--
ALTER TABLE `disponibilidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reserva_disponibilidad` (`reserva_id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `disponibilidades`
--
ALTER TABLE `disponibilidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `disponibilidades`
--
ALTER TABLE `disponibilidades`
  ADD CONSTRAINT `fk_reserva_disponibilidad` FOREIGN KEY (`reserva_id`) REFERENCES `reservas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

-- Agregar columna cargo_id a usuarios
ALTER TABLE usuarios
ADD cargo_id INT NULL AFTER password;

ALTER TABLE usuarios
ADD FOREIGN KEY (cargo_id) REFERENCES cargos(id);

-- Agregar columna cargo_id a disponibilidades
ALTER TABLE disponibilidades
ADD cargo_id INT NOT NULL AFTER hora;

ALTER TABLE disponibilidades
ADD FOREIGN KEY (cargo_id) REFERENCES cargos(id);

-- Nueva restricción por fecha/hora para cada cargo
ALTER TABLE disponibilidades
ADD UNIQUE INDEX uq_fecha_hora_cargo (fecha, hora, cargo_id);

INSERT INTO areas (nombre) VALUES
('Alcaldía'),
('Concejo Municipal'),
('Administración Municipal'),
('Administración y Finanzas'),
('Control'),
('Cultura y Biblioteca Municipal'),
('Combustibles'),
('Departamento de Salud'),
('CESFAM de Pinto'),
('Desarrollo Comunitario'),
('Deportes'),
('Discapacidad'),
('Fomento Productivo'),
('Informática Municipal'),
('Inspección Municipal'),
('Juzgado de Policía Local'),
('Medio Ambiente'),
('Oficina Local de la Niñez'),
('Obras Municipales'),
('OMIL'),
('Organizaciones Comunitarias'),
('PRODESAL'),
('Rentas y Patentes'),
('SECPLAN'),
('Secretaría Municipal'),
('Seguridad Pública'),
('Tesorería'),
('Tránsito y Transporte'),
('Transparencia y Lobby Municipal'),
('Turismo'),
('Vehículos y Maquinaria Pesada');

INSERT INTO cargos (area_id, nombre) VALUES
(1, 'Alcalde'),
(1, 'Secretaria'),
(1, 'Gabinete'),
(1, 'Comunicaciones');

INSERT INTO cargos (area_id, nombre) VALUES
(2, 'Concejal');

INSERT INTO cargos (area_id, nombre) VALUES
(3, 'Administrador Municipal'),
(3, 'Asesor Jurídico');

INSERT INTO cargos (area_id, nombre) VALUES
(4, 'Director DAF'),
(4, 'Secretaria Finanzas'),
(4, 'Profesional Finanzas'),
(4, 'Remuneraciones'),
(4, 'Apoyo Recursos Humanos'),
(4, 'Adquisiciones');

INSERT INTO cargos (area_id, nombre) VALUES
(5, 'Director de Control');

INSERT INTO cargos (area_id, nombre) VALUES
(6, 'Encargado');

INSERT INTO cargos (area_id, nombre) VALUES
(7, 'Encargada');

INSERT INTO cargos (area_id, nombre) VALUES
(8, 'Director DESAMU'),
(8, 'Secretaria DESAMU');

INSERT INTO cargos (area_id, nombre) VALUES
(9, 'Director CESFAM'),
(9, 'Secretaria CESFAM'),
(9, 'Administrativo SOME'),
(9, 'TENS de Turno Urgencias');

INSERT INTO cargos (area_id, nombre) VALUES
(10, 'Directora de DIDECO'),
(10, 'Secretaria de DIDECO'),
(10, 'Asistente Social'),
(10, 'Subsidios y Pensiones'),
(10, 'Habitabilidad'),
(10, 'Apoyo JUNAEB e IPS'),
(10, 'Programa de Apoyo a la Seguridad Alimentaria'),
(10, 'Registro Social de Hogares'),
(10, 'Programa Familias'),
(10, 'Programa Vínculos'),
(10, 'SENDA Previene'),
(10, 'Centro Diurno Pinto');

INSERT INTO cargos (area_id, nombre) VALUES
(11, 'Encargada');

INSERT INTO cargos (area_id, nombre) VALUES
(12, 'Encargada'),
(12, 'Profesional');

INSERT INTO cargos (area_id, nombre) VALUES
(13, 'Encargado');

INSERT INTO cargos (area_id, nombre) VALUES
(14, 'Encargado');

INSERT INTO cargos (area_id, nombre) VALUES
(15, 'Inspector Municipal');

INSERT INTO cargos (area_id, nombre) VALUES
(16, 'Jueza'),
(16, 'Abogada / Secretaria'),
(16, 'Administrativa');

INSERT INTO cargos (area_id, nombre) VALUES
(17, 'Encargado');

INSERT INTO cargos (area_id, nombre) VALUES
(18, 'Coordinadora OLN'),
(18, 'Gestora de Casos'),
(18, 'Gestora Territorial');

INSERT INTO cargos (area_id, nombre) VALUES
(19, 'Director'),
(19, 'Secretaria'),
(19, 'Inspector I.T.O.'),
(19, 'Administrativo/a');

INSERT INTO cargos (area_id, nombre) VALUES
(20, 'Encargada'),
(20, 'Ejecutiva Empresas'),
(20, 'Orientadora Laboral');

INSERT INTO cargos (area_id, nombre) VALUES
(21, 'Encargada');

INSERT INTO cargos (area_id, nombre) VALUES
(22, 'Coordinador Técnico'),
(22, 'Ingeniero Agrónomo'),
(22, 'Medico Veterinario'),
(22, 'Técnico Agrícola');

INSERT INTO cargos (area_id, nombre) VALUES
(23, 'Jefa de Rentas y Patentes'),
(23, 'Administrativo/a');

INSERT INTO cargos (area_id, nombre) VALUES
(24, 'Director'),
(24, 'Arquitecto'),
(24, 'Asistente Social'),
(24, 'Profesional'),
(24, 'Ingeniero Civil');

INSERT INTO cargos (area_id, nombre) VALUES
(25, 'Secretario Municipal'),
(25, 'Oficina de Partes');

INSERT INTO cargos (area_id, nombre) VALUES
(26, 'Encargado');

INSERT INTO cargos (area_id, nombre) VALUES
(27, 'Tesorero Municipal'),
(27, 'Secretario');

INSERT INTO cargos (area_id, nombre) VALUES
(28, 'Director'),
(28, 'Secretaria'),
(28, 'Administrativa');

INSERT INTO cargos (area_id, nombre) VALUES
(29, 'Encargado');

INSERT INTO cargos (area_id, nombre) VALUES
(30, 'Encargada');

INSERT INTO cargos (area_id, nombre) VALUES
(31, 'Encargado'),
(31, 'Apoyo Administrativo');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
