<?php

	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../Inclu/Admin_Inclu_Head_b.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if(isset($_POST['limpia'])){
						deltables();
						deldir();
						//deltablesb();
						rewrite();
						config_one();
						//inittot();
			 			show_form();
	}

	elseif(isset($_POST['config'])){$_SESSION['inst'] = "noinst";						
	if($form_errors = validate_form()){show_form($form_errors);} 
	else {	process_form();
			require '../../Mod_Admin_Plus/Conections/conection.php';
			$db = @mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	
			if (!$db){ 	global $dbconecterror;
						$dbconecterror = $db_name." * ".mysqli_connect_error().PHP_EOL;
						print ("NO CONECTA A BBDD ".$db_name."</br>".mysqli_connect_error());
						show_form();
							} elseif($db) { config_one();
									 		crear_tablas();
											ayear();
											global $tablepf;
											print($tablepf);
											}
							}
							
	} else { inittot();
			 show_form();}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function inittot(){
	@include '../../Mod_Admin_Plus/Conections/conection.php';
	$db = @mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	if (!$db){ //print ("Es imposible conectar con la bbdd ".$db_name."</br>".mysqli_connect_error());
				$_SESSION['inst'] = "noinst";
				global $inst;
				$inst = '';
	}else{
	global $inst;
	$inst = 1;
	global $sqltadm;
	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";
	$sqltadm = "SELECT * FROM `$db_name`.$tablename ";
	if(($inst == 1)&&(@mysqli_num_rows(mysqli_query($db, $sqltadm)) < 1)){
		$_SESSION['inst'] = "inst";
		global $link;
		$link = "<tr>
					<th align='center' class='BorderInf'>
						<font color='#FF0000'>
							EXISTE UNA INSTALACION INCOMPLETA
						</font>
					</th>
				</tr>
				<tr>
					<th align='center'>
						CONTINUAR CON ESTA INSTALACIÓN
					</th>
				</tr>
				<tr>
					<td align='center' class='BorderInf'>
						<a href='config2.php'>
							CREE EL USUARIO ADMINISTRADOR
			 			</a>
							</br></br>
					</td>
				</tr>
				<tr>
					<th align='center'>
						INICIAR UNA INSTALACIÓN LIMPIA
					</th>
				</tr>
				<tr>
			<form name='limpia' action='$_SERVER[PHP_SELF]' method='post' >
				<td  align='center'>
					<input type='submit' value='ELIMINE TODOS LOS DATOS DEL SISTEMA' class='botonrojo' />
					<input type='hidden' name='limpia' value=1 />
					</br></br>
				</td>
			</fomr>
				</tr>";
}elseif(($inst == 1)&&(@mysqli_num_rows(mysqli_query($db, $sqltadm)) >= 1)){
			$_SESSION['inst'] = "inst";
			global $link;
			$link = "<tr>
						<th align='center' class='BorderInf'>
							<font color='#FF0000'>
								EXISTE UNA INSTALACION ANTERIOR
							</font>
						</th>
					</tr>
					<tr>
						<th align='center'>
							MANTENER TABLAS Y DIRECTORIOS
						</th>
					</tr>
					<tr>
				<form name='inscancel' action='config2.php' method='post' >
					<td align='center' class='BorderInf'>
						<input type='submit' value='CONTINUE CON LA CONFIGURACIÓN ACTUAL' class='botonverde' />
						<input type='hidden' name='inscancel' value=1 />
						</br></br>
					</td>
				</form>
					</tr>
					<tr>
						<th align='center'>
							INICIAR UNA INSTALACIÓN LIMPIA
						</th>
					</tr>
					<tr>
				<form name='limpia' action='$_SERVER[PHP_SELF]' method='post' >
					<td  align='center'>
						<input type='submit' value='ELIMINE TODOS LOS DATOS DEL SISTEMA' class='botonrojo' />
						<input type='hidden' name='limpia' value=1 />
						</br></br>
					</td>
				</fomr>
					</tr>";
	}else{ 	$_SESSION['inst'] = "noinst";
			global $link;
		   	$link = "<tr>
		   				<td>
							<a href='config2.php'>
		   						CREE EL USUARIO ADMINISTRADOR
							</a>
						</td>
					</tr>";
				} // NO HAY DATOS EN LA BBDD
			} // CONDICIONAL SI CONECTO A LA BBDD
}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function config_one(){

	unset($_SESSION['showf']);

	$_SESSION['inst'] = "noinst";

	if(file_exists('year.txt')){unlink("year.txt");
					$data1 = PHP_EOL."\tUNLINK year.txt";}
			else {print("DON`T UNLINK year.txt </br>");
					$data1 = PHP_EOL."\tDON'T UNLINK year.txt";}

	if(file_exists('ayear.php')){unlink("ayear.php");
					$data2 = PHP_EOL."\tUNLINK ayear.php";}
			else {print("DON'T UNLINK ayear.php </br>");
					$data2 = PHP_EOL."\tDON'T UNLINK ayear.php";}

	if(!file_exists('year.txt')){
			if(file_exists('year_Init_System.txt')){
				copy("year_Init_System.txt", "year.txt");
				$data3 = PHP_EOL."\tRENAME year_Init_System.txt TO year.txt";
			} else {print("DON'T RENAME year_Init_System.txt TO year.txt </br>");
				$data3 = PHP_EOL."\tDON'T RENAME year_Init_System.txt TO year.txt";}
			}

	if(!file_exists('ayear.php')){
			if(file_exists('ayear_Init_System.php')){
				copy("ayear_Init_System.php", "ayear.php");
				$data4 = PHP_EOL."\tRENAME ayear_Init_System.php TO ayear.php";
			} else {print("DON'T RENAME ayear_Init_System.php TO ayear.php </br>");
				$data4 = PHP_EOL."\tDON'T RENAME ayear_Init_System.php TO ayear.php";}
			}

	if(!file_exists('../Img.Art/untitled.png')){
			if(file_exists('../Img.Sys/untitled.png')){
				copy("../Img.Sys/untitled.png", "../Img.Art/untitled.png");
				$data5 = PHP_EOL."\tCOPY ../Img.Art/untitled.png";
			} else {print("DON'T COPY ../Img.Art/untitled.png </br>");
				$data5 = PHP_EOL."\tDON'T CCOPY ../Img.Art/untitled.png";}
			}
			
	if(!file_exists('../Img.User/untitled.png')){
			if(file_exists('../Img.Sys/untitled.png')){
				copy("../Img.Sys/untitled.png", "../Img.User/untitled.png");
				$data6 = PHP_EOL."\tCOPY ../Img.User/untitled.png";
			} else {print("DON'T COPY ../Img.User/untitled.png </br>");
				$data6 = PHP_EOL."\tDON'T CCOPY ../Img.User/untitled.png";}
			}

	if(!file_exists('../Vdo.Art/untitled.png')){
			if(file_exists('../Img.Sys/untitled.png')){
				copy("../Img.Sys/untitled.png", "../Vdo.Art/untitled.png");
				$data6 = $data6.PHP_EOL."\tCCOPY ../Vdo.Art/untitled.png";
			} else {print("DON'T COPY ../Vdo.Art/untitled.png </br>");
				$data6 = $data6.PHP_EOL."\tDON'T CCOPY ../Vdo.Art/untitled.png";}
			}

	global $cfone;
	$cfone = PHP_EOL."SUSTITUCION DE ARCHIVOS:".isset($data1).isset($data2).isset($data3).isset($data4).isset($data5).isset($data6);

	//modif();
	//modif2();

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function deldir(){

	unlink("../../Mod_Admin_Plus/Conections/conection.php");

	// BORRA CONTENIDO DE LOS DIRECTORIOS DENTRO DEL USUARIO
	$carpeta1 = "../Img.Art";
	if(file_exists($carpeta1)){ $dir1 = $carpeta1."/";
								$handle1 = opendir($dir1);
					while ($file1 = readdir($handle1))
							{if (is_file($dir1.$file1))
									{unlink($dir1.$file1);}
									}
							//rmdir ($carpeta1);
								} else {}
											
	$carpeta2 = "../Img.User";
	if(file_exists($carpeta2)){ $dir2 = $carpeta2."/";
								$handle2 = opendir($dir2);
					while ($file2 = readdir($handle2))
							{if (is_file($dir2.$file2))
									{unlink($dir2.$file2);}
									}
							//rmdir ($carpeta2);
								} else {}

	$carpeta3 = "../Log";
	if(file_exists($carpeta3)){ $dir3 = $carpeta3."/";
								$handle3 = opendir($dir3);
					while ($file3 = readdir($handle3))
							{if (is_file($dir3.$file3))
									{unlink($dir3.$file3);}
									}
							//rmdir ($carpeta3);
								} else {}

	$carpeta4 = "../Vdo.Art";
	if(file_exists($carpeta4)){ $dir4 = $carpeta4."/";
								$handle4 = opendir($dir4);
					while ($file4 = readdir($handle4))
							{if (is_file($dir4.$file4))
									{unlink($dir4.$file4);}
									}
							//rmdir ($carpeta4);
								} else {}

} // FIN FUNCTION

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function deltables(){

	require '../../Mod_Admin_Plus/Conections/conection.php';
	$db = @mysqli_connect($db_host,$db_user,$db_pass,$db_name);

	/*************	BORRAMOS TODAS LAS TABLAS DE ARTICULOS 	***************/

	/* Se busca las tablas en la base de datos */
	/* REFERENCIA DEL USUARIO O $_SESSION['iniref'] = $_POST['ref'] */
	/* $nom PARA LA CLAVE USUARIO ACOMPAÑANDA DE _ O NO */

	global $nom;
	$nom = $_SESSION['clave']."%"; // SOLO COINCIDEN AL PRINCIPIO
	$nom = "LIKE '$nom'";
	//$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME $nom ";
	$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $nom ";
	$respuesta = mysqli_query($db, $consulta);
	//$count = mysqli_num_rows($respuesta);
	//print("* NUMERO TABLAS: ".$count."<br>");
	//print("* CLAVE TABLA USUARIO: ".$nom."<br>");

	//global $fila;
	//$fila = mysqli_fetch_row($respuesta);

if(!$respuesta){
print("<font color='#FF0000'>L.246 Se ha producido un error: </font></br>".mysqli_error($db)."</br>");
	} else { 
		while ($fila = mysqli_fetch_row($respuesta)) {
			if($fila[0]){
		/* PROCEDEMOS A BORRAR LAS TABLAS DEL USUARIO */
			global $sqlt;
			$sqlt = "DROP TABLE `$db_name`.`$fila[0]` ";
			if(mysqli_query($db, $sqlt)){
				} else {
					//print ("<font color='#FF0000'>*** </font></br> ".mysqli_error($db).".</br>");
							} 
		/* HASTA AQUI BORRA TABLAS Y PASA LOS LOG DE BBDD */
					} // FIN IF $FILA[0]
				} // FIN WHILE

		// SE GRABAN LOS DATOS EN LOG DEL ADMIN
	} // FIN ELSE !$respuesta

}

/*
function deltablesb(){

	require '../../Mod_Admin_Plus/Conections/conection.php';
	$db = @mysqli_connect($db_host,$db_user,$db_pass,$db_name);

	************	BORRAMOS LAS TABLAS DEL SISTEMA 	**************

	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";
	global $sqlt1;	$sqlt1 = "DROP TABLE `$db_name`.$tablename ";
	if(mysqli_query($db, $sqlt1)){
		} else {
			print ("<font color='#FF0000'>*** </font></br> ".mysqli_error($db).".</br>");
					}

	global $sqlt2;
	$sqlt2 = "DROP TABLE `$db_name`.`gcb_ipcontrol` ";
	if(mysqli_query($db, $sqlt2)){
		} else {
			print ("<font color='#FF0000'>*** </font></br> ".mysqli_error($db).".</br>");
					}

	global $sqlt3;
	$sqlt3 = "DROP TABLE `$db_name`.`gcb_visitasadmin` ";
	if(mysqli_query($db, $sqlt3)){
		} else {
			print ("<font color='#FF0000'>*** </font></br> ".mysqli_error($db).".</br>");
					}
		
		}
	*/

function rewrite(){

	$bddata = '<?php
	global $db_host;
	global $db_user;
	global $db_pass;
	global $db_name;
	$db_host = ""; 
	$db_user = ""; 
	$db_pass = ""; 
	$db_name = ""; 
	?>';

	$filename = "../../Mod_Admin_Plus/Conections/conection.php";
	$config = fopen($filename, 'w+');
	fwrite($config, $bddata);
	fclose($config);
	global $data5;
	$data5 = PHP_EOL."\tREWRITE ../Mod_Admin_Plus/Conections/conection.php";

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	$errors = array();
	
	if(strlen(@trim($_POST['host'])) == 0){
		$errors [] = "HOST: <font color='#FF0000'> es obligatorio.</font>";
		}
	
	elseif (strlen(@trim($_POST['host'])) < 4){
		$errors [] = "HOST: <font color='#FF0000'>Más de 3 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:"·\(\)=\[\]\{\};,:\*\s]+$/',$_POST['host'])){
		$errors [] = "HOST: <font color='#FF0000'>caracteres no validos.</font>";
		}
		
	elseif (!preg_match('/^[a-z A-Z 0-9 \-!¡?¿\._]+$/',$_POST['host'])){
		$errors [] = "HOST: <font color='#FF0000'>NO VALIDOS</font>";
		}

	
	if(strlen(@trim($_POST['user'])) == 0){
		$errors [] = "USER: <font color='#FF0000'> es obligatorio.</font>";
		}
	
	elseif (strlen(@trim($_POST['user'])) < 4){
		$errors [] = "USER: <font color='#FF0000'>Más de 3 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:"·\(\)=\[\]\{\};,:\*\s]+$/',$_POST['user'])){
		$errors [] = "USER: <font color='#FF0000'>caracteres no validos.</font>";
		}
		
	elseif (!preg_match('/^[a-z A-Z 0-9 !¡?¿\._]+$/',$_POST['user'])){
		$errors [] = "USER: <font color='#FF0000'>NO VALIDOS</font>";
		}

	
	if(strlen(@trim($_POST['pass'])) == 0){
		$errors [] = "PASS: <font color='#FF0000'> es obligatorio.</font>";
		}
	
	elseif (strlen(@trim($_POST['pass'])) < 4){
		$errors [] = "PASS: <font color='#FF0000'>Más de 3 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:"·\(\)=\[\]\{\};,:\*\s]+$/',$_POST['pass'])){
		$errors [] = "PASS: <font color='#FF0000'>caracteres no validos.</font>";
		}
		
	elseif (!preg_match('/^[a-z A-Z 0-9 !¡?¿\._]+$/',$_POST['pass'])){
		$errors [] = "PASS: <font color='#FF0000'>NO VALIDOS</font>";
		}

	
	if(strlen(@trim($_POST['name'])) == 0){
		$errors [] = "NAME: <font color='#FF0000'> es obligatorio.</font>";
		}
	
	elseif (strlen(@trim($_POST['name'])) < 4){
		$errors [] = "NAME: <font color='#FF0000'>Más de 3 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:"·\(\)=\[\]\{\};,:\*\s]+$/',$_POST['name'])){
		$errors [] = "NAME: <font color='#FF0000'>caracteres no validos.</font>";
		}
		
	elseif (!preg_match('/^[a-z A-Z 0-9 !¡?¿\._]+$/',$_POST['name'])){
		$errors [] = "NAME: <font color='#FF0000'>NO VALIDOS</font>";
		}

	return $errors;

		} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	/************** CREAMOS EL ARCHIVO DE CONFIGURACIÓN **************/

	$host = "'".$_POST['host']."'";
	$user = "'".$_POST['user']."'";
	$pass = "'".$_POST['pass']."'";
	$name = "'".$_POST['name']."'";

	$bddata = '<?php
				global $db_host;
				global $db_user;
				global $db_pass;
				global $db_name;
				$db_host = '.$host.'; 
				$db_user = '.$user.'; 
				$db_pass = '.$pass.'; 
				$db_name = '.$name.'; 
				?>';
	
	$filename = "../../Mod_Admin_Plus/Conections/conection.php";
	$config = fopen($filename, 'w+');
	fwrite($config, $bddata);
	fclose($config);
	
	global $tablepf;
	$tablepf = "<table align='center'>
				<tr>
					<td colspan='2'>
							SE HA CREADO EL ARCHIVO DE CONEXIONES.
						</br>
							CON LAS SIGUIENTES VARIABLES.
					</td>
				</tr>

				<tr>
					<td style='text-align:right;'>VARIABLE HOST ADRESS </td>
					<td style='text-align:left;'>\$db_host = ".$host.";</td>		
				</tr>								

				<tr>
					<td style='text-align:right;'>VARIABLE USER NAME </td>
					<td style='text-align:left;'>\$db_user = ".$user.";</td>		
				</tr>	
												
				<tr>
					<td style='text-align:right;'>VARIABLE PASSWORD </td>
					<td style='text-align:left;'>\$db_pass = ".$pass.";</td>		
				</tr>	
												
				<tr>
					<td style='text-align:right;'>VARIABLE BBDD NAME </td>
					<td style='text-align:left;'>\$db_name = ".$name.";</td>		
				</tr>
				<tr>
		   			<td colspan=2>
						<a href='Config/config2.php'>
		   					CREE EL USUARIO ADMINISTRADOR
						</a>
					</td>
				</tr>
		</table>";
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function crear_tablas(){
	
		global $db;	 		global $db_host; 	global $db_user;
		global $db_pass; 	global $db_name; 	global $dbconecterror;
	
		require 'Inc_Crea_Tablas.php';

	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function modif(){
									   							
	$filename = "ayear.php";
	$fw1 = fopen($filename, 'r+');
	$contenido = fread($fw1,filesize($filename));
	fclose($fw1);
	
	$contenido = explode("\n",$contenido);
	/*
	Y EL AÑO ANTERIOR: 
	$contenido[2] = "'' => 'YEAR',\n'".date('y')."' => '".date('Y')."',\n'".(date('y')-1)."' => '".(date('Y')-1)."',";
	*/
	$contenido[2] = "'' => 'YEAR',\n'".date('y')."' => '".date('Y')."',";
	$contenido = implode("\n",$contenido);
	
	//fseek($fw, 37);
	$fw = fopen($filename, 'w+');
	fwrite($fw, $contenido);
	fclose($fw);
}

function modif2(){

	$filename = "year.txt";
	$fw2 = fopen($filename, 'w+');
	$date = "".date('Y')."";
	fwrite($fw2, $date);
	fclose($fw2);
}

function ayear(){
	$filename = "year.txt";
	$fw2 = fopen($filename, 'r+');
	$fget = fgets($fw2);
	fclose($fw2);
	
	if($fget == date('Y')){}
	elseif($fget != date('Y')){ 	modif();
									modif2();
		}

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	/* Se pasan los valores por defecto y se devuelven los que ha escrito el usuario. */
	
	if(isset($_POST['config'])){
		$defaults = $_POST;
		} else {$defaults = array ( 'host' => '',
									'user' => '',
									'pass' => '',
									'name' => '');
								   }
	
	if ($errors){
		print("	<table align='center'>
					<tr>
						<th style='text-align:center'>
							<font color='#FF0000'>* SOLUCIONE ESTOS ERRORES:</font><br/>
						</th>
					</tr>
					<tr>
						<td style='text-align:left'>");
			
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#FF0000'>**</font>  ".$errors [$a]."<br/>");
			}
		print("</td>
				</tr>
				</table>");
					}
					
	global $link;
	if($_SESSION['inst'] == "inst"){ print ("<table align='center'>
														".$link."
											</table>");		
	}else{

		require 'tabla_conecta.php';
		
	} // FIN PRINT TABLE
	
	} // FIN FUNCTION SHOW_FOMR	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Admin_Inclu_footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>