-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
<<<<<<< HEAD
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-06-2026 a las 21:40:53
=======
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 09-06-2026 a las 22:16:35
>>>>>>> origin/main
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_general`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado` enum('pendiente','en_camino','entregado') DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `total`, `estado`, `fecha`) VALUES
(1, 1, 657012.00, 'entregado', '2026-05-29 22:18:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`) VALUES
<<<<<<< HEAD
(1, 'Celulares', 'Samsung A5', 123454.00, 9, NULL),
(2, 'Tablet', 'Tablet Lenovo', 524658.00, 19, NULL),
(3, 'Computadoras samsung', 'Computadora', 434567.00, 24, NULL),
(4, 'Auriculares', 'cable', 8900.00, 32, NULL),
(5, 'Auriculares inalambricos', 'auriculares Bluetooth', 50000.00, 10, NULL),
(6, 'PC gamer', 'Gamer', 538000.00, 12, NULL),
(7, 'CPU', 'CPU pro', 340500.00, 11, NULL),
(8, 'Iphone 17', 'Iphone', 2345678.00, 10, NULL);
=======
(1, 'Celulares', 'Samsung A5', 123454.00, 10, NULL),
(2, 'Tablet', 'Tablet Lenovo', 524658.00, 19, NULL),
(3, 'Computadoras samsung', 'Computadora', 434567.00, 24, NULL),
(4, 'Auriculares Samsung', 'auriculares  ', 100.00, 5, NULL),
(5, 'Auriculares inalambricos', 'auriculares Bluetooth', 50000.00, 10, NULL),
(6, 'PC gamer', 'Gamer', 538000.00, 12, NULL),
(10, 'Pc Gamer', 'Intel I7 Ram 16gb 500g Placa Video Gddr5 Led 19 ', 700000.00, 2, NULL),
(11, 'Porta celulares', 'Porta celulares para tener tu celular ', 40000.00, 30, NULL);
>>>>>>> origin/main

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
<<<<<<< HEAD
  `password` varchar(255) DEFAULT NULL,
=======
  `password` varchar(255) NOT NULL,
>>>>>>> origin/main
  `telefono` varchar(30) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `rol` enum('admin','vendedor','repartidor','usuario') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `telefono`, `direccion`, `rol`) VALUES
(1, 'Admin', 'admin@gmail.com', '123456', NULL, NULL, 'admin'),
<<<<<<< HEAD
(2, 'Vendedor', 'vendedor@ejemplo.com', '1234', NULL, NULL, 'vendedor'),
(3, 'Repartidor', 'repartidor@ejemplo.com', '1234', NULL, NULL, 'repartidor'),
(4, 'Cliente', 'usuario@ejemplo.com', '1234', NULL, NULL, '');
=======
(21, 'Admin', 'admin@tienda.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, 'admin'),
(22, 'Ivan Vendedor', 'ivan@tienda.com', '$2y$10$LWNFvOaWw45e4ciPmUzEoO6RLcYxCme3H4IVm7UvSNYVqlEzT5iVu', NULL, NULL, 'vendedor'),
(24, 'Lucia Repartidora', 'lucia@tienda.com', '$2y$10$ZqvSGm5pr0o9VXRTpJSPeebbreqgrGagA476qgCloMGN/vxl5Plc.', NULL, NULL, 'repartidor'),
(25, 'Amelia Beatriz', 'amelia@4bits.com', '$2y$10$PsgAtSAE5t27XKLZIhFIYO4auLwnUJOxsWju8i3HPcvM1Ac17s5XO', NULL, NULL, '');
>>>>>>> origin/main

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
<<<<<<< HEAD
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
>>>>>>> origin/main

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
<<<<<<< HEAD
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
>>>>>>> origin/main

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
<<<<<<< HEAD
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
>>>>>>> origin/main

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `detalle_pedidos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalle_pedidos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
