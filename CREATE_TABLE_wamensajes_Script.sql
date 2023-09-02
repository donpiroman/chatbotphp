CREATE TABLE `wamensajes` (
  `correlativo` int(11) NOT NULL AUTO_INCREMENT,
  `mensaje` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `id` varchar(45) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `Respuesta` varchar(2000) DEFAULT NULL,
  `WhenInserted` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`correlativo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci