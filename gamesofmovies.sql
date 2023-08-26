-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-08-2023 a las 02:03:36
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
-- Base de datos: `gamesofmovies`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `IdPelicula` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `duracion` text NOT NULL,
  `restriccionEdad` text NOT NULL,
  `categoria` text NOT NULL,
  `tipo` text NOT NULL,
  `precio` text NOT NULL DEFAULT '10',
  `descripcion` text NOT NULL,
  `imgResource` text NOT NULL,
  `habilitada` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`IdPelicula`, `titulo`, `duracion`, `restriccionEdad`, `categoria`, `tipo`, `precio`, `descripcion`, `imgResource`, `habilitada`) VALUES
(1, 'PAW PATROL', '85', 'ATP', 'Animada', '2D', '100', 'Películas para Niños', 'paw.jpeg', 'Si'),
(2, 'Venganza Implacable', '98', '18+', 'Accion', '2D', '35', 'Buena Pelicula de Accion', 'venganza_implacable.jpeg', 'Si'),
(3, 'Sin Tiempo Para Morir', '92', '16+', 'Accion', '2D', '200', 'Buena Pelicula de Aventura', 'sin_tiempo_para_morir.jpeg', 'Si'),
(4, 'Sin Tiempo Para Morir', '56', '16+', 'Animada', '3D', '345', 'Película en 3D', 'sin_tiempo_para_morir_3d.jpeg', 'Si'),
(5, 'AINBO', '85', '16+', 'Accion', '2D', '12', 'Buena película para menores de 13', 'aimbo.jpeg', 'Si'),
(69, 'dfh', '346', '16+', '346', '2D', '345', 'hgkghk', 'NoImagen.jpeg', 'Si'),
(75, 'asdhgf', '459', '16+', 'Accion', '2D', '345', 'dfh', 'NoImagen.jpeg', 'No'),
(76, 'aa', '459', 'ATP', 'Animada56', '3D', '345', 'ghk', 'auto1.jpg', 'Si'),
(77, 'fdhdfhdfh', '459', '16+', 'Animada56', '2D', '25', 'dfhfdh', 'NoImagen.jpeg', 'Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proximaspeliculas`
--

CREATE TABLE `proximaspeliculas` (
  `IdPelicula` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `duracion` text NOT NULL,
  `restriccionEdad` text NOT NULL,
  `categoria` text NOT NULL,
  `tipo` text NOT NULL,
  `imgResource` text NOT NULL,
  `fechaEstreno` date NOT NULL,
  `habilitada` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proximaspeliculas`
--

INSERT INTO `proximaspeliculas` (`IdPelicula`, `titulo`, `duracion`, `restriccionEdad`, `categoria`, `tipo`, `imgResource`, `fechaEstreno`, `habilitada`) VALUES
(2, 'Avatar 2', '98', '18+', 'Accion', '2D', 'Avatar_El_sentido_del_agua-593536896-large.jpg', '2023-01-16', 'Si'),
(29, 'Transformer 7', '120', 'ATP', 'Animada', '2D', 'Transformers_7.jpg', '2022-12-30', 'Si'),
(49, 'aaa', '459', '16+', 'Animada56', '2D', 'WhatsApp Image 2023-05-30 at 15.29.38.jpeg ', '2023-06-30', 'Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecciones`
--

CREATE TABLE `proyecciones` (
  `IdVenta` int(11) NOT NULL,
  `IdPelicula` int(4) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `fechaPelicula` date NOT NULL,
  `horaPelicula` text NOT NULL,
  `CantBoleto` int(2) NOT NULL COMMENT '50',
  `precioFinal` int(2) NOT NULL,
  `Anulada` text NOT NULL,
  `fechaReserva` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proyecciones`
--

INSERT INTO `proyecciones` (`IdVenta`, `IdPelicula`, `IdUsuario`, `fechaPelicula`, `horaPelicula`, `CantBoleto`, `precioFinal`, `Anulada`, `fechaReserva`) VALUES
(144, 1, 99, '2023-06-25', '19hs', 2, 200, 'Si', NULL),
(145, 1, 99, '2023-06-25', '19hs', 3, 300, 'No', '2023-06-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `IdUsuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `telefono` varchar(17) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contraseña` varchar(200) NOT NULL,
  `habilitado` varchar(2) NOT NULL,
  `privilegio` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IdUsuario`, `nombre`, `apellido`, `usuario`, `telefono`, `email`, `contraseña`, `habilitado`, `privilegio`) VALUES
(92, 'Nicolas', 'Fritz', 'admin', '2284965132', 'admin@gmail.com', '$2y$04$FFJJ2VIOk5l1vcjylfWeY.4VZ2SnCzBnBe/zQSevX.Ulr39MWiFly', 'Si', 'Administrador'),
(99, 'oo', 'oo', 'oo', '55', 'oo', '$2y$04$ePVMi7G06541RqVg0zaUpugeqz7fNYrdEG8ETecdolF0R59aqgzui', 'Si', 'Usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`IdPelicula`);

--
-- Indices de la tabla `proximaspeliculas`
--
ALTER TABLE `proximaspeliculas`
  ADD PRIMARY KEY (`IdPelicula`) USING BTREE;

--
-- Indices de la tabla `proyecciones`
--
ALTER TABLE `proyecciones`
  ADD PRIMARY KEY (`IdVenta`),
  ADD KEY `IdPelicula` (`IdPelicula`),
  ADD KEY `IdUsuario` (`IdUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `IdPelicula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `proximaspeliculas`
--
ALTER TABLE `proximaspeliculas`
  MODIFY `IdPelicula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `proyecciones`
--
ALTER TABLE `proyecciones`
  MODIFY `IdVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `proyecciones`
--
ALTER TABLE `proyecciones`
  ADD CONSTRAINT `proyecciones_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proyecciones_ibfk_2` FOREIGN KEY (`IdPelicula`) REFERENCES `peliculas` (`IdPelicula`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
