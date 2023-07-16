<?php

  	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../Inclu/Admin_Inclu_Head_b.php';

	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if(isset($_POST['inscancel'])){	
		config_one();
		print("<table align='center' style=\"margin-top:12px;\">
					<tr>
						<td>
							<a href='../index.php'>ACCEDA AL SISTEMA</a>
						</td>
					</tr>
				</table>");
				}

	elseif(isset($_POST['oculto'])){
		if($form_errors = validate_form()){
				show_form($form_errors);
								} else {process_form();
										config_one();
													}
	} else {show_form();}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function config_one(){
	
	if(file_exists('../index.php')){unlink("../index.php");
					$data1 = PHP_EOL."\t UNLINK ../index.php";}
			else {print("DON`T UNLINK ../index.php </br>");
					$data1 = PHP_EOL."\t DON`T UNLINK ../index.php";}

	if(!file_exists('../index.php')){
			if(file_exists('index_Play_System.php')){
				copy("index_Play_System.php", "../index_Play_System.php");
				$data2 = PHP_EOL."\t COPY ../index_Play_System.php";
				} else {print("DON`T COPY index_Play_System.php </br>");
						$data2 = PHP_EOL."\t DON`T COPY index_Play_System.php";}
			} 

	if(file_exists('../index_Play_System.php')){
				rename("../index_Play_System.php", "../index.php");
				$data3 = PHP_EOL."\t RENAME ../index_Play_System.php TO ../index.php";
			} else {print("DON`T RENAME ../index_Play_System.php TO ../index.php </br>");
				$data3 = PHP_EOL."\t DON`T RENAME ../index_Play_System.php TO ../index.php";}
	
	global $cfone;
	$cfone = PHP_EOL."SUSTITUCION DE ARCHIVOS:".$data1.$data2.$data3;
	
	}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	require 'validate.php';	
		
	return $errors;

		} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;
	global $db_name;
	
/*	REFERENCIA DE USUARIO	*/

global $rf1;	global $rf2;	global $rf3; 	global $rf4;

if (preg_match('/^(\w{1})/',$_POST['Nombre'],$ref1)){	$rf1 = $ref1[1];
														$rf1 = @trim($rf1);
														/*print($ref1[1]."</br>");*/
														}
if (preg_match('/^(\w{1})*(\s\w{1})/',$_POST['Nombre'],$ref2)){	$rf2 = $ref2[2];
																$rf2 = @trim($rf2);
														/*print($ref2[2]."</br>");*/
														}
if (preg_match('/^(\w{1})/',$_POST['Apellidos'],$ref3)){	$rf3 = $ref3[1];
															$rf3 = @trim($rf3);
														/*print($ref3[1]."</br>");*/
														}
if (preg_match('/^(\w{1})*(\s\w{1})/',$_POST['Apellidos'],$ref4)){	$rf4 = $ref4[2];
																	$rf4 = @trim($rf4);
														/*print($ref4[2]."</br>");*/
														}

	global $rf;
	$rf = $rf1.$rf2.$rf3.$rf4.$_POST['dni'].$_POST['ldni'];
	$rf = @trim($rf);
	$rf = strtolower($rf);

	$_SESSION['iniref'] = $rf;

	/**************************************/
	
	global $vni;
	
	$trf = $_SESSION['iniref'];
	
	global $carpetaimg;
	$carpetaimg = "../Img.User";

	if($_FILES['myimg']['size'] == 0){
			$nombre = $carpetaimg."/untitled.png";
			global $new_name;
			$new_name = $rf.".png";
			$rename_filename = $carpetaimg."/".$new_name;							
			copy("untitled.png", $rename_filename);
												}
												
	else{	$safe_filename = @trim(str_replace('/', '', $_FILES['myimg']['name']));
			$safe_filename = @trim(str_replace('..', '', $safe_filename));

		 	$nombre = $_FILES['myimg']['name'];
		  	$nombre_tmp = $_FILES['myimg']['tmp_name'];
		  	$tipo = $_FILES['myimg']['type'];
		  	$tamano = $_FILES['myimg']['size'];
		  
			$destination_file = $carpetaimg.'/'.$safe_filename;

	 if( file_exists( $carpetaimg.'/'.$nombre) ){
			unlink($carpetaimg."/".$nombre);
		//	print("* El archivo ".$nombre." ya existe, seleccione otra imagen.</br>");
												}
			
	elseif (move_uploaded_file($_FILES['myimg']['tmp_name'], $destination_file)){
			
			// Renombrar el archivo:
			$extension = substr($_FILES['myimg']['name'],-3);
			// print($extension);
			// $extension = end(explode('.', $_FILES['myimg']['name']) );
			global $new_name;
			$new_name = $rf.".".$extension;
			$rename_filename = $carpetaimg."/".$new_name;								
			rename($destination_file, $rename_filename);

			// print("El archivo se ha guardado en: ".$destination_file);
	
			}
			
		else {print("NO SE HA PODIDO GUARDAR EN ".$destination_file);}
		
		}

	global $nombre;
	global $apellido;

	$nombre = $_POST['Nombre'];
	$apellido = $_POST['Apellidos'];

	global $password;
	$password = $_POST['Password'] ;
	global $passwordhash;
	$passwordhash = password_hash($password, PASSWORD_DEFAULT, array ( "cost"=>10));

	global $db_name;
	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";

	$sql = "INSERT INTO `$db_name`.$tablename (`ref`, `Nivel`, `Nombre`, `Apellidos`, `myimg`, `doc`, `dni`, `ldni`, `Email`, `Usuario`, `Password`, `Pass`, `Direccion`, `Tlf1`, `Tlf2`) VALUES ('$rf', '$_POST[Nivel]', '$_POST[Nombre]', '$_POST[Apellidos]', '$new_name', '$_POST[doc]', '$_POST[dni]', '$_POST[ldni]', '$_POST[Email]', '$_POST[Usuario]', '$passwordhash', '$password', '$_POST[Direccion]', '$_POST[Tlf1]', '$_POST[Tlf2]')";
		
	if(mysqli_query($db, $sql)){	// CREA EL ARCHIVO MYDNI.TXT $_SESSION['mydni'].
									$filename = "../Inclu/mydni.php";
									$fw2 = fopen($filename, 'w+');
									$mydni = '<?php $_SESSION[\'mydni\'] = '.$_POST['dni'].'; ?>';
									fwrite($fw2, $mydni);
									fclose($fw2);	

	print( "<table align='center' style='margin-top:10px'>
				<tr>
					<th colspan=3 class='BorderInf'>
						SE HA REGISTRADO COMO ADMINISTRADOR.
					</th>
				</tr>");
								
		global $rutaimg;
		$rutaimg = "src='".$carpetaimg."/".$new_name."'";
		require '../Docs/table_data_resum.php';
	
	print("	<tr>
				<td colspan=3 align='right' class='BorderSup'>
					<a href=\"../../Mod_Admin_Plus/index.php\">
							ADMINISTRADOR ACCESO A INICIO DEL SISTEMA 
					</a>
				</td>
			</tr>
		</table>");

global $cfone;
$datein = date('Y-m-d/H:i:s');
$logdate = date('Y_m_d');
$logtext = $cfone."\n - CREADO USER ADMIN 1. ".$datein.". User Ref: ".$rf.".\n \t Name: ".$_POST['Nombre']." ".$_POST['Apellidos'].". \n \t User: ".$_POST['Usuario'].".\n \t Pass: ".$_POST['Password'].".\n";
$filename = "../Log/".$logdate."_PRIMER_ADMIN.log";
$log = fopen($filename, 'ab+');
fwrite($log, $logtext);
fclose($log);

	} else {	print("</br>
				<font color='#FF0000'>
			* Estos datos no son validos, modifique esta entrada: </font></br> ".mysqli_error($db))."
				</br>";
				show_form ();
				
					}
		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	if(isset($_POST['oculto'])){
		$defaults = $_POST;
		} else {$defaults = array ( 'Nombre' => '',
									'Apellidos' => '',
									'myimg' => isset($_POST['myimg']),	
									'Nivel' => '',
									'ref' => '',
									'doc' => '',
									'dni' => '',
									'ldni' => '',
									'Email' => '',
									'Usuario' => '',
									'Usuario2' => '',
									'Password' => '',
									'Password2' => '',
									'Direccion' => '',
									'Tlf1' => '',
									'Tlf2' => '');
								   }
	
	
	if ($errors){
		print("<table align='center'>
					<th style='text-align:center'>
					<font color='#FF0000'>* SOLUCIONE ESTOS ERRORES:</font><br/>
					</th>
					<tr>
					<td style='text-align:left'>");
			
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#FF0000'>**</font>  ".$errors [$a]."<br/>");
			}
		print("</td>
				</tr>
				</table>");
				}
		
	$Nivel = array ('' => 'NIVEL USUARIO',
					'admin' => 'WEB MASTER',);														

	$doctype = array (	'DNI' => 'DNI/NIF Espa&ntilde;oles',
						'NIE' => 'NIE/NIF Extranjeros',
						'NIFespecial' => 'NIF Persona F&iacute;sica Especial',
					  /*
						'NIFsa' => 'NIF Sociedad An&oacute;nima',
						'NIFsrl' => 'NIF Sociedad Responsabilidad Limitada',
						'NIFscol' => 'NIF Sociedad Colectiva',
						'NIFscom' => 'NIF Sociedad Comanditaria',
						'NIFcbhy' => 'NIF Comunidad Bienes y Herencias Yacentes',
						'NIFscoop' => 'NIF Sociedades Cooperativas',
						'NIFasoc' => 'NIF Asociaciones',
						'NIFcpph' => 'NIF Comunidad Propietarios Propiedad Horizontal',
						'NIFsccspj' => 'NIF Sociedad Civil, con o sin Personalidad Juridica',
						'NIFee' => 'NIF Entidad Extranjera',
						'NIFcl' => 'NIF Corporaciones Locales',
						'NIFop' => 'NIF Organismo Publico',
						'NIFcir' => 'NIF Congragaciones Instituciones Religiosas',
						'NIFoaeca' => 'NIF Organos Admin Estado y Comunidades Autonomas',
						'NIFute' => 'NIF Uniones Temporales de Empresas',
						'NIFotnd' => 'NIF Otros Tipos no Definidos',
						'NIFepenr' => 'NIF Establecimientos Permanentes Entidades no Residentes',
						*/
										);
	
	/*******************************/
		
		global $config2;
		$config2 = 1;
		global $imgform;
		$imgform = "config2";
		require '../Docs/table_crea_admin.php';
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
				require '../Inclu.Menu/Master_Index_Admin.php';
		
				} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Admin_Inclu_footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
		
/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>