<?php
session_start();

  	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';

	global $headpop;
	$headpop = "<tr>
					<td colspan=3 align='right' class='BorderSup BorderInf'>
						<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
							<input type='submit' value='CERRAR VENTANA' class='botonrojo' />
							<input type='hidden' name='oculto2' value=1 />
						</form>
					</td>
				</tr>";

	require '../Inclu/Admin_Inclu_popup.php';

	require '../Inclu/mydni.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

///////////////////////////////////////////////////////////////////////////////////////////////

if (($_SESSION['Nivel'] == 'admin') || ($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){ 

		if (isset($_POST['oculto2'])){
					show_form();
					//accion_Log();
				}
		elseif(isset($_POST['oculto'])){
							
			if($form_errors = validate_form()){
				show_form($form_errors);
					} else {
						process_form();
						//accion_Log();
						}
		} else {
					show_form();
			}
} else { require '../Inclu/table_permisos.php'; } 

//////////////////////////////////////////////////////////////////////////////////////////////

function validate_form(){
	
	global $db;
	global $db_name;

	global $dyt1;
	$dyt1 = @trim($_SESSION['dyt1']);

	$errors = array();

/* */		
	if(strlen(@trim($_POST['refart'])) != 0){	

			global $secc1;	$secc1 = "`".$_SESSION['clave'].$dyt1."articulos`";

			$sqlc =  "SELECT * FROM `$db_name`.$secc1 WHERE `refart` = '$_POST[refart]'";
			$qc = mysqli_query($db, $sqlc);
			global $conutc;
			$countc = mysqli_num_rows($qc);
			if($countc > 1){
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
			global $secc1;	$secc1 = "`".$_SESSION['clave'].$dyt1."articulos`";

			global $titulo; 	$titulo = strtoupper($_POST['titulo']);
			global $artid; 		$artid = $_SESSION['idart'];
			$sqlc =  "SELECT * FROM `$db_name`.$secc1 WHERE `tit` = '$titulo' AND `id` <> '$artid' ";
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
			global $secc1;	$secc1 = "`".$_SESSION['clave'].$dyt1."articulos`";
			global $subtitul; 	$subtitul = strtoupper($_POST['subtitul']);
			global $artid; 		$artid = $_SESSION['idart'];
			$sqlc =  "SELECT * FROM `$db_name`.$secc1 WHERE `titsub` = '$subtitul' AND `id` <> '$artid'";
			$qc = mysqli_query($db, $sqlc);
			global $conutc; 	$countc = mysqli_num_rows($qc);
			if($countc > 0){
				$errors [] = "YA EXISTE ESTE SUBTITULO ".$dyt1;
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

	return $errors;

		} 
		
//////////////////////////////////////////////////////////////////////////////////////////////

function process_form(){
	
	global $db; 	global $db_name;

	global $secc; 	$secc = $_POST['autor'];
	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";

	$sqlx =  "SELECT * FROM $tablename WHERE `ref` = '$_POST[autor]'";
	$q = mysqli_query($db, $sqlx);
	$rowautor = mysqli_fetch_assoc($q);
	global $_sec;
	$_sec = $rowautor['Nombre']." ".$rowautor['Apellidos'];
	//echo $rowautor['Nombre']." ".$rowautor['Apellidos']."</br>";
	
	global $carpetaimg;
	$carpetaimg = "../Img.Art";

	/* GRABAMOS LOS DATOS EN LA TABLA DE ARTICULOS DE ESTE AÑO */

	global $dyt1;
	$dyt1 = substr($_SESSION['refart'],0,4);
	echo $dyt1;
	global $tablename;	$tablename = "`".$_SESSION['clave'].$dyt1."articulos`";

	global $titulo; 	$titulo = strtoupper($_POST['titulo']);
	global $subtitul; 	$subtitul = strtoupper($_POST['subtitul']);

	global $sqla;
	$sqla = "UPDATE `$db_name`.$tablename SET `refuser` = '$_POST[autor]', `tit` = '$titulo', `titsub` = '$subtitul', `datemod` = '$_POST[datemod]', `timemod` = '$_POST[timemod]', `conte` = '$_POST[coment]', `myurl` = '$_POST[myurl]' WHERE $tablename.`refart` = '$_SESSION[refart]' LIMIT 1 ";

	if(mysqli_query($db, $sqla)){

		global $carpetaimg;
		global $new_name;
		global $headpop;

		print("<table align='center' style=\"margin-top:10px; text-align:left; width:96%; max-width:500px\" >
				<tr>
					<th colspan=3 class='BorderInf'>CREADO POR ".strtoupper($_sec)."</th>
				</tr>
												
				<tr>
					<td style='text-align:right; width:100px;'>REFERENCIA</td>
					<td style='text-align:left; width:140px'>".$_SESSION['refart']."</td>
					<td rowspan='4' align='center' width='auto'>
				<img style='width:98%; height:auto;' src='".$carpetaimg."/".$_SESSION['myimgPost']."'  />
					</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>TITULO </td>
					<td style='text-align:left;'>".$_POST['titulo']."</td>
				</tr>				
				
				<tr>
					<td style='text-align:right;'>SUBTITULO </td>
					<td style='text-align:left;'>".$_POST['subtitul']."</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>URL </td>
					<td style='text-align:left;'>".$_POST['myurl']."</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>DATE IN </td>
					<td style='text-align:left;'>".$_POST['datein']."</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>TIME IN </td>
					<td style='text-align:left;'>".$_POST['timein']."</td>
				</tr>
				
				<tr>
					<td colspan=3'>ARTICULO</td>
				</tr>
					<td colspan=3 align='left'>"
						.$_POST['coment'].
					"</td>
				</tr>".$headpop."</table>");
			
	} 	else {print("* MODIFIQUE LA ENTRADA L.147: ".mysqli_error($db));
						show_form ();
						//global $texerror;
						//$texerror = "\n\t ".mysqli_error($db);
					}
		
	}	/* FINAL process_form(); */

//////////////////////////////////////////////////////////////////////////////////////////////

function show_form($errors=[]){
	
	if(isset($_POST['oculto2'])){
		//$defaults = $_POST;
		
		//$_SESSION['dyt1'] = $_POST['dyt1'];
		$_SESSION['idart'] = $_POST['id'];
		$_SESSION['refuser'] = $_POST['refuser'];
		$_SESSION['tit'] = $_POST['tit'];
		$_SESSION['titsub'] = $_POST['titsub'];
		$_SESSION['refart'] = $_POST['refart'];
		$_SESSION['datein'] = $_POST['datein'];
		$_SESSION['timein'] = $_POST['datein'];
		$_SESSION['datemod'] = date('Y-m-d');
		$_SESSION['timemod'] = date('H:i:s');
		$_SESSION['conte'] = $_POST['conte'];
		$_SESSION['myimgPost'] = $_POST['myimg'];
		$_SESSION['myurl'] = $_POST['myurl'];
		
		$defaults = array ( 'autor' => $_SESSION['refuser'],  // ref autor
							'titulo' => $_SESSION['tit'], // Titulo
							'subtitul' => $_SESSION['titsub'], // Sub Titulo
							'refart' => $_SESSION['refart'], // Referencia articulo
							'datein' => $_SESSION['datein'], // Sub Titulo
							'timein' => $_SESSION['timein'], // Sub Titulo
							'datemod' => $_SESSION['datemod'], // Sub Titulo
							'timemod' => $_SESSION['timemod'], // Sub Titulo
							'coment' => $_SESSION['conte'],
							'myimg' => $_SESSION['myimgPost'],	
							'myurl' => $_SESSION['myurl'],	
									);

		} elseif(isset($_POST['oculto1'])){
				//$defaults = $_POST;
				$_SESSION['refuser'] = $_POST['autor'];
				$_SESSION['datemod'] = date('Y-m-d');
				$_SESSION['timemod'] = date('H:i:s');
				$defaults = array ( 'autor' => $_POST['autor'],  // ref autor
									'titulo' => strtoupper($_SESSION['tit']), // Titulo
									'subtitul' => strtoupper($_SESSION['titsub']), // Sub Titulo
									'refart' => $_SESSION['refart'], // Referencia articulo
									'datein' => $_SESSION['datein'], // Sub Titulo
									'timein' => $_SESSION['timein'], // Sub Titulo
									'datemod' => $_SESSION['datemod'], // Sub Titulo
									'timemod' => $_SESSION['timemod'], // Sub Titulo
									'coment' => $_SESSION['conte'],
									'myimg' => $_SESSION['myimgPost'],	
									'myurl' => $_SESSION['myurl'],	
									);

	} elseif(isset($_POST['oculto'])){
					$defaults = $_POST;

		} else {$defaults = array ( 'autor' => isset($_POST['autor']),  // ref autor
									'titulo' => '', // Titulo
								   	'subtitul' => '', // Sub Titulo
								   	//'refart' => @$_SESSION['refart'],  Referencia articulo
								   	'coment' => '',
									'myimg' => '',);
					}
	
	if ($errors){
		print("	<div  class='errors'>
					<table align='left' style='border:none'>
					<th style='text-align:left'>
					<font color='#FF0000'>* SOLUCIONE ESTOS ERRORES:</font><br/>
					</th>
					<tr>
					<td style='text-align:left'>");
			
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#FF0000'>**</font>  ".$errors [$a]."<br/>");
			}
		print("</td>
				</tr>
				</table>
				</div>
				<div style='clear:both'></div>");
		}
		
	global $db; 		global $db_name;
	global $autor; 		$autor = $_SESSION['refuser'];
	/* CONSULTAMOS LA TABLA ADMIN = AUTORES */
	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";

	$sqlx =  "SELECT * FROM $tablename WHERE `ref` = '$autor' ";
	$q = mysqli_query($db, $sqlx);
	$rowautor = mysqli_fetch_assoc($q);
	$counta = mysqli_num_rows($q);
	global $_sec;
	if ($counta !== 1){$_sec = "AUTOR ANONIMO";}
	else {$_sec = $rowautor['Nombre']." ".$rowautor['Apellidos'];}
	
	global $headpop;

	print("<table style=\"margin-top:4px;\">
				<tr>
					<th colspan='2'>MODIFICAR ARTICULO DE ".strtoupper($_sec)."</th>
				</tr>	
				".$headpop."
				<tr>
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
					<td align='right'>
						<input type='submit' value='SELECCIONE UN AUTOR' class='botonnaranja' />
						<input type='hidden' name='oculto1' value=1 />
					</td>
					<td align='left'>
						<select name='autor'>");
						
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
					if($rows['ref'] == $defaults['autor']){print ("selected = 'selected'");}
							print ("> ".$rows['Apellidos']." ".$rows['Nombre']."</option>");
						}
					}  

	print ("</select></td></tr>
	
		</form></table>");
				
	if ((strlen(@trim(@$_POST['autor'])) == 0) && (strlen(@trim($_SESSION['refuser']))) == 0) { 
			print("<table align='center' style=\"margin-top:20px;margin-bottom:20px\">
						<tr align='center'><td>
								<font color='red'>
						<b>HA DE SELECCIONAR UN AUTOR PARA CREAR ARTICULOS.
								</font>
						</td></tr>
					</table>");
				}	

	elseif ((@$_POST['autor'] != '') || ($_SESSION['refuser'] != '')) { 
		
	print("<table align='center' style=\"margin-top:10px\">
				<tr><th colspan=2 class='BorderInf'>
							ARTICULO DE ".strtoupper($_sec)."
				</th></tr>
				
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' >
			<tr>								
				<td style='text-align:right;'>REF AUTOR </td>
				<td style='text-align:left;'>
			<input name='autor' type='hidden' value='".$defaults['autor']."' />".$defaults['autor']."
				</td>
			</tr>

			<tr>
				<td style='text-align:right;'>TITULO </td>
				<td style='text-align:left;'>
		<input type='text' name='titulo' size=20 maxlength=20 value='".strtoupper($defaults['titulo'])."' />
				</td>
			</tr>
									
			<tr>
				<td style='text-align:right;'>SUBTITULO </td>
				<td style='text-align:left;'>
		<input type='text' name='subtitul' size=20 maxlength=20 value='".strtoupper($defaults['subtitul'])."' />
				</td>
			</tr>
									
			<tr>
				<td style='text-align:right;'>URL </td>
				<td style='text-align:left;'>
		<input type='text' name='myurl' size=20 maxlength=30 value='".$defaults['myurl']."' />
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
				<td style='text-align:right;'>DATE MOD </td>
				<td style='text-align:left;'>
		<input type='hidden' name='datemod' value='".$defaults['datemod']."' />".$defaults['datemod']."
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>TIME MOD </td>
				<td style='text-align:left;'>
		<input type='hidden' name='timemod' value='".$defaults['timemod']."' />".$defaults['timemod']."
				</td>
			</tr>

			<tr>
				<td colspan=2>ARTICULO </td>
			</tr>
			<tr>
				<td colspan=2>
	<textarea cols='41' rows='9' onkeypress='return limitac(event, 400);' onkeyup='actualizaInfoc(400)' name='coment' id='coment'>".$defaults['coment']."</textarea>
			</br>
	            <div id='infoc' align='center' style='color:#0080C0;'>
        					Maximum 400 characters            
				</div>
				</td>
			</tr>
								
		<input name='myimg' type='hidden' value='".$_SESSION['myimgPost']."' />

			<tr>
				<td colspan='2' style='text-align:right;' valign='middle'  class='BorderSup'>
					<input type='submit' value='MODIFICAR ARTICULO' class='botonnaranja' />
					<input type='hidden' name='oculto' value=1 />
				</td>
			</tr>
		</form>														
			</table>"); 
				}
	
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
	
	function desconexion(){

			print("<form name='cerrar' action='../Mod_Admin_Plus/Admin/mcgexit.php' method='post'>
							<tr>
								<td valign='bottom' align='right' colspan='8'>
											<input type='submit' value='Cerrar Sesion' />
								</td>
							</tr>								
											<input type='hidden' name='cerrar' value=1 />
					</form>	
							");
	
			} 
	
/////////////////////////////////////////////////////////////////////////////////////////////////

	require '../Inclu/Admin_Inclu_footer.php';

	/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>