<?php
session_start();

	global $docs;
	$docs = 1;

	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../Inclu/Admin_Inclu_popup.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';
	require '../Inclu/Only.rowd.php';

///////////////////////////////////////////////////////////////////////////////////////

if (($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){

	if (isset($_POST['oculto2'])){
					show_form();
					//info_01();
					}
				elseif($_POST['imagenmodif']){
					
						if($form_errors = validate_form()){
							show_form($form_errors);
								} else {
									process_form();
									//info_02();
		$ctemp = "../Temp";
		if(file_exists($ctemp)){$dir1 = $ctemp."/";
								 $handle1 = opendir($dir1);
								 while ($file1 = readdir($handle1))
										 {if (is_file($dir1.$file1))
											 {unlink($dir1.$file1);}
											 }	
									 } else {}
		global $redir;
		$redir = "<script type='text/javascript'>
					function redir(){
						window.close();
							}
					setTimeout('redir()',8000);
				</script>";
		print ($redir);
									}
								
	} else { show_form(); }

} else { require '../Inclu/table_permisos.php'; }

//////////////////////////////////////////////////////////////////////////////////////////////

function validate_form(){
	
	$errors = array();

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

		if($_FILES['myimg']['size'] == 0){
			$errors [] = "SELECCIONE UNA IMAGEN";
			global $img2;
			$img2 = 'untitled.png';
		}
		 
		elseif(!$ext_correcta){
			$errors [] = "EXTENSION NO ADMINTIDA ".$_FILES['myimg']['name'];
			global $img2;
			$img2 = 'untitled.png';
			}
	/*
		elseif(!$tipo_correcto){
			$errors [] = "ARCHIVO NO ADMINTIDO ".$_FILES['myimg']['name'];
			global $img2;
			$img2 = 'untitled.png';
			}
	*/
		elseif ($_FILES['myimg']['size'] > $limite){
		$tamanho = $_FILES['myimg']['size'] / 1024;
		$errors [] = "IMAGEN ".$_FILES['myimg']['name']." > 140 KBytes. ".$tamanho." KB";
		global $img2;
		$img2 = 'untitled.png';
			}

		elseif ($_FILES['myimg']['size'] <= $limite){
			copy($_FILES['myimg']['tmp_name'], $ctemp."/ini1v.".$extension1); 
			global $ancho;
			global $alto;
			list($ancho, $alto, $tipo, $atributos) = getimagesize($ctemp."/ini1v.".$extension1);

			if($ancho < 400){
				$errors [] = "IMAGEN ".$_FILES['myimg']['name']." ANCHURA ".$ancho." MENOR DE 400 ";
			}
			elseif(($ancho > 400)&&($alto < 400)){
				$errors [] = "IMAGEN ".$_FILES['myimg']['name']." ALTURA MENOR DE 400 ".$alto;
			}
		}

			elseif ($_FILES['myimg']['error'] == UPLOAD_ERR_PARTIAL){
				$errors [] = "LA CARGA DEL ARCHIVO SE HA INTERRUMPIDO";
				}
				
				elseif ($_FILES['myimg']['error'] == UPLOAD_ERR_NO_FILE){
					$errors [] = "EL ARCHIVO NO SE HA CARGADO";
                    }
					
		return $errors;

		} 

//////////////////////////////////////////////////////////////////////////////////////////////

function process_form(){
	
	global $db; 	global $db_name;

	global $secc; 	$secc = $_SESSION['refuser'];
	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";

	$sqlx =  "SELECT * FROM $tablename WHERE `ref` = '$_SESSION[refuser]'";
	$q = mysqli_query($db, $sqlx);
	$rowautor = mysqli_fetch_assoc($q);
	global $_sec; 	$_sec = $rowautor['Nombre']." ".$rowautor['Apellidos'];
	//echo $rowautor['Nombre']." ".$rowautor['Apellidos']."</br>";

		// RENOMBRAR ARCHIVO
		global $extension;
		$extension = substr($_FILES['myimg']['name'],-4);
		$extension = strtolower($extension);
		global $extension; 	$extension = str_replace(".","",$extension);
		// print($extension);
		date('H:i:s');
		date('Y_m_d');
		$dt = date('is');
		global $new_name;
		$new_name = $_SESSION['srefart']."_".$dt.".".$extension;
		$_SESSION['new_name'] = $new_name;

	global $db; 	global $db_name;
	
	global $dyt1; 	$dyt1 = substr($_SESSION['srefart'],0,4);
	global $tablename;	$tablename = "`".$_SESSION['clave'].$dyt1."articulos`";

	$sqlc = "UPDATE `$db_name`.$tablename SET `myimg` = '$new_name' WHERE $tablename.`refart` = '$_SESSION[srefart]' LIMIT 1 ";

	if(mysqli_query($db, $sqlc)){
		
			global $new_name;
			global $redir;
			$redir = "";
	
			require 'Inc_Modificar_Img.php';
	
			print("</br>
					MODIFICADO CORRECTAMENTE");
	print( "<table style=\"margin-top:20px; width:96%; max-width:500px\" >
				<tr>
					<th colspan=3 class='BorderInf' >
						ARTICULO CREADO POR ".strtoupper($_sec)."
					</th>
				</tr>
				
				<tr>
					<td style='text-align:right; width:140px;' >REFERENCIA </td>
					<td style='text-align:left; width:140px;'>".$_SESSION['srefart']."</td>
					<td rowspan='6'>
			<img style='width:120px; height:auto;' src='../Img.Art/".$new_name."' />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>TITULO </td>
					<td style='text-align:left;'>".$_POST['tit']."</td>
				</tr>				
				<tr>
					<td style='text-align:right;'>SUBTITULO </td>
					<td style='text-align:left;'>".$_POST['titsub']."</td>
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
					<td style='text-align:right;'>DATE MOD </td>
					<td style='text-align:left;'>".$_POST['datemod']."</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>TIME MOD </td>
					<td style='text-align:left;' colspan=2>".$_POST['timemod']."</td>
				</tr>
				
				<tr>
					<th colspan=3>CONTENIDO</th>
				</tr>
				<tr>
					<td style='text-align:left;' colspan=3>".$_POST['conte']."</td>
				</tr>
				<tr>
					<td style='text-align:right;' colspan=3 class='BorderSup'>
						<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
							<input type='submit' value='CERRAR VENTANA' class='botonrojo' />
							<input type='hidden' name='oculto2' value=1 />
						</form>
					</td>
				</tr>
			</table>");
				}// FIN CONDICIONAL SE CUMPLE EL QUERY
				 else {
				print("<font color='#FF0000'>
						* ESTOS DATOS NO SON VALIDOS, MODIFIQUE ESTA ENTRADA: </font>
						</br>&nbsp;&nbsp;&nbsp;".mysqli_error($db))."</br>";
						show_form ();
						
							} // FIN ELSE SI NO SE CUMPLE EL QUERY

	}

//////////////////////////////////////////////////////////////////////////////////////////////

function show_form($errors=[]){
	
	global $db;  	global $db_name;

	global $id; 	$id = $_POST['id'];
	global $img; 	$img = $_POST['myimg'];

	if(isset($_POST['oculto2'])){

		$_SESSION['smyimg'] = $_POST['myimg'];
		$_SESSION['srefart'] = $_POST['refart'];
		$_SESSION['refuser'] = $_POST['refuser'];
	
	if (isset($_POST['dyt1'])){
		$defaults['dyt1'] = @trim($_POST['dyt1']);
	}else{
		$defaults['dyt1'] = @trim($_SESSION['dyt1']);
	}

				$defaults = array ( 'id' => $_POST['id'],
									'dyt1' => $defaults['dyt1'],
									'refuser' => $_SESSION['refuser'],
									'refart' =>  @$_SESSION['refart'],
									'tit' => $_POST['tit'],
								    'titsub' => $_POST['titsub'],
									'datein' => $_POST['datein'],
									'timein' => $_POST['timein'],
									'datemod' => $_POST['datemod'],
									'timemod' => $_POST['timemod'],
									'conte' => $_POST['conte'],
									'myimg' => $img,
									);

	}elseif($_POST['imagenmodif']){

				$defaults = array ( 'id' => $_POST['id'],
									'dyt1' => $_POST['dyt1'],
									'refuser' => $_SESSION['refuser'],
									'refart' =>  @$_SESSION['refart'],
									'tit' => $_POST['tit'],
								    'titsub' => $_POST['titsub'],
									'datein' => $_POST['datein'],
									'timein' => $_POST['timein'],
									'datemod' => $_POST['datemod'],
									'timemod' => $_POST['timemod'],
									'conte' => $_POST['conte'],
									'myimg' => $_POST['myimg'],
									 );
										}
								   
	if ($errors){
		print("	<div  class='errorsimg'>
					<font color='#FF0000'>* SOLUCIONE ESTOS ERRORES</font><br/>");
			
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#FF0000'>**</font>  ".$errors [$a]."<br/>");
			}
		print("</div>
				<div style='clear:both'></div>");
		}
		
	print("<table style=\"margin-top:auto; text-align:left; width:96%; max-width:500px\" >
				<tr>
					<th colspan=2 class='BorderInf'>SELECCIONE UNA NUEVA IMAGEN</th>
				</tr>
				<tr>
					<td class='BorderInf'>
			<img style='width:120px; height:auto;' src='../Img.Art/".$_SESSION['smyimg']."' />
					</td>
					<td class='BorderInf'>
							IMAGEN ACTUAL</br></br>
							REF. ARTICULO ".$_SESSION['srefart']."</br>
							TITULO: ".$_POST['tit'].".
					</td>
				</tr>
				<tr>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'  enctype='multipart/form-data'>
					<td colspan=2 >
		<input type='file' name='myimg' id='myimg' value='".$defaults['myimg']."' class='inputfile custom' />	
		<label for='myimg'><span id='file_name'>SELECCIONE UNA IMAGEN</span></label>
					</td>
				</tr>
				<tr>
					<td colspan=2>
						<input name='id' type='hidden' value='".$defaults['id']."' />
						<input name='dyt1' type='hidden' value='".$defaults['dyt1']."' />
						<input name='refuser' type='hidden' value='".$_SESSION['refuser']."' />
						<input name='refart' type='hidden' value='".@$_SESSION['refart']."' />
						<input name='tit' type='hidden' value='".$defaults['tit']."' />
						<input name='titsub' type='hidden' value='".$defaults['titsub']."' />
						<input name='datein' type='hidden' value='".$defaults['datein']."' />
						<input name='timein' type='hidden' value='".$defaults['timein']."' />
						<input name='datemod' type='hidden' value='".$defaults['datemod']."' />
						<input name='timemod' type='hidden' value='".$defaults['timemod']."' />
						<input name='conte' type='hidden' value='".$defaults['conte']."' />		
						<input name='myimg' type='hidden' value='".$defaults['myimg']."' />
						<input type='submit' value='MODIFICAR IMAGEN' class='botonverde' />
						<input type='hidden' name='imagenmodif' value=1 />
					</td>
		</form>																				
				</tr>
			
				<tr>
					<td class='BorderSup'>
					</td>
					<td align='right' class='BorderSup'>
					</td>
				</tr>
				
				<tr>
					<td class='BorderSup'>
					</td>
					<td align='right' class='BorderSup'>
			<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
											<input type='submit' value='CERRAR VENTANA' class='botonrojo' />
											<input type='hidden' name='oculto2' value=1 />
			</form>
					</td>
				</tr>
			</table>");

	}

/////////////////////////////////////////////////////////////////////////////////////////////////
	
	function master_index(){
		
				require '../Inclu.Menu/Master_Index_Admin.php';
		
				} 

/////////////////////////////////////////////////////////////////////////////////////////////////
/*
function info_02(){

	global $db;
	global $rowout;
	
	global $destination_file;	
	global $rename_filename;

global $nombre;
global $apellido;

	$ActionTime = date('H:i:s');

	$rf = $_POST['ref'];

	global $dir;
	$dir = "../Log";

global $text;
$text = PHP_EOL."- ADMIN MODIFICAR IMG MODIFICADA ".$ActionTime.PHP_EOL."\t ID:".$_POST['id'].PHP_EOL."\t Nombre: ".@$nombre." ".@$apellido.PHP_EOL."\t Ref: ".$rf.PHP_EOL."\t Upload Imagen: ".$destination_file.PHP_EOL."\t Rename Imagen: ".$rename_filename;

	$logdocu = $_SESSION['srefuser'];
	$logdate = date('Y_m_d');
	$logtext = $text.PHP_EOL;
	$filename = $dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $logtext);
	fclose($log);

	}
*/
/////////////////////////////////////////////////////////////////////////////////////////////////

function info_01(){

	global $db;
	global $rowout;
	
	global $nombre;
	global $apellido;
	global $destination_file;	

	$ActionTime = date('H:i:s');

	$rf = $_POST['ref'];
	$nombre = $_POST['Nombre'];
	$apellido = $_POST['Apellidos'];

	global $dir;
	$dir = "../Log";

global $text;
$text = PHP_EOL."- ADMIN MODIFICAR IMG SELECCIONADA ".$ActionTime.PHP_EOL."\t ID:".$_POST['id'].PHP_EOL."\t Nombre: ".$nombre." ".$apellido.PHP_EOL."\t Ref: ".$rf.PHP_EOL."\t Imagen: ".$_POST['myimg'];

	$logdocu = $_SESSION['ref'];
	$logdate = date('Y_m_d');
	$logtext = $text.PHP_EOL;
	$filename = $dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $logtext);
	fclose($log);

	}

/////////////////////////////////////////////////////////////////////////////////////////////////

	require '../Inclu/Admin_Inclu_footer.php';
		
/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>