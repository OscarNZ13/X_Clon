-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-03-2024 a las 19:31:44
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
-- Base de datos: `db_x`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacionseguimiento`
--

CREATE TABLE `relacionseguimiento` (
  `ID_Seguidor` int(11) NOT NULL,
  `ID_Seguido` int(11) NOT NULL,
  `FechaInicio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tweets`
--

CREATE TABLE `tweets` (
  `ID_Tweet` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `Contenido` text NOT NULL,
  `FechaPublicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Likes` int(11) DEFAULT 0,
  `Retweets` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `ID_Usuario` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `CorreoElectronico` varchar(255) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Biografia` text DEFAULT NULL,
  `Ubicacion` varchar(255) DEFAULT NULL,
  `FotoPerfil` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`ID_Usuario`, `Nombre`, `CorreoElectronico`, `Contraseña`, `FechaCreacion`, `Biografia`, `Ubicacion`, `FotoPerfil`) VALUES
(1, 'Oscar', 'oscarnaranjoz13@gmail.com', 'oscar123', '2024-03-07 18:14:41', 'lml', 'Alajuela', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fes.pngtree.com%2Ffree-backgrounds-photos%2Ftwitter-sin-foto-de-perfil&psig=AOvVaw1ZxZE2OmqtnVfoS18r53hF&ust=1709921481401000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCKCcrYbg4oQDFQAAAAAdAAAAABAF');


--
-- Volcado de datos para la tabla `tweets`
--

INSERT INTO tweets (ID_Tweet, ID_Usuario, Contenido, FechaPublicacion, Likes, Retweets) 
VALUES 
(1, 1, 'Este es el primer tweet', CURRENT_TIMESTAMP, 10, 5),
(2, 1, 'Este es el segundo tweet', CURRENT_TIMESTAMP, 8, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `relacionseguimiento`
--
ALTER TABLE `relacionseguimiento`
  ADD PRIMARY KEY (`ID_Seguidor`,`ID_Seguido`),
  ADD KEY `ID_Seguido` (`ID_Seguido`);

--
-- Indices de la tabla `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`ID_Tweet`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID_Usuario`),
  ADD UNIQUE KEY `CorreoElectronico` (`CorreoElectronico`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tweets`
--
ALTER TABLE `tweets`
  MODIFY `ID_Tweet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `relacionseguimiento`
--
ALTER TABLE `relacionseguimiento`
  ADD CONSTRAINT `relacionseguimiento_ibfk_1` FOREIGN KEY (`ID_Seguidor`) REFERENCES `user` (`ID_Usuario`),
  ADD CONSTRAINT `relacionseguimiento_ibfk_2` FOREIGN KEY (`ID_Seguido`) REFERENCES `user` (`ID_Usuario`);

--
-- Filtros para la tabla `tweets`
--
ALTER TABLE `tweets`
  ADD CONSTRAINT `tweets_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `user` (`ID_Usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
