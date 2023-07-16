<?php
  session_start();

  	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../Inclu/Admin_Inclu_popup.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

  /* Creado por Juan Manuel Barros Pazos 2020/21 */

  ?>

  <!DOCTYPE html>
  <html lang="en">
  
  <head>
  
	<title>Juan Barros Pazos - About</title>

	<?php
	
		require '../Www/Inc_Header_Nav_Head_Popup.php'; 
		/* Creado por Juan Manuel Barros Pazos 2020/21 */

	?>

	<!-- About -->
	<section class="page-section" id="about">
		<div class="container">


	<?php
///////////////////////////////////////////////////////////////////////////////////////

				if($_POST['oculto2']){ process_form();
										//info();
								
				} else { }

//////////////////////////////////////////////////////////////////////////////////////////////

function process_form(){
	
	global $db; 	global $db_name;
	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";

	$sqlx =  "SELECT * FROM $tablename WHERE `ref` = '$_POST[refuser]'";
	$q = mysqli_query($db, $sqlx);
	$rowautor = mysqli_fetch_assoc($q);
	$counta = mysqli_num_rows($q);
	global $_sec;
	if ($counta !== 1) { $_sec = "<h6>AUTOR ANONIMO</h6>";;}
	else {$_sec = "<h6>AUTOR: ".strtoupper($rowautor['Nombre'])." ".strtoupper($rowautor['Apellidos'])."</h6>"; }
	
	// HE DEFINIR EL VIDEO SI EXISTE

	if(strlen(@trim($_POST['myvdo'])) > 0){
		global $visual;
		$visual = "<p><video controls width='90%' height='auto'>
						<source src='../Vdo.Art/".$_POST['myvdo']."' />
					</video></p>";
	} else { global $visual;
			 //$visual = "<img style='width:80%; height:auto;' src='../Img.Art/untitled.png' />";
			 $visual = "";
				}
	/////

	if ($_POST['myurl'] != ""){
		global $myurl;
		$myurl = '<h6 style=\'display:inline-block;\'><a href="'.$_POST['myurl'].'" target="_blanck">LINK EXTERNO</a></h6>'; }
	else { global $myurl; 	$myurl = ""; }
	
	print("<div id=\"Conte\" style=\"border: 2px solid #CCC; border-radius:20px; width:98%; text-align:center; padding: 6px 6px 2px 6px; margin: 6px;\">
		<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
			<h6 style=\"text-align:right;\">
				<input style=\"margin-right:12px;\" type='submit' value='CERRAR VENTANA' class='botonverde' />
			</h6>
		</form>
			".$_sec."<h5>".$_POST['tit']."</h5>
			
			".$visual."
			<p style=\"text-align:left;\">".$_POST['conte']."</p>
			".$myurl."
			<p>
			<img src='../Img.Art/".$_POST['myimg']."' style=\" width:98%; max-width:700px; border-radius: 24px;\" />
			</p>
		<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
			<h6 style=\"text-align:right;\">
				<input style=\"margin-right:12px;\" type='submit' value='CERRAR VENTANA' class='botonverde' />
			</h6>
		</form>
	</div> ");

	global $redir;
	// 1 min  60000 microseg
	// 3 min 180000 microseg
	$redir = "<script type='text/javascript'>
				function redir(){
					window.close();
						}
				setTimeout('redir()',180000);
			</script>";
	print ($redir);

	}
			
/////////////////////////////////////////////////////////////////////////////////////////////////

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

/////////////////////////////////////////////////////////////////////////////////////////////////

	//require '../Inclu/Admin_Inclu_popup_02.php';
		
/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>

	</div> <!-- Fin container -->
		</section>

		<!-- Footer -->
		<footer class="footer" style="padding: 2px !important; margin-top: -10px;">
				<span class="copyright">Copyright &copy; Juan Barros Pazos 2020/23.</span>
		</footer>
		<!-- End Footer -->

			<?php require '../Www/Inc_Jquery_Boots_Foot.php';  ?>

		</body>

		</html>
