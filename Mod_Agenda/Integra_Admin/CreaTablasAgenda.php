<?php

	global $db;	
	global $db_host;
	global $db_user;
	global $db_pass;
	global $db_name;
	global $dbconecterror;
	
	/************** CREAMOS LA TABLA EVENTOS ***************/

	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."eventos`";

  $eventos = "CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_a  (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci,
  `inicio` datetime DEFAULT NULL,
  `fin` datetime DEFAULT NULL,
  `colortexto` varchar(7) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `colorfondo` varchar(7) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish2_ci";

    if(mysqli_query($db , $eventos)){
      global $ta1;
      $ta1 = "\t* OK TABLA EVENTOS.".PHP_EOL;
    } else {
      global $ta1;
      $ta1 = "\t* L.15 NO OK TABLA EVENTOS. ".mysqli_error($db).PHP_EOL;
    }

	/************** CREAMOS LA TABLA EVENTOS PREDEFINIDOS ***************/

  global $table_name_b;
	$table_name_b = "`".$_SESSION['clave']."eventospredefinidos`";

$eventosPre ="CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_b (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `horainicio` time DEFAULT NULL,
  `horafin` time DEFAULT NULL,
  `colortexto` varchar(7) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `colorfondo` varchar(7) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish2_ci";

  if(mysqli_query($db , $eventosPre)){
    global $ep;
    $ep = "INSERT INTO `$db_name`.$table_name_b (`id`, `titulo`, `horainicio`, `horafin`, `colortexto`, `colorfondo`) VALUES (1, 'S.Prin. Manhana', '09:30:00', '16:30:00', '#000', '#33FFE3'), 
    (2, 'S.Prin. Noche', '19:30:00', '22:00:00', '#000', '#049a86'), 
    (3, 'S.Prin. Dia', '09:30:00', '22:00:00', '#FFF', '#105f55'), 
    (4, 'S.Sec. Manhana', '09:30:00', '16:30:00', '#000', '#cd8bfe'), 
    (5, 'S.Sec. Noche', '19:30:00', '22:00:00', '#FFF', '#9042cb'), 
    (6, 'S.Sec. Dia', '09:30:00', '22:00:00', '#FFF', '#4f2f68'), 
    (7, 'M.01. Manhana', '09:30:00', '16:30:00', '#000', '#d99238'), 
    (8, 'M.01. Noche', '19:30:00', '22:00:00', '#FFF', '#91662f'), 
    (9, 'M.02. Manhana', '09:30:00', '16:30:00', '#000', '#d99238'), 
    (10, 'M.02. Noche', '19:30:00', '22:00:00', '#FFF', '#91662f'), 
    (11, 'M.03. Manhana', '09:30:00', '16:30:00', '#000', '#d99238'), 
    (12, 'M.03. Noche', '19:30:00', '22:00:00', '#FFF', '#91662f'), 
    (13, 'M.04. Manhana', '09:30:00', '16:30:00', '#000', '#d99238'), 
    (14, 'M.04. Noche', '19:30:00', '22:00:00', '#FFF', '#91662f'), 
    (15, 'M.05. Manhana', '09:30:00', '16:30:00', '#000', '#d99238'), 
    (16, 'M.05. Noche', '19:30:00', '22:00:00', '#FFF', '#91662f'), 
    (17, 'M.06. Manhana', '09:30:00', '16:30:00', '#000', '#d99238'), 
    (18, 'M.06. Noche', '19:30:00', '22:00:00', '#FFF', '#91662f'), 
    (19, 'M.07. Manhana', '09:30:00', '16:30:00', '#000', '#d99238'), 
    (20, 'M.07. Noche', '19:30:00', '22:00:00', '#FFF', '#91662f'), 
    (21, 'M.08. Manhana', '09:30:00', '16:30:00', '#000', '#d99238'), 
    (22, 'M.08. Noche', '19:30:00', '22:00:00', '#FFF', '#91662f'), 
    (23, 'M.09. Manhana', '09:30:00', '16:30:00', '#000', '#d99238'), 
    (24, 'M.09. Noche', '19:30:00', '22:00:00', '#FFF', '#91662f'), 
    (25, 'M.10. Manhana', '09:30:00', '16:30:00', '#000', '#d99238'), 
    (26, 'M.10. Noche', '19:30:00', '22:00:00', '#FFF', '#91662f'), 
    (27, 'M.11. Manhana', '09:30:00', '16:30:00', '#000', '#d99238'), 
    (28, 'M.11. Noche', '19:30:00', '22:00:00', '#FFF', '#91662f'), 
    (29, 'M.12. Manhana', '09:30:00', '16:30:00', '#000', '#d99238'), 
    (30, 'M.12. Noche', '19:30:00', '22:00:00', '#FFF', '#91662f'),
    (31, 'Cerrado', '09:30:00', '22:00:00', '#000', '#ff0000')";

        if(mysqli_query($db, $ep)){
                  global $ta1b;
                  $ta1b = "\t* OK INIT VALUES EN EVENTOS PREDEFINIDOS.".PHP_EOL;
        } else { global $ta1b;
                  $ta1b = "\t* L.51 NO OK INIT VALUES EN EVENTOS PREDEFINIDOS. ".mysqli_error($db).PHP_EOL;
                  }
  
      global $ta2;
      $ta2 = "\t* OK TABLA EVENTOS PREDEFINIDOS.".PHP_EOL;
  } else {
    global $ta2;
    $ta2 = "\t* L.39 NO OK TABLA EVENTOS PREDEFINIDOS. ".mysqli_error($db).PHP_EOL;
  }

	/************	PASAMOS LOS PARAMETROS A .LOG	*****************/

  global $tablasAgendaLog;
  $tablasAgendaLog = $ta1.$ta1b.$ta2;

?>