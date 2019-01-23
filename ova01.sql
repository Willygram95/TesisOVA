-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 12-07-2018 a las 00:55:30
-- Versión del servidor: 5.7.17-log
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ova01`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovaarchivos`
--

CREATE TABLE `ovaarchivos` (
  `id` smallint(6) NOT NULL,
  `nombreoriginal` varchar(150) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo` varchar(6) NOT NULL,
  `tamano` int(11) NOT NULL,
  `archivo` mediumblob NOT NULL,
  `id_tema` smallint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ovaarchivos`
--

INSERT INTO `ovaarchivos` (`id`, `nombreoriginal`, `nombre`, `tipo`, `tamano`, `archivo`, `id_tema`) VALUES
INSERT INTO `ovaarchivos` (`id`, `nombreoriginal`, `nombre`, `tipo`, `tamano`, `archivo`, `id_tema`) VALUES

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovaareasc`
--

CREATE TABLE `ovaareasc` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  `orden` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ovaareasc`
--

INSERT INTO `ovaareasc` (`id`, `titulo`, `status`, `orden`) VALUES
(2, 'Área 1', 1, 1),
(3, 'Área 2', 1, 2),
(4, 'Área 3', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovaasignatura`
--

CREATE TABLE `ovaasignatura` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `prerequisitos` varchar(255) NOT NULL,
  `programa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ovaasignatura`
--

INSERT INTO `ovaasignatura` (`id`, `codigo`, `nombre`, `prerequisitos`, `programa`) VALUES
(1, '000-1234', 'Asignatura 1', 'Asignatura 0', '<p class=\"MsoNormal\">&nbsp;</p>\r\n<ul>\r\n<li>Area 1</li>\r\n<li>Area 2</li>\r\n<li>Area 3</li>\r\n</ul>\r\n<p>&nbsp;</p>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovabibliografia`
--

CREATE TABLE `ovabibliografia` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `autor` varchar(150) NOT NULL,
  `info` varchar(500) NOT NULL,
  `id_tema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ovabibliografia`
--

INSERT INTO `ovabibliografia` (`id`, `titulo`, `autor`, `info`, `id_tema`) VALUES
(7, 'Web 2.0. ', 'Fumero, A. y Roca, G.', '<p class=\\\"MsoNoSpacing\\\" style=\\\"text-align: justify;\\\"><span style=\\\"font-size: 12.0pt; font-family: \\\'Arial\\\',\\\'sans-serif\\\';\\\">Fundaci&oacute;n Orange Espa&ntilde;a. Madrid. Espa&ntilde;a. 2007.</span></p>', 0),
(9, 'Enseñanza virtual sobre la organización de recursos informativos digitales.', 'Garduño, R. ', '<p><span lang=\\\"ES\\\" style=\\\"font-size: 12.0pt; line-height: 150%; font-family: \\\'Arial\\\',\\\'sans-serif\\\'; mso-fareast-font-family: \\\'Times New Roman\\\'; mso-ansi-language: ES; mso-fareast-language: ES; mso-bidi-language: AR-SA;\\\">Primera edici&oacute;n. UNAM, Centro Universitario de Investigaciones Bibliotecol&oacute;gicas. M&eacute;xico. 2005.</span></p>', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovadiseno`
--

CREATE TABLE `ovadiseno` (
  `id` int(11) NOT NULL,
  `numopcfilas` int(10) NOT NULL,
  `colorprincipal` text NOT NULL,
  `colorsecundario` text NOT NULL,
  `colorterciario` text NOT NULL,
  `colorderesalte` text NOT NULL,
  `colordeletraresalte` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ovadiseno`
--

INSERT INTO `ovadiseno` (`id`, `numopcfilas`, `colorprincipal`, `colorsecundario`, `colorterciario`, `colorderesalte`, `colordeletraresalte`) VALUES
(1, 4, '#ff0080', '#e0005a', '#ff0068', '#e5c1d0', '#800000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovaenlaces`
--

CREATE TABLE `ovaenlaces` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `url` varchar(250) NOT NULL,
  `id_tema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ovaenlaces`
--

INSERT INTO `ovaenlaces` (`id`, `titulo`, `url`, `id_tema`) VALUES
(1, 'Google', 'http://www.google.co.ve', 10),
(20, 'Facebook', 'www.fb.com', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovaglosario`
--

CREATE TABLE `ovaglosario` (
  `id` int(11) NOT NULL,
  `termino` varchar(100) NOT NULL,
  `definicion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ovaglosario`
--

INSERT INTO `ovaglosario` (`id`, `termino`, `definicion`) VALUES
(1, 'Algoritmo', 'Conjunto ordenado de operaciones sistemáticas que permite hacer un cálculo y hallar la solución de un tipo de problemas<span style=\"color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: small;\">.</span>'),
(3, 'Modelo', '<div style=\"float: left;\"><span style=\"\" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;\"=\"\">Esquema teórico que representa una realidad compleja o un proceso complicado y que sirve para facilitar su comprensión.</span></div>'),
(4, 'Probabilidad', 'Cálculo matemático de las posibilidades que existen de que una cosa se cumpla o suceda al azar.'),
(5, 'Análisis', 'Examen detallado de una cosa para conocer sus características o cualidades, o su estado, y extraer conclusiones, que se realiza separando o considerando por separado las partes que la constituyen.'),
(10, 'Vector', '<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 16px; text-align: justify;\">Un&nbsp;n-vector (o vector de dimensi&oacute;n n) es un arreglo de n n&uacute;meros escritos en un rengl&oacute;n o una columna.</span></p>'),
(14, 'Ecuación', '<p style=\"text-align: justify;\"><span style=\"font-size: 12pt; font-family: arial, helvetica, sans-serif;\">Es una igualdad matem&aacute;tica que relaciona unas cantidades inc&oacute;gnitas con unos datos conocidos, a trav&eacute;s de diversas operaciones matem&aacute;ticas.&nbsp;</span></p>\r\n<p style=\"text-align: justify;\"><span style=\"font-size: 12pt; font-family: arial, helvetica, sans-serif;\">&nbsp; &nbsp;Por ejemplo: 3<strong>x</strong>&nbsp;&minus; 6 = 0<span lang=\"es-419\">.</span></span></p>'),
(17, 'OVA (Objeto Virtual de Aprendizaje)', '<p style=\"text-align: justify;\"><span style=\"font-size: 12pt; line-height: 115%; font-family: Arial, sans-serif;\">&nbsp; Cualquier recurso digital que se puede utilizar como apoyo para el aprendizaje&rdquo;; es decir, que una imagen, audios, textos o videos son considerados como recursos que se pueden utilizar para el dise&ntilde;o de un </span><span style=\"font-size: 12pt; line-height: 115%; font-family: Arial, sans-serif;\">OVA. </span><span style=\"font-size: 12pt; line-height: 115%; font-family: Arial, sans-serif;\">De tal manera, que poseen unas caracter&iacute;sticas espec&iacute;ficas que los hacen diferentes de otros recursos educativos y se reconocen como rasgos esenciales del objeto: reusabilidad, adaptabilidad y escalabilidad.&nbsp;</span></p>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovaimagenes`
--

CREATE TABLE `ovaimagenes` (
  `id` smallint(6) NOT NULL,
  `nombreoriginal` varchar(150) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `ancho` smallint(6) NOT NULL,
  `alto` smallint(6) NOT NULL,
  `tipo` char(15) NOT NULL,
  `imagen` mediumblob NOT NULL,
  `tamano` int(11) NOT NULL,
  `id_tema` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovapuntaje`
--

CREATE TABLE `ovapuntaje` (
  `id` smallint(6) NOT NULL,
  `id_usuario` smallint(6) NOT NULL,
  `tema` varchar(255) NOT NULL,
  `areac` varchar(255) NOT NULL,
  `preguntas` varchar(2048) NOT NULL,
  `npreguntas` smallint(6) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(8) NOT NULL,
  `repeticiones` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovaseleccion`
--

CREATE TABLE `ovaseleccion` (
  `id` smallint(6) NOT NULL,
  `enunciado` varchar(1000) NOT NULL,
  `opcion1` varchar(250) NOT NULL,
  `opcion2` varchar(250) NOT NULL,
  `opcion3` varchar(250) NOT NULL,
  `opcion4` varchar(250) NOT NULL,
  `opcioncorrecta` smallint(6) NOT NULL,
  `tipo` smallint(6) NOT NULL,
  `numopciones` smallint(6) NOT NULL,
  `valor` smallint(6) NOT NULL,
  `orden` smallint(6) NOT NULL,
  `id_tema` smallint(6) NOT NULL,
  `numerogrupo` smallint(6) NOT NULL,
  `status` smallint(6) NOT NULL,
  `categoria` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ovaseleccion`
--

INSERT INTO `ovaseleccion` (`id`, `enunciado`, `opcion1`, `opcion2`, `opcion3`, `opcion4`, `opcioncorrecta`, `tipo`, `numopciones`, `valor`, `orden`, `id_tema`, `numerogrupo`, `status`, `categoria`) VALUES
(3, '<p><span style=\"font-size: 12pt; font-family: arial, helvetica, sans-serif;\"><strong>&iquest;Qu&eacute; son modelos?</strong></span></p>', 'Se enfoca en aquellas situaciones donde hay que tener en cuenta los factores crítico.', 'Una representación  o abstracción de un objeto real o de una situación real.', 'Duplicidad y posibilidad.', '', 2, 1, 3, 0, 1, 10, 1, 1, 1),
(9, '<p><span style=\"font-size: 12pt; font-family: arial, helvetica, sans-serif;\"><strong>Primero se suma luego se divide...</strong></span></p>', 'Verdadero', 'Falso', '', '', 2, 2, 2, 0, 2, 10, 1, 1, 1),
(11, '<p><span style=\"font-size: 12pt; font-family: arial, helvetica, sans-serif;\">Identifique la imagen&nbsp;&nbsp;</span> &nbsp;</p>\r\n<p>&nbsp; &nbsp; &nbsp;&nbsp;<img src=\"imagenes/modelo iconico4.png\" alt=\"\" width=\"174\" height=\"171\" /></p>', 'Pelota', 'Planeta', 'Sistema', '', 2, 1, 3, 2, 1, 10, 1, 1, 2),
(15, '<p style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 16px;\">Primero se multiplica y luego se resta</span></span></p>', 'Verdadero', 'Falso', '', '', 1, 2, 2, 2, 2, 10, 1, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovatemas`
--

CREATE TABLE `ovatemas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `introduccion` longtext NOT NULL,
  `prerequisitos` text NOT NULL,
  `status` int(11) NOT NULL,
  `id_areac` int(11) NOT NULL,
  `ayuda` longtext NOT NULL,
  `orden` smallint(6) NOT NULL,
  `titulovideo` varchar(100) NOT NULL,
  `enlacevideo` varchar(255) NOT NULL,
  `tituloaudio` varchar(100) NOT NULL,
  `archivoaudio` varchar(255) NOT NULL,
  `tituloexterno` varchar(100) NOT NULL,
  `contenidoexterno` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ovatemas`
--

INSERT INTO `ovatemas` (`id`, `titulo`, `introduccion`, `prerequisitos`, `status`, `id_areac`, `ayuda`, `orden`, `titulovideo`, `enlacevideo`, `tituloaudio`, `archivoaudio`, `tituloexterno`, `contenidoexterno`) VALUES
(10, 'Tema1', '<p class=\"MsoNoSpacing\" style=\"text-align: justify;\">&nbsp;<span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">&nbsp; &nbsp;Colocar aqu&iacute;. . . .&nbsp;</span></p>\r\n<p class=\"MsoNoSpacing\" style=\"text-align: justify;\"><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;INTRODUCCI&Oacute;N</span></p>\r\n<p class=\"MsoNoSpacing\" style=\"text-align: justify;\"><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;OBJETIVOS</span></p>\r\n<p class=\"MsoNoSpacing\" style=\"text-align: justify;\"><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;METAS</span></p>', '', 1, 2, '<h1 style=\"text-align: center;\"><strong><span style=\"font-size: 12pt; font-family: arial, helvetica, sans-serif;\">Botones de contenido</span></strong></h1>\r\n<p style=\"text-align: center;\"><img src=\"imagenes/ayuda4a.jpg\" alt=\"\" width=\"737\" height=\"493\" /></p>', 1, 'hola', 'https://youtu.be/onbC6N-QGPc', 'beta', 'Story of My Life - 16 second clip.mp3', '', ''),
(11, 'Tema 2', '<p>INTRODUCCION</p>\r\n<p>OBJETIVOS</p>\r\n<p>METAS</p>\r\n<p>ESTRATEGIAS</p>', '', 1, 2, '<p style=\"text-align: center;\"><strong>Botones de contenido</strong></p>\r\n<p style=\"text-align: center;\"><strong><img src=\"imagenes/ayuda4a.jpg\" alt=\"\" width=\"737\" height=\"493\" /></strong></p>', 2, 'Adios', 'https://youtu.be/g7ne3ERhJVk', '', '', '', ''),
(17, 'Tema 3', '', '', 1, 3, '', 1, '', '', '', '', '', ''),
(18, 'Tema 4', '', '', 1, 4, '', 1, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovatemascontenidos`
--

CREATE TABLE `ovatemascontenidos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `contenido` longtext NOT NULL,
  `orden` smallint(11) NOT NULL,
  `id_tema` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ovatemascontenidos`
--

INSERT INTO `ovatemascontenidos` (`id`, `titulo`, `contenido`, `orden`, `id_tema`, `status`) VALUES
(2, 'Definición', '<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p>DEFINICIONES Y CONTENIDOS</p>\r\n<p>IMAGEN</p>\r\n<p>ANIMACIONES / GIF</p>\r\n<p><br /><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"imagenes/image_8039.jpg\" alt=\"\" width=\"414\" height=\"234\" /></p>\r\n<p style=\"text-align: center;\">&nbsp;</p>', 1, 10, 1),
(16, 'CONCEPTO', '<p style=\"text-align: justify;\"><span style=\"font-size: 12pt; font-family: arial, helvetica, sans-serif;\"><span lang=\"es-419\">&nbsp; &nbsp;</span><span lang=\"es-419\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"imagenes/pm9.gif\" alt=\"\" width=\"296\" height=\"330\" /></span></span></p>\r\n<p style=\"text-align: center;\"><span style=\"font-size: 10pt;\"><strong><span style=\"font-family: arial, helvetica, sans-serif;\"><span lang=\"es-419\">Paraboloide</span></span></strong></span></p>\r\n<p class=\"MsoNoSpacing\" style=\"text-align: justify;\">&nbsp;</p>', 1, 11, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovatiposactividades`
--

CREATE TABLE `ovatiposactividades` (
  `id` smallint(6) NOT NULL,
  `tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ovatiposactividades`
--

INSERT INTO `ovatiposactividades` (`id`, `tipo`) VALUES
(1, 'Selección simple'),
(2, 'Verdadero y falso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovatipousuario`
--

CREATE TABLE `ovatipousuario` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ovatipousuario`
--

INSERT INTO `ovatipousuario` (`id`, `tipo`) VALUES
(1, 'Administrador'),
(2, 'Docente'),
(3, 'Estudiante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ovausuarios`
--

CREATE TABLE `ovausuarios` (
  `id` int(11) NOT NULL,
  `nick` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `cedula` varchar(12) NOT NULL,
  `email` varchar(80) NOT NULL,
  `profesion` varchar(80) NOT NULL,
  `carrera` varchar(80) NOT NULL,
  `semestre` varchar(15) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `last_session` datetime DEFAULT NULL,
  `token` varchar(40) NOT NULL,
  `token_password` varchar(100) DEFAULT NULL,
  `password_request` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ovausuarios`
--

INSERT INTO `ovausuarios` (`id`, `nick`, `password`, `nombres`, `apellidos`, `cedula`, `email`, `profesion`, `carrera`, `semestre`, `id_tipo`, `status`, `last_session`, `token`, `token_password`, `password_request`) VALUES
(1, 'admin', '$2y$10$a3jCv4LpwFgYchMQ2i9/Ke9WFVq68NEMEANs19YIBbSzL45dllwcq', 'Administrador', 'Principal', '00000000', 'admin@admin.ova', 'Administrador', '', '', 1, 1, '2017-09-25 16:39:49', '26ce79cf48da171868d3ef569db24fab', '', 1),
(17, 'Administrador', '$2y$10$rM5EFNOGXPyadV00OXX8DeLqK5iiYL1iid/1347RU5KBkHW2TQNVe', 'Usuario', 'admin', '12345678', 'usuario1@gmail.com', 'Diseñador', '', '', 1, 1, '2018-07-11 20:50:38', 'ed2aedb67a3b7d7ba6c5ffbcfb91fce0', '', 1),
(32, 'usuario1', '$2y$10$cNtZ9ns6bABeEhaEJ2m0sux2ul0S4HikayZLEDF/1Toknlb2VtvSy', 'usuario1', 'person', '12378945', 'usuario2@gmail.com', 'Biología', '', '', 2, 1, NULL, 'ca447f769d7ce453d214bb1d4b4dde66', NULL, 0),
(33, 'usuario2', '$2y$10$/GF8cys2n5EDX.FoeMYfyedQ.YF4y9yevLY5C6O9/zwQyRHtHBnsq', 'usuario2', 'person', '78945612', 'usuario3@gmail.com', '', 'biología', '2', 3, 1, NULL, '74da4ed10e2880dd3fc81ade39637c65', NULL, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ovaarchivos`
--
ALTER TABLE `ovaarchivos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `ovaareasc`
--
ALTER TABLE `ovaareasc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `titulo` (`titulo`);

--
-- Indices de la tabla `ovaasignatura`
--
ALTER TABLE `ovaasignatura`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ovabibliografia`
--
ALTER TABLE `ovabibliografia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ovadiseno`
--
ALTER TABLE `ovadiseno`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `ovaenlaces`
--
ALTER TABLE `ovaenlaces`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Indices de la tabla `ovaglosario`
--
ALTER TABLE `ovaglosario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `termino` (`termino`);

--
-- Indices de la tabla `ovaimagenes`
--
ALTER TABLE `ovaimagenes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `ovapuntaje`
--
ALTER TABLE `ovapuntaje`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ovaseleccion`
--
ALTER TABLE `ovaseleccion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ovatemas`
--
ALTER TABLE `ovatemas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`),
  ADD KEY `id_3` (`id`);

--
-- Indices de la tabla `ovatemascontenidos`
--
ALTER TABLE `ovatemascontenidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ovatiposactividades`
--
ALTER TABLE `ovatiposactividades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ovatipousuario`
--
ALTER TABLE `ovatipousuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tipo` (`tipo`);

--
-- Indices de la tabla `ovausuarios`
--
ALTER TABLE `ovausuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nick` (`nick`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ovaarchivos`
--
ALTER TABLE `ovaarchivos`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `ovaareasc`
--
ALTER TABLE `ovaareasc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `ovabibliografia`
--
ALTER TABLE `ovabibliografia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `ovaenlaces`
--
ALTER TABLE `ovaenlaces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `ovaglosario`
--
ALTER TABLE `ovaglosario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `ovaimagenes`
--
ALTER TABLE `ovaimagenes`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ovapuntaje`
--
ALTER TABLE `ovapuntaje`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `ovaseleccion`
--
ALTER TABLE `ovaseleccion`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT de la tabla `ovatemas`
--
ALTER TABLE `ovatemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `ovatemascontenidos`
--
ALTER TABLE `ovatemascontenidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT de la tabla `ovatiposactividades`
--
ALTER TABLE `ovatiposactividades`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `ovatipousuario`
--
ALTER TABLE `ovatipousuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `ovausuarios`
--
ALTER TABLE `ovausuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;