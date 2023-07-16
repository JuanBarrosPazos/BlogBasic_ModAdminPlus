<?php
session_start();

?>

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link href="../Img.Sys/favicon.png" type='image/ico' rel='shortcut icon' />

  <link href="../Css/html.css" rel="stylesheet" type="text/css" />
  <link href="../Css/conta.css" rel="stylesheet" type="text/css">

  <!-- Bootstrap core CSS -->
  <link href="../Css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../Css/agency.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="../Css/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">


</head>

<body id="page-top">


<?php

  	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../Inclu/Admin_Inclu_popup.php';
	require '../Inclu/mydni.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if (($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){
				
				if($_POST['oculto2']){ process_form();
										//info();
								} 
								
} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db; 	global $db_name;
	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";

	$sqlx =  "SELECT * FROM $tablename WHERE `ref` = '$_POST[refuser]'";
	$q = mysqli_query($db, $sqlx);
	$rowautor = mysqli_fetch_assoc($q);
	$counta = mysqli_num_rows($q);

	global $_sec;
	if ($counta !== 1) { $_sec = "AUTOR ANONIMO";}
	else { $_sec = $rowautor['Nombre']." ".$rowautor['Apellidos']; }
	
	if(strlen(@trim($_POST['myvdo'])) > 0){
		global $visual;
		$visual = "<video controls width='90%' height='auto'>
						<source src='../Vdo.Art/".$_POST['myvdo']."' />
					</video>";
	} else { global $visual;
			 $visual = "<img style='width:80%; height:auto;' src='../Img.Art/untitled.png' />";
				}

	print("<table style=\"width:96%; max-width:500px\" >
				<tr>
					<th colspan=3  class='BorderInf'>DETALLES DEL ARTICULO</th>
				</tr>
				
				<tr>
					<td style='text-align:right; width:100px;' >ID</td>
					<td style='text-align:left; width:140px;'>".$_POST['id']."</td>
					<td rowspan='5' style=' width:auto;' >
			<img style='width:90%; height:auto;' src='../Img.Art/".$_POST['myimg']."' />
					</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>AUTOR REF</td>
					<td style='text-align:left;'>".$_POST['refuser']."</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>AUTOR NAME</td>
					<td style='text-align:left;'>".$_sec."</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>REFERENCIA</td>
					<td style='text-align:left;'>".$_POST['refart']."</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>TITULO</td>
					<td style='text-align:left;'>".$_POST['tit']."</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>SUBTITULO</td>
					<td style='text-align:left;'>".$_POST['titsub']."</td>
					<td rowspan='5'>".$visual."</td>
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
					<td style='text-align:left;' colspan='2'>".$_POST['timein']."</td>
				</tr>				
				
				<tr>
					<td style='text-align:right;'>DATE MOD</td>
					<td style='text-align:left;' colspan='2'>".$_POST['datemod']."</td>
				</tr>				
				
				<tr>
					<td style='text-align:right;'>TIME MOD</td>
					<td style='text-align:left;' colspan='2'>".$_POST['timemod']."</td>
				</tr>
				
				<tr>
					<td colspan='3'>ARTICULO</td>
				</tr>
				<tr>
					<td colspan='3' style='text-align:left;'>".$_POST['conte']."</td>
				</tr>
				
				<tr>
					<td colspan=3 style='text-align:right;' class='BorderSup'>
				<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
					<input type='submit' value='CERRAR VENTANA' class='botonrojo' />
					<input type='hidden' name='oculto2' value=1 />
				</form>
					</td>
				</tr>
								
			</table>"); 

			}
			
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

	global $db;
	global $rowout;
	global $nombre;
	global $apellido;
		
	$rf = $_POST['ref'];
	$nombre = $_POST['Nombre'];
	$apellido = $_POST['Apellidos'];
		
	$ActionTime = date('H:i:s');
	
	global $dir;
	$dir = "../Log";
	
	global $text;
	$text = PHP_EOL."- ADMIN VER DETALLES ".$ActionTime.PHP_EOL."\t Nombre: ".$nombre." ".$apellido;

	$logdocu = $_SESSION['ref'];
	$logdate = date('Y_m_d');
	$logtext = $text.PHP_EOL;
	$filename = $dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $logtext);
	fclose($log);

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Admin_Inclu_footer.php';
		
/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>
