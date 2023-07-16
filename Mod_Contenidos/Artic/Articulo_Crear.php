<?php
session_start();

  	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';

	require '../Inclu/Admin_Inclu_Head_b.php';

	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

///////////////////////////////////////////////////////////////////////////////////////////////

if (($_SESSION['Nivel'] == 'admin') || ($_SESSION['Nivel'] == 'userpro')){

	master_index();

	if(isset($_POST['oculto'])){
							
			if($form_errors = validate_form()){
						show_form($form_errors);
			} else { process_form();
					 //accion_Log();
						}
	} else { show_form(); }

} else { require '../Inclu/table_permisos.php'; } 

//////////////////////////////////////////////////////////////////////////////////////////////

function validate_form(){
	
	global $db; 	global $db_name;
	global $sqld; 	global $qd; 	global $rowd;

	$errors = array();

	if(strlen(@trim($_POST['refart'])) != 0){	
		$secc1 = "`".$_SESSION['clave'].date('Y')."articulos`";
		$sqlc =  "SELECT * FROM `$db_name`.$secc1 WHERE `refart` = '$_POST[refart]'";
		$qc = mysqli_query($db, $sqlc);
		global $conutc; 	$countc = mysqli_num_rows($qc);
		if($countc > 0){
			$errors [] = "YA EXISTE EL ARTICULO.";
			}
		}

		///////////////////////////////////////////////////////////////////////////////////

	if(strlen(@trim($_POST['titulo'])) == 0){
		$errors [] = "TITULO <font color='#FF0000'>Campo es obligatorio.</font>";
		}
	
	elseif (strlen(@trim($_POST['titulo'])) < 6){
		$errors [] = "TITULO <font color='#FF0000'>Más de 5 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['titulo'])){
		$errors [] = "TITULO <font color='#FF0000'>Caracteres no válidos.</font>";
		}
		
	elseif (!preg_match('/^[a-z A-Z,0-9\s]+$/',$_POST['titulo'])){
		$errors [] = "TITULO  <font color='#FF0000'>Solo mayusculas o números sin acentos.</font>";
		}
	
	elseif(strlen(@trim($_POST['titulo'])) != 0){	
		$secc1 = "`".$_SESSION['clave'].date('Y')."articulos`";
		$sqlc =  "SELECT * FROM `$db_name`.$secc1 WHERE `tit` = '$_POST[titulo]'";
		$qc = mysqli_query($db, $sqlc);
		global $conutc; 	$countc = mysqli_num_rows($qc);
		if($countc > 0){
		$errors [] = "YA EXISTE ESTE TITULO";
			}
	}

	if(strlen(@trim($_POST['subtitul'])) == 0){
		$errors [] = "SUBTITULO  <font color='#FF0000'>Campo es obligatorio.</font>";
		}
	
	elseif (strlen(@trim($_POST['subtitul'])) < 5){
		$errors [] = "SUBTITULO  <font color='#FF0000'>Más de 4 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\.\*\']+$/',$_POST['subtitul'])){
		$errors [] = "SUBTITULO  <font color='#FF0000'>Caracteres no válidos.</font>";
		}
		
	elseif (!preg_match('/^[a-z A-Z,0-9\s]+$/',$_POST['subtitul'])){
		$errors [] = "SUBTITULO  <font color='#FF0000'>Solo mayusculas o números sin acentos.</font>";
		}
	
	elseif(strlen(@trim($_POST['subtitul'])) != 0){	
		$secc1 = "`".$_SESSION['clave'].date('Y')."articulos`";
		$sqlc =  "SELECT * FROM `$db_name`.$secc1 WHERE `titsub` = '$_POST[subtitul]'";
		$qc = mysqli_query($db, $sqlc);
		global $conutc;
		$countc = mysqli_num_rows($qc);
		if($countc > 0){
			$errors [] = "YA EXISTE ESTE SUBTITULO";
			}
	}
	
	if(strlen(@trim($_POST['coment'])) == 0){
		$errors [] = "ARTICULO <font color='#FF0000'>Campo obligatorio.</font>";
		}

	elseif(strlen(@trim($_POST['coment'])) <= 50){
		$errors [] = "ARTICULO <font color='#FF0000'>Mas de 50 carácteres.</font>";
		}

	elseif(strlen(@trim($_POST['coment'])) >= 402){
		$errors [] = "ARTICULO <font color='#FF0000'>Excedió más de 400 carácteres.</font>";
		}
		

	elseif (!preg_match('/^[a-z A-Z 0-9 \s ,.;:\'-()¡!¿?@ áéíóúñ €]+$/',$_POST['coment'])){
			$errors [] = "ARTICULO  <font color='#FF0000'>Caracteres no permitidos. { } [ ] $ < >  # ...</font>";
			}


		///////////////////////////////////////////////////////////////////////////////////

		if($_FILES['myimg']['size'] == 0){
			$errors [] = "Seleccione una fotograf&iacute;a.";
			global $img2;
			$img2 = 'untitled.png';
		}

		else{
			
		$limite = 1400 * 1024;
		
		$ext_permitidas = array('.jpg','.JPG','.gif','.GIF','.png','.PNG', 'jpeg', 'JPEG');
		$extension = substr($_FILES['myimg']['name'],-4);
		// print($extension);
		$ext_correcta = in_array($extension, $ext_permitidas);

		global $extension1;
		$extension1 = strtolower($extension);
		$extension1 = str_replace(".","",$extension1);
		global $ctemp;
		$ctemp = "../Temp";

		if(!$ext_correcta){
			$errors [] = "La extension no esta admitida: ".$_FILES['myimg']['name'];
			global $img2;
			$img2 = 'untitled.png';
			}
	/*
		elseif(!$tipo_correcto){
			$errors [] = "Este tipo de archivo no esta admitido: ".$_FILES['myimg']['name'];
			global $img2;
			$img2 = 'untitled.png';
			}
	*/
		elseif ($_FILES['myimg']['size'] > $limite){
		$tamanho = $_FILES['myimg']['size'] / 1024;
		$errors [] = "El archivo".$_FILES['myimg']['name']." es mayor de 140 KBytes. ".$tamanho." KB";
		global $img2;
		$img2 = 'untitled.png';
			}

		elseif ($_FILES['myimg']['size'] <= $limite){
			copy($_FILES['myimg']['tmp_name'], $ctemp."/ini1v.".$extension1); 
			global $ancho;
			global $alto;
			list($ancho, $alto, $tipo, $atributos) = getimagesize($ctemp."/ini1v.".$extension1);

			if($ancho < 400){
				$errors [] = "IMAGEN ".$_FILES['myimg']['name']." ANCHURA MENOR DE 400 * IMG = ".$ancho;
			}
			/*
			elseif(($ancho > 900)&&($alto < 400)){
				$errors [] = "IMAGEN ".$_FILES['myimg']['name']." ALTURA MENOR DE 400 ".$alto;
			}
			*/
			elseif(($ancho >= 400)&&($alto < 400)){
				$errors [] = "IMAGEN ".$_FILES['myimg']['name']." ALTURA MENOR DE 400 * IMG = ".$alto;
			}
		}
			elseif ($_FILES['myimg']['error'] == UPLOAD_ERR_PARTIAL){
				$errors [] = "LA CARGA DEL ARCHIVO SE HA INTERRUMPIDO";
				global $img2;
				$img2 = 'untitled.png';
				}
				
				elseif ($_FILES['myimg']['error'] == UPLOAD_ERR_NO_FILE){
					$errors [] = "EL ARCHIVO NO SE HA CARGADO";
					global $img2;
					$img2 = 'untitled.png';
					}
				}

	return $errors;

		} 
		
//////////////////////////////////////////////////////////////////////////////////////////////

function process_form(){
	
	global $db; 	global $db_name; 	global $secc;	
	global $_sec; 	$secc = $_POST['autor'];
	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";
	$sqlx =  "SELECT * FROM $tablename WHERE `ref` = '$_POST[autor]'";
	$q = mysqli_query($db, $sqlx);
	$rowautor = mysqli_fetch_assoc($q);
	$_sec = $rowautor['Nombre']." ".$rowautor['Apellidos'];
	//echo $rowautor['Nombre']." ".$rowautor['Apellidos']."</br>";
	
	global $carpetaimg;
	$carpetaimg = "../Img.Art";
	global $extension;
	$extension = substr($_FILES['myimg']['name'],-4);
	$extension = strtolower($extension);
	global $extension;
	$extension = str_replace(".","",$extension);
// print($extension);
	global $new_name;
	$new_name = $_POST['refart'].".".$extension;
	$_SESSION['new_name'] = $new_name;

		/* GRABAMOS LOS DATOS EN LA TABLA DE ARTICULOS DE ESTE AÑO */

		global $db; 	global $db_name;

		global $tablename;	$tablename = "`".$_SESSION['clave'].date('Y')."articulos`";
		global $titulo; 	$titulo = strtoupper($_POST['titulo']);
		global $subtitul; 	$subtitul = strtoupper($_POST['subtitul']);

	$sqla = "INSERT INTO `$db_name`.$tablename (`refuser`, `refart`,`tit`,`titsub`,`datein`,`timein`,`datemod`,`timemod`,`conte`,`myimg`,`myurl`,`visible`) VALUES ('$_POST[autor]', '$_POST[refart]', '$titulo', '$subtitul', '$_POST[datein]', '$_POST[timein]', '0000-00-00', '00:00:00', '$_POST[coment]', '$new_name', '$_POST[myurl]', '$_POST[visible]')";

	if(mysqli_query($db, $sqla)){

			global $carpetaimg;
			global $new_name;

			global $redir;
			$redir = "";
	
		
			require 'Inc_Modificar_Img.php';

	print("<table style='margin-top:10px; width: min-content;'>
				<tr>
					<th colspan=3 class='BorderInf'>
						CREADO POR ".strtoupper($_sec)."
					</th>
				</tr>
												
				<tr>
					<td style='text-align:right; width:120px;' >REFERENCIA</td>
					<td style='text-align:left; width:100px;'>".$_POST['refart']."</td>
					<td style='text-align:center; width:100px' rowspan='4'>
				<img style='width:96px; height:auto;' src='".$carpetaimg."/".$new_name."' />
					</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>TITULO</td>
					<td style='text-align:left;'>".$_POST['titulo']."</td>
				</tr>				
				
				<tr>
					<td style='text-align:right;'>SUBTITULO</td>
					<td style='text-align:left;'>".$_POST['subtitul']."</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>URL</td>
					<td style='text-align:left;'>".$_POST['myurl']."</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>DATE IN</td>
					<td style='text-align:left;'>".$_POST['datein']."</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>TIME IN</td>
					<td style='text-align:left;'>".$_POST['timein']."</td>
				</tr>
				
				<tr>
					<td colspan=3>ARTICULO</td>
				</tr>
				<tr>
					<td style='text-align:left;' colspan=3>".$_POST['coment']."</td>
				</tr>
				<tr>
					<th colspan=3 class='BorderSup'>
						<a href=Articulo_Crear.php>CREAR UN NUEVO ARTICULO</a>
					</th>
				</tr>
			</table>");
			
	} 	else {print("* MODIFIQUE LA ENTRADA L.207: ".mysqli_error($db));
						show_form ();
						//global $texerror;
						//$texerror = "\n\t ".mysqli_error($db);
					}
		
	}	/* FINAL process_form(); */

//////////////////////////////////////////////////////////////////////////////////////////////

function show_form($errors=[]){
	
	unset($_SESSION['myimgPost']);
	
	$ctemp = "../Temp";
	if(file_exists($ctemp)){$dir1 = $ctemp."/";
							$handle1 = opendir($dir1);
							while ($file1 = readdir($handle1))
									{if (is_file($dir1.$file1))
										{unlink($dir1.$file1);}
										}	
								} else {}

	if(isset($_POST['oculto1'])){
		//$defaults = $_POST;
		$_SESSION['refart'] = date('Y.m.d.H.i.s');
		$_SESSION['datein'] = date('Y-m-d');
		$_SESSION['timein'] = date('H:i:s');
		$defaults = array ( 'autor' => @$_POST['autor'],  // ref autor
							'titulo' => @$_POST['titulo'], // Titulo
							'subtitul' => @$_POST['subtitul'], // Sub Titulo
							//'refart' => @$_SESSION['refart'],  Referencia articulo
							'coment' => @$_POST['coment'],
							'myimg' => @$_POST['myimg'],	
							'myurl' => @$_POST['myurl'],	
							'visible' => @$_POST['visible'],);
		} 
	elseif(isset($_POST['oculto'])){
		$defaults = $_POST;
		} else { $defaults = array ( 'autor' => isset($_POST['autor']),  // ref autor
									'titulo' => '', // Titulo
								   	'subtitul' => '', // Sub Titulo
								   	//'refart' => @$_SESSION['refart'],  Referencia articulo
								   	'coment' => '',
									'myimg' => '',	
									'myurl' => '',	
									'visible' => 'n',);
								}
	
	if ($errors){
		print("	<table align='center'>
					<th style='text-align:center'>
						<font color='#FF0000'>* SOLUCIONE ESTOS ERRORES:</font><br/>
					</th>
					<tr>
						<td style='text-align:left'>");
			
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#FF0000'>**</font>  ".$errors [$a]."<br/>");
			}
		print("</td></tr></table>");
				}
		
	/* CONSULTAMOS LA TABLA ADMIN = AUTORES */
	global $db;
	global $_sec;
	global $autor;
	$autor = @$_POST['autor'];

	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";

	$sqlx =  "SELECT * FROM $tablename WHERE `ref` = '$autor' ";
	$q = mysqli_query($db, $sqlx);
	$rowautor = mysqli_fetch_assoc($q);
	$_sec = @$rowautor['Nombre'];

	global $selected;

	print("<table align='center' style=\"border:0px;margin-top:4px\" width='400px'>
				<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
			<tr>
				<th colspan='2'>CREAR ARTICULO DE ".strtoupper($_sec)."</th>
			</tr>		
			<tr>
				<td align='right'>
					<input type='submit' value='SELECCIONE UN AUTOR' class='botonverde' />
					<input type='hidden' name='oculto1' value=1 />

					<input type='hidden' name='titulo' value='".@$defaults['titulo']."' />
					<input type='hidden' name='subtitul' value='".@$defaults['subtitul']."' />
					<input type='hidden' name='coment' value='".@$defaults['coment']."' />
					<input type='hidden' name='myimg' value='".@$defaults['myimg']."' />
					<input type='hidden' name='myurl' value='".@$defaults['myurl']."' />
					<input type='hidden' name='visible' value='".@$defaults['visible']."' />
				</td>
				<td align='left'>
					<select name='autor'>
						<option value='' ".$selected.">SELECCIONE AUTOR</option>");
						
	/* RECORREMOS LOS VALORES DE LA TABLA PARA CONSTRUIR CON ELLOS UN SELECT */	
			
	global $db;
	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";

	$sqlb =  "SELECT * FROM $tablename ORDER BY `Apellidos` ASC ";
	$qb = mysqli_query($db, $sqlb);
	if(!$qb){
			print("* ".mysqli_error($db)."</br>");
	} else {
		while($rows = mysqli_fetch_assoc($qb)){
				print ("<option value='".$rows['ref']."' ");
				if($rows['ref'] == $defaults['autor']){ print ("selected = 'selected'"); }
					print ("> ".$rows['Apellidos']." ".$rows['Nombre']."</option>");
			}
		}  // FIN ELSE

	print ("</select></td></tr></form></table>");
				
	if (isset($_POST['oculto1']) || isset($_POST['oculto'])) {

	if ($_POST['autor'] == ''){
		print("<table style=\"margin-top:20px;margin-bottom:20px\">
					<tr>
						<td><font color='red'><b>SELECCIONE UN AUTOR ".$defaults['autor']."</font></td>
					</tr>
				</table>");
		global $selected;					
		$selected = "selected = 'selected'";
		$defaults['autor'] = '';
		$defaults['visible'] = 'n';
	} 
								
	elseif ($_POST['autor'] != '') { 
		
	print("<table align='center' style=\"margin-top:10px\">
			<tr>
				<th colspan=2 class='BorderInf'>
					NUEVO ARTICULO DE ".strtoupper($_sec)."
				</th>
			</tr>
	<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
			<tr>
				<td style='text-align:right; width:140px'>REF AUTOR </td>
				<td style='text-align:left;'>
			<input name='autor' type='hidden' value='".$defaults['autor']."' />".$defaults['autor']."
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>TITULO </td>
				<td style='text-align:left;'>
		<input type='text' name='titulo' size=20 maxlength=20 value='".@$defaults['titulo']."' />
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>SUBTITULO </td>
				<td style='text-align:left;'>
		<input type='text' name='subtitul' size=20 maxlength=20 value='".@$defaults['subtitul']."' />
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>URL </td>
				<td style='text-align:left;'>
		<input type='text' name='myurl' size=20 maxlength=30 value='".@$defaults['myurl']."' />
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>REFERENCIA </td>
				<td style='text-align:left;'>
		<input type='hidden' name='refart' value='".$_SESSION['refart']."' />".$_SESSION['refart']."
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>DATE IN </td>
				<td style='text-align:left;'>
		<input type='hidden' name='datein' value='".$_SESSION['datein']."' />".$_SESSION['datein']."
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>TIME IN </td>
				<td style='text-align:left;'>
		<input type='hidden' name='timein' value='".$_SESSION['timein']."' />".$_SESSION['timein']."
				</td>
			</tr>
			<tr>
				<td colspan=2 class='BorderSup'>ESTADO DE LA PUBLICACIÓN</td>
			</tr>
			<tr>
				<td colspan=2 class='BorderInf'>");

			global $a;	$a=0;	global $c;
			$vis = array ('NO' => 'n', 'SI' => 'y');
		foreach ($vis as $key => $value){
				if ($a<$c){ $a++;}else { }
				//echo "* KEY: ".$key." || * VALUE: ".$value."<br>";
			echo"<input type='radio' id='visible".$a."' name='visible' value='".$value."'";
					if($defaults['visible'] == $value) {print(" checked=\"checked\"");} else {  }
			echo" required /><label style='display:inline-block; margin:1px 8px 1px 8px;' for='visible".$a."'> VISIBLE ".$key."</label>";
		} // FIN FOREACH

		print("</td>
			<tr>
				<td colspan=2>ARTICULO</td>
			</tr>
			<tr>
				<td colspan=2>
	<textarea cols='41' rows='9' onkeypress='return limitac(event, 400);' onkeyup='actualizaInfoc(400)' name='coment' id='coment'>".@$defaults['coment']."</textarea>
			</br>
	     <div id='infoc' align='center' style='color:#0080C0;'>MAXIMO 400 CARACTERES</div>
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>FOTOGRAFÍA </td>
				<td style='text-align:left;'>
		<input type='file' name='myimg' value='".@$defaults['myimg']."' />						
				</td>
			</tr>
			<tr>
				<td colspan='2' align='right' valign='middle'  class='BorderSup'>
					<input type='submit' value='CREAR ARTICULO' class='botonverde' />
					<input type='hidden' name='oculto' value=1 />
				</td>
			</tr>
		</form>														
	</table>"); 
				} // SI HA SELECCIONADO AUTOR
			} // FIN AUTOR
	
	}	

/////////////////////////////////////////////////////////////////////////////////////////////////
/*
function accion_Log(){

	global $db;
	global $rowout;
	global $secc;
	global $_sec;
	$secc = $_sec;	

	$ActionTime = date('H:i:s');

	global $dir;
	if (($_SESSION['Nivel'] == 'admin') || ($_SESSION['Nivel'] == 'userpro')){ $dir = 'Admin';}
	elseif ($_SESSION['Nivel'] == 'cliente'){ $dir = 'Clientes';}
	elseif (($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'caja')){ $dir = 'User';}
	
global $text;
$text = "- PRODUCTO CREAR ".$ActionTime.". ".$secc.".\n\t Pro Name: ".$_POST['subtitul'].".\n\t Pro titulo: ".$_POST['titulo'].".\n\t Pro Ref: ".$_POST['ref'].".\n\t Coment: ".$_POST['coment'];

		$logname = $_SESSION['Nombre'];	
		$logape = $_SESSION['Apellidos'];	
		$logname = @trim($logname);	
		$logape = @trim($logape);	
		$logdocu = $logname."_".$logape;
		$logdate = date('Y_m_d');
		$logtext = $text."\n";
		$filename = "../logs/".$dir."/".$logdate."_".$logdocu.".log";
		$log = fopen($filename, 'ab+');
		fwrite($log, $logtext);
		fclose($log);

	}
*/
/////////////////////////////////////////////////////////////////////////////////////////////////
	
	function master_index(){
		
				require '../Inclu.Menu/rutaartic.php';				
				require '../Inclu.Menu/Master_Index.php';
		
			} 

/////////////////////////////////////////////////////////////////////////////////////////////////
	
	require '../Inclu/Admin_Inclu_footer.php';

/////////////////////////////////////////////////////////////////////////////////////////////////

/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>