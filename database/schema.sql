CREATE TABLE IF NOT EXISTS `usuarios` (
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `rango` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `arma` (
  `Serie` varchar(50) NOT NULL,
  `Tipo_arma` varchar(50) DEFAULT NULL,
  `Modelo` varchar(50) DEFAULT NULL,
  `Ubicacion_actual` varchar(100) DEFAULT NULL,
  `Estado_arma` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Serie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `asignaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cedula_usuario` varchar(20) NOT NULL,
  `serie_arma` varchar(50) NOT NULL,
  `fecha_asignacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_devolucion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cedula_usuario` (`cedula_usuario`),
  KEY `serie_arma` (`serie_arma`),
  CONSTRAINT `asignaciones_ibfk_1` FOREIGN KEY (`cedula_usuario`) REFERENCES `usuarios` (`cedula`),
  CONSTRAINT `asignaciones_ibfk_2` FOREIGN KEY (`serie_arma`) REFERENCES `arma` (`Serie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuarios` (`cedula`, `nombre`, `apellido`, `rango`, `password`, `role`, `is_active`) VALUES
('admin', 'Admin', 'User', 'N/A', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1);
