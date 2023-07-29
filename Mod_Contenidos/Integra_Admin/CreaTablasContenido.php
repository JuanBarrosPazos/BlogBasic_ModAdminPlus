<?php
 
	/************** CREAMOS LA TABLA ARTICULOS ***************/ 

	global $articulos; 		$articulos = "`".$_SESSION['clave'].date('Y')."articulos`";
	
	$tblArticulos = "CREATE TABLE IF NOT EXISTS `$db_name`.$articulos (
  `id` int(6) NOT NULL auto_increment,
  `refuser` varchar(22) collate utf8_spanish2_ci NOT NULL,
  `refart` varchar(22) collate utf8_spanish2_ci NOT NULL,
  `tit` varchar(22) collate utf8_spanish2_ci NOT NULL,
  `titsub` varchar(22) collate utf8_spanish2_ci NOT NULL,
  `datein` varchar(20) collate utf8_spanish2_ci NOT NULL default '0',
  `timein` varchar(20) collate utf8_spanish2_ci NOT NULL default '0',
  `datemod` varchar(20) collate utf8_spanish2_ci NOT NULL default '0',
  `timemod` varchar(20) collate utf8_spanish2_ci NOT NULL default '0',
  `conte` text(402) collate utf8_spanish2_ci NOT NULL,
  `myimg` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
  `myvdo` varchar(30) collate utf8_spanish2_ci DEFAULT NULL,
  `myurl` varchar(50) collate utf8_spanish2_ci DEFAULT NULL,
  `visible` varchar(1) collate utf8_spanish2_ci NOT NULL default 'n',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `refart` (`refart`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ";
		
	if(mysqli_query($db, $tblArticulos)){

		global $tblArtic; 	$tblArtic = "\t* OK TABLA ".$articulos."\n";

		global $dateinRef;	$dateinRef = date('Y.m.d'); 
		$dateinRef1 = $dateinRef.".01.01.01";		$dateinRef1i = $dateinRef.".01.01.01.png";
		$dateinRef2 = $dateinRef.".02.02.02";		$dateinRef2i = $dateinRef.".02.02.02.png";
		$dateinRef3 = $dateinRef.".03.03.03";		$dateinRef3i = $dateinRef.".03.03.03.png";
		$dateinRef4 = $dateinRef.".04.04.04";		$dateinRef4i = $dateinRef.".04.04.04.png";

		global $datein; 	$datein = date('Y-m-d');
		global $timein;		$timein = date('H:i:s');
		global $insertArt;
		$insertArt = "INSERT INTO `$db_name`.$articulos (`id`, `refuser`, `refart`, `tit`, `titsub`, `datein`, `timein`, `datemod`, `timemod`, `conte`, `myimg`, `myvdo`, `myurl`, `visible`) VALUES
		(1, 'anonimo', '$dateinRef1', 'INSTALACION CORRECTA', 'BIENVENIDO', '$datein', '$timein', '0000-00-00', '00:00:00', 'Hola has completado la instalación de la versi&oacute;n V90 del blog basic, creado por Juan Manuel Barr&oacute;s Pazos. Disfrutala', '$dateinRef1i', '', '', 'y'),
		(2, 'anonimo', '$dateinRef2', 'A CORUÑA RIAZOR', 'A CORUÑA RIAZOR', '$datein', '$timein', '0000-00-00', '00:00:00', 'La playa de Riazor es una playa urbana de la ciudad de La Coru&ntilde;a, situada en la Ensenada del Orz&aacute;n. Cuenta con la Bandera Azul, distinci&oacute;n otorgada a las playas con las mejores condiciones ambientales e instalaciones. Su continuaci&oacute;n hacia el noreste es la playa del Orzán. Está en frente del hotel Riazor.', '$dateinRef2i', '', '', 'y'),
		(3, 'anonimo', '$dateinRef3', 'A CORUÑA ORZAN', 'A CORUÑA ORZAN', '$datein', '$timein', '0000-00-00', '00:00:00', 'La playa del Orz&aacute;n es una playa urbana de la ciudad de La Coru&ntilde;a, situada en la Ensenada del Orz&aacute;n. Tiene la Bandera Azul, distinci&oacute;n otorgada a las playas con las mejores condiciones ambientales e instalaciones. Su continuaci&oacute;n hacia el suroeste es la playa de Riazor.', '$dateinRef3i', '', '', 'y'),
		(4, 'anonimo', '$dateinRef4', 'CORUÑA TORRE HERCULES', 'TORRE HERCULES', '$datein', '$timein', '0000-00-00', '00:00:00', 'La Torre de H&eacute;rcules es una torre y faro situado sobre una colina en la península de la ciudad de La Coru&ntilde;a, en Galicia. Su altura total es de 55 metros, data de finales del siglo I y principios del siglo II Tiene el privilegio de ser el &uacute;nico faro romano y el m&aacute;s antiguo en funcionamiento del mundo.', '$dateinRef4i', '', '', 'y')";

		if(mysqli_query($db, $insertArt)){
			$tblArtic = $tblArtic."\t* OK INSERT DATOS EN ".$articulos."\n";

		/* CREO LAS IMAGENES PARA LAS ENTRADAS AUTOMÁTICAS DE LA INSTALACIÓN */
			global $imgname1;
		if(file_exists('../Mod_Contenidos/Img.Sys/defaultInstallD.png')){
			$imgname1 = "../Mod_Contenidos/Img.Art/".$dateinRef1i;
			copy("../Mod_Contenidos/Img.Sys/defaultInstallD.png", "$imgname1");
			$tblArtic = $tblArtic.PHP_EOL."\tCOPY ".$imgname1;
		} else { 
			print("DON'T COPY ".$imgname1."</br>");
			$tblArtic = $tblArtic.PHP_EOL."\tDON'T CCOPY ".$imgname1;}

			global $imgname2;
		if(file_exists('../Mod_Contenidos/Img.Sys/defaultInstallC.png')){
			 $imgname2 = "../Mod_Contenidos/Img.Art/".$dateinRef2i;
			copy("../Mod_Contenidos/Img.Sys/defaultInstallC.png", "$imgname2");
			$tblArtic = $tblArtic.PHP_EOL."\tCOPY ".$imgname2;
		} else { 
			print("DON'T COPY ".$imgname2."</br>");
			$tblArtic = $tblArtic.PHP_EOL."\tDON'T CCOPY ".$imgname2;}

			global $imgname3;
		if(file_exists('../Mod_Contenidos/Img.Sys/defaultInstallB.png')){
			 $imgname3 = "../Mod_Contenidos/Img.Art/".$dateinRef3i;
			copy("../Mod_Contenidos/Img.Sys/defaultInstallB.png", "$imgname3");
			$tblArtic = $tblArtic.PHP_EOL."\tCOPY ".$imgname3;
		} else { 
			print("DON'T COPY ".$imgname3."</br>");
			$tblArtic = $tblArtic.PHP_EOL."\tDON'T CCOPY ".$imgname3;}

			global $imgname4;
		if(file_exists('../Mod_Contenidos/Img.Sys/defaultInstallA.png')){
			$imgname4 = "../Mod_Contenidos/Img.Art/".$dateinRef4i;
			copy("../Mod_Contenidos/Img.Sys/defaultInstallA.png", "$imgname4");
			$tblArtic = $tblArtic.PHP_EOL."\tCOPY ".$imgname4;
		} else { 
			print("DON'T COPY ".$imgname4."</br>");
			$tblArtic = $tblArtic.PHP_EOL."\tDON'T CCOPY ".$imgname4;}

		}else{ 
			$tblArtic = $tblArtic.PHP_EOL."\t* NO OK INSERT DATOS EN ".$articulos."\n";
			echo "*** ".mysqli_error($db)."<br>";
		}

	} else {
			print( "* NO OK TABLA ".$articulos.". ".mysqli_error($db)."\n");
			$tblArtic = PHP_EOL."\t* NO OK TABLA ".$articulos.". ".mysqli_error($db)."\n";
		}

	/************** CREAMOS LA TABLA ARTICULOS AÑO PASADO **************
	
	global $dy;
	$dy = date('Y')-1;
	$articulos2 = "gcb_".$dy."articulos";
	$articulos2 = "`".$articulos2."`";
	
	$tg2 = "CREATE TABLE IF NOT EXISTS `$db_name`.$articulos2 (
  `id` int(6) NOT NULL auto_increment,
  `refuser` varchar(22) collate utf8_spanish2_ci NOT NULL,
  `refart` varchar(22) collate utf8_spanish2_ci NOT NULL,
  `tit` varchar(22) collate utf8_spanish2_ci NOT NULL,
  `titsub` varchar(22) collate utf8_spanish2_ci NOT NULL,
  `datein` varchar(20) collate utf8_spanish2_ci NOT NULL default '0',
  `timein` varchar(20) collate utf8_spanish2_ci NOT NULL default '0',
  `datemod` varchar(20) collate utf8_spanish2_ci NOT NULL default '0',
  `timemod` varchar(20) collate utf8_spanish2_ci NOT NULL default '0',
  `conte` text(402) collate utf8_spanish2_ci NOT NULL,
  `myimg` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
  `myvdo` varchar(30) collate utf8_spanish2_ci DEFAULT NULL,
  `myurl` varchar(50) collate utf8_spanish2_ci DEFAULT NULL,
  `visible` varchar(1) collate utf8_spanish2_ci NOT NULL default 'n',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `refart` (`refart`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ";
		
	if(mysqli_query($db, $tg2)){
					global $tblArticb;
					$tblArticb = "\t* OK TABLA ".$articulos2."\n";
				} else {
					print( "* NO OK TABLA ".$articulos2.". ".mysqli_error($db)."\n");
					global $tblArticb;
					$tblArticb = "\t* NO OK TABLA ".$articulos2.". ".mysqli_error($db)."\n";
				}
*/


	/************	CREAMOS EL USUARIO ANONIMO EN LA TABLA ADMIN	*****************/

	global $db; global $db_name; 
	global $table_name_a; 	$table_name_a = "`".$_SESSION['clave']."admin`";
	global $dateini; 		$dateini = date('Y-m-d H:i:s');
	global $ad;
	$ad = "INSERT INTO `$db_name`.$table_name_a (`id`,`ref`,`Nivel`,`Nombre`,`Apellidos`,`myimg`,`doc`,`dni`,`ldni`,`Email`,`Usuario`,`Password`,`Pass`,`Direccion`,`Tlf1`,`Tlf2`,`lastin`,`lastout`,`visitadmin`) VALUES (1, 'anonimo', 'close', 'Anonimo', 'Anonimo', 'untitled.png', 'anonimo', 'anonimo', 'a', 'anonimo', 'anonimo', 'anonimo', 'anonimo', 'anonimo', '100000001', '200000002', '$dateini', '$dateini', '0')";

	if(mysqli_query($db, $ad)){
			$table1 = $table1."\t* OK INIT VALUES EN VISITAS ADMIN.".PHP_EOL;
			//echo "OK INIT VALUES EN VISITAS ADMIN.<br>";

			global $trf;		$trf = "anonimo";
			global $carpeta; 	$carpeta = "Users/".$trf;

			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0777, true);
				$data1 = "\t* OK DIRECTORIO USUARIO ".$carpeta."\n";
				}
			else{
				//print("* NO OK DIRECTORIO ".$carpeta."\n");
				$data1 = "\t* NO OK DIRECTORIO USUARIO ".$carpeta."\n";
				}

			if (file_exists($carpeta)) {
				copy("Images/untitled.png", $carpeta."/untitled.png");
				copy("Images/pdf.png", $carpeta."/pdf.png");
				copy("config/ayear_Init_System.php", $carpeta."/ayear.php");
				copy("config/year.txt", $carpeta."/year.txt");
				copy("config/SecureIndex2.php", $carpeta."/index.php");
				global $data1;
				$data1 = $data1."\t* OK USER SYSTEM FILES ".$carpeta."\n";
				yx();
				modifx();
				}
			else{
				print("* NO OK USER SYSTEM FILES ".$carpeta."\n");
				global $data1;
				$data1 = $data1."\t* NO OK USER SYSTEM FILES".$carpeta."\n";
				}

	/************** CREAMOS LA TABLA CONTROL USUARIO ***************/

			$vname1 = "`".$_SESSION['clave'].$trf."_".date('Y')."`";
				
				$tcl = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname1 (
			`id` int(4) NOT NULL auto_increment,
			`ref` varchar(20) collate utf8_spanish2_ci NOT NULL,
			`Nombre` varchar(25) collate utf8_spanish2_ci NOT NULL,
			`Apellidos` varchar(25) collate utf8_spanish2_ci NOT NULL,
			`din` varchar(10) collate utf8_spanish2_ci NOT NULL,
			`tin` time NOT NULL,
			`dout` varchar(10) collate utf8_spanish2_ci NULL,
			`tout` time NULL,
			`ttot` time NULL,
			UNIQUE KEY `id` (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ";
					
			if(mysqli_query($db , $tcl)){
				global $data5; 		$data5 = "\t* OK TABLA FICHAR ".$vname1.".\n";
			} else {
				global $data5; 		$data5 = "\t* NO OK TABLA FICHAR. ".mysqli_error($db)." \n";
				}

	/************** CREAMOS LA TABLA FEEDBACK CONTROL USUARIO ***************/

			$vname2 = "`".$_SESSION['clave'].$trf."_feed`";
				
				$tcl = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname2 (
			`id` int(4) NOT NULL auto_increment,
			`ref` varchar(20) collate utf8_spanish2_ci NOT NULL,
			`Nombre` varchar(25) collate utf8_spanish2_ci NOT NULL,
			`Apellidos` varchar(25) collate utf8_spanish2_ci NOT NULL,
			`din` varchar(10) collate utf8_spanish2_ci NOT NULL,
			`tin` time NOT NULL,
			`dout` varchar(10) collate utf8_spanish2_ci NULL,
			`tout` time NULL,
			`ttot` time NULL,
			`dfeed` varchar(10) collate utf8_spanish2_ci NULL,
			`tfeed` time NULL,
			UNIQUE KEY `id` (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ";
					
			if(mysqli_query($db , $tcl)){
				global $data6; 		$data6 = "\t* OK TABLA FEED FICHAR ".$vname1.".\n";
			} else {
				global $data6; 		$data6 = "\t* NO OK TABLA FEED FICHAR. ".mysqli_error($db)." \n";
			}

		// CREA EL DIRECTORIO DE IMAGEN DE USUARIO.

			$vn1 = "img_admin";
			$carpetaimg = "Users/".$trf."/".$vn1;
			if (!file_exists($carpetaimg)) {
				mkdir($carpetaimg, 0777, true);
				copy("Images/untitled.png", $carpetaimg."/untitled.png");
				$data2 = "\t* OK DIRECTORIO ".$carpetaimg." \n";
				}
			else{print("* NO OK DIRECTORIO ".$carpetaimg."\n");
				$data2 = "\t* NO OK DIRECTORIO ".$carpetaimg."\n";
				}

			// CREA EL DIRECTORIO DE LOG DE USUARIO.

			$vn1 = "log";
			$carpetalog = "Users/".$trf."/".$vn1;
			if (!file_exists($carpetalog)) {
				mkdir($carpetalog, 0777, true);
				$data3 = "\t* OK DIRECTORIO ".$carpetalog."\n";
				}
			else{print("* NO OK EL DIRECTORIO ".$carpetalog."\n");
				$data3 = "\t* NO OK DIRECTORIO ".$carpetalog."\n";
				}

			// CREA EL DIRECTORIO RESUMEN FICHAR MES.

			$vn1 = "mrficha";
			$carpetamrf = "Users/".$trf."/".$vn1;
			if (!file_exists($carpetamrf)) {
				mkdir($carpetamrf, 0777, true);
				$data4 = "\t* OK DIRECTORIO ".$carpetamrf."\n";
				}
			else{print("* NO OK DIRECTORIO ".$carpetamrf."\n");
				$data4= "\t* NO OK DIRECTORIO ".$carpetamrf."\n";
				}

		/************	PASAMOS LOS PARAMETROS A .LOG	*****************/

		$datein = date('Y-m-d/H:i:s');

		global $text;
		$text = PHP_EOL."- USUARIO ANONIMO: CREADAS BBDD TABLAS Y DIRECTORIOS. ".$datein.PHP_EOL." ".$data1.$data2.$data3.$data4.$data5.$data6.PHP_EOL;

		ini_log();


	} else { 
			$table1 = $table1."\t* NO OK INIT VALUES EN ".$table_name_a." ".mysqli_error($db).PHP_EOL;
			//echo "NO OK INIT VALUES EN ".$table_name_a." ".mysqli_error($db)."<br>";
			} // FIN NO SE CUMPLE EL QUERY INSERT

	/************	FUNCIONES DEPENDIENTES PARA CREAR USUARIO ANONIMO	*****************/

		function yx(){
			global $trf; 	$trf = "anonimo";
			$carpeta = "Users/".$trf;
			$filename = $carpeta."/ayear.php";
			$fw1 = fopen($filename, 'r+');
			$contenido = fread($fw1,filesize($filename));
			fclose($fw1);
			$contenido = explode("\n",$contenido);
			$contenido[2] = "'' => 'YEAR',\n'".date('y')."' => '".date('Y')."',";
			$contenido = implode("\n",$contenido);
			//fseek($fw, 37);
			$fw = fopen($filename, 'w+');
			fwrite($fw, $contenido);
			fclose($fw);
		}

		function modifx(){
			$filename = "Users/anonimo/year.txt";
			$fw2 = fopen($filename, 'w+');
			$date = "".date('Y')."";
			fwrite($fw2, $date);
			fclose($fw2);
		}

	/************	FIN FUNCIONES DEPENDIENTES PARA CREAR USUARIO ANONIMO	*****************/


    /* Creado por Juan Manuel Barros Pazos 2020/21 */

?>