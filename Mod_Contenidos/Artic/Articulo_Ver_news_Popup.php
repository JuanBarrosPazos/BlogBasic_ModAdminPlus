<?php
	//@session_start();

	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if(isset($_POST['oculto'])){
				if($form_errors = validate_form()){
						show_form($form_errors);
				} else {show_form();
						process_form();
						//info();
							}
			}	

	elseif ((isset($_GET['page'])) || (isset($_POST['page']))) { 
												show_form();
												process_form(); 
											}

	else { 	unset($_SESSION['titulo']);
			unset($_SESSION['autor']);
			unset($_SESSION['dy']);
			unset($_SESSION['dm']);	
			show_form();
			ver_todo();}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	$errors = array();
	
	if (strlen(@trim($_POST['titulo'])) > 0) {
		
		if (!preg_match('/^[^@#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\.\*]+$/',$_POST['titulo'])){
			$errors [] = "<font color='#FF0000'>CARACTERES NO VALIDOS</font>";
			}
		}
	
	return $errors;

		} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	// DEFINO EL NUMERO DE ARTICULOS POR PÁGINA
	global $nitem;
	$nitem = 3;

	require '../Artic/Inc_Artic_News_Pagina_Ini_process.php';
	

	if(!$qb){
			print("<font color='#FF0000'>Consulte L.116: </font></br>".mysqli_error($db)."</br>");
			
		} else {
			if(mysqli_num_rows($qb)== 0){

				require '../Artic/Articulo_no_hay_datos.php';

	} else {print ("<div class='row'> <!-- Titulo -->
						<div class='col-lg-12 text-center'>
							<h2 class='section-heading text-uppercase'>Noticias</h2>
						</div>
				  	</div>
					
			<div class='row'> <!-- Inicio class row-->
			<div class='col-lg-12'>  <!-- Inicio class col-lg-12 -->
			<ul class='timeline'> <!-- Inicio Ul class timeline -->");
			
			global $estilo;
			$estilo = array('timeline','timeline-inverted');
			global $estiloin;
			$estiloin = 0;
	
		while($rowb = mysqli_fetch_assoc($qb)){

	// DEFINO LA RECTIFICACIÓN DE LA RUTA IMG
    global $rut;
    //$rut = "";
    $rut = "../";

	if ($page > 1){
		global $pg;
		$pg = "<input type='hidden' name='page' value=".$page." />";
	}else{	global $pg;
			$pg = "<input type='hidden' name='page' value=1 />";
			}

	global $db;
	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";

	$sqlra =  "SELECT * FROM $tablename WHERE `ref`='$rowb[refuser]' LIMIT 1 ";
	$qra = mysqli_query($db, $sqlra);
	
	if(!$qra){ print("* ".mysqli_error($db)."</br>");
	} else { 
			while($rowautor = mysqli_fetch_assoc($qra)){
				global $autor;
				$autor = "<h6>".$rowautor['Nombre']." ".$rowautor['Apellidos']."</h6>";
				}
			}

	if ($rowb['myvdo'] != ''){
		global $vdonw;
		$vdonw = "<video style=\" width:98%; max-width:600px !important; height:auto\" controls>
			<source style=\" width:98%; height:auto\" src='../Vdo.Art/".@$_POST['myvdo']."' />
				  </video>";
		}else{	global $vdonw;
				$vdonw = '';
				}
	
	global $conte;
	$conte = substr($rowb['conte'],0,100);
	$conte = $conte." ...&nbsp;
        <form name='ver' method='POST' action='../Artic/Articulo_Ver_index_Popup_Ver.php' target='popup' onsubmit=\"window.open('', 'popup', 'width=500px, height=650px')\">
				<input type='hidden' name='id' value='".$rowb['id']."' />
				<input type='hidden' name='refuser' value='".$rowb['refuser']."' />
				<input type='hidden' name='refart' value='".$rowb['refart']."' />
				<input type='hidden' name='tit' value='".$rowb['tit']."' />
				<input type='hidden' name='titsub' value='".$rowb['titsub']."' />
				<input type='hidden' name='datein' value='".$rowb['datein']."' />
				<input type='hidden' name='timein' value='".$rowb['timein']."' />
				<input type='hidden' name='datemod' value='".$rowb['datemod']."' />
				<input type='hidden' name='timemod' value='".$rowb['timemod']."' />
				<input type='hidden' name='conte' value='".$rowb['conte']."' />
				<input type='hidden' name='myimg' value='".$rowb['myimg']."' />
				<input type='hidden' name='myvdo' value='".$rowb['myvdo']."' />
				<input type='hidden' name='myurl' value='".$rowb['myurl']."' />
				<input type='submit' value='LEER MÁS...' class='botonleer' />
				<input type='hidden' name='oculto2' value=1 />
				".$pg."
			</form>";

	require 'url_logica.php';

	print ("<li  class='".$estilo[$estiloin]."'> <!-- Inicio Li contenedor -->
			<div class='timeline-image'>
	<img class='<!--rounded-circle--> img-fluid' src='../Img.Art/".$rowb['myimg']."' alt=''>
			</div>
			<div class='timeline-panel'>
			<div class='timeline-heading'>
				<h6>".$rowb['datein']."</h6>
				<h5>".$rowb['tit']."</h5>
			</div>
			<div class='timeline-body'>
				".$myurl."<p class='text-muted'>".$conte."</p>
			</div>
		<div id=\"".$rowb['refart']."\"></div>
			</div>
		</li> <!-- Final Li contenedor -->
		");
		$estiloin = 1 - $estiloin;	

		} // Fin While

	print(" </ul> <!-- Fin Ul class timeline -->
			</div> <!-- Fin class col-lg-12 -->
  			</div> <!-- Fin class row-->
			");
				} 

	require '../Artic/Inc_Artic_News_Pagina_Fin_process.php';

			} 
		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){

	// FORMULARIO FILTRO ARTICULOS AUTOR
	require '../Artic/Articulo_Ver_news_showform.php';
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	// DEFINO EL NUMERO DE ARTICULOS POR PÁGINA
	global $nitem;
	$nitem = 3;

	require '../Artic/Inc_Artic_News_Pagina_Ini_todo.php';


	$qb = mysqli_query($db, $sqlb);
	if(!$qb){
		print("</br><font color='#FF0000'>Consulte L.200 Artic/Articulo_Ver_news_Popup.php: </font></br>".mysqli_error($db)."</br>");
			
		} else {
			if(mysqli_num_rows($qb)== 0){

		require '../Artic/Articulo_no_hay_datos.php';

	} else {print ("<div class='row'> <!-- Titulo -->
						<div class='col-lg-12 text-center'>
							<h2 class='section-heading text-uppercase'>Noticias</h2>
						</div>
				  	</div>
					
			<div class='row'> <!-- Inicio class row-->
			<div class='col-lg-12'>  <!-- Inicio class col-lg-12 -->
			<ul class='timeline'> <!-- Inicio Ul class timeline -->");
			
				global $estilo;
				$estilo = array('timeline','timeline-inverted');
				global $estiloin;
				$estiloin = 0;

		while($rowb = mysqli_fetch_assoc($qb)){

	// DEFINO LA RECTIFICACIÓN DE LA RUTA IMG
    global $rut;
    //$rut = "";
    $rut = "../";

	if ($page > 1){
		global $pg;
		$pg = "<input type='hidden' name='page' value=".$page." />";
	}else{	global $pg;
			$pg = "<input type='hidden' name='page' value=1 />";
			}

	global $db;
	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";

	$sqlra =  "SELECT * FROM $tablename WHERE `ref`='$rowb[refuser]' LIMIT 1 ";
	$qra = mysqli_query($db, $sqlra);
	
	if(!$qra){ print("* ".mysqli_error($db)."</br>");
	} else { 
			while($rowautor = mysqli_fetch_assoc($qra)){
				global $autor;
				$autor = "<h6>".$rowautor['Nombre']." ".$rowautor['Apellidos']."</h6>";
				}
			}

	if ($rowb['myvdo'] != ''){
		global $vdonw;
		$vdonw = "<video style=\" width:98%; max-width:600px !important; height:auto\" controls>
			<source style=\" width:98%; height:auto\" src='../Vdo.Art/".@$_POST['myvdo']."' />
				  </video>";
		}else{	global $vdonw;
				$vdonw = '';
				}
	
	global $conte;
	$conte = substr($rowb['conte'],0,100);
	$conte = $conte." ...&nbsp;
	<form name='ver' method='POST' action='../Artic/Articulo_Ver_index_Popup_Ver.php' target='popup' onsubmit=\"window.open('', 'popup', 'width=500px, height=650px')\">
				<input type='hidden' name='id' value='".$rowb['id']."' />
				<input type='hidden' name='refuser' value='".$rowb['refuser']."' />
				<input type='hidden' name='refart' value='".$rowb['refart']."' />
				<input type='hidden' name='tit' value='".$rowb['tit']."' />
				<input type='hidden' name='titsub' value='".$rowb['titsub']."' />
				<input type='hidden' name='datein' value='".$rowb['datein']."' />
				<input type='hidden' name='timein' value='".$rowb['timein']."' />
				<input type='hidden' name='datemod' value='".$rowb['datemod']."' />
				<input type='hidden' name='timemod' value='".$rowb['timemod']."' />
				<input type='hidden' name='conte' value='".$rowb['conte']."' />
				<input type='hidden' name='myimg' value='".$rowb['myimg']."' />
				<input type='hidden' name='myvdo' value='".$rowb['myvdo']."' />
				<input type='hidden' name='myurl' value='".$rowb['myurl']."' />
				<input type='submit' value='LEER MÁS...' class='botonleer' />
				<input type='hidden' name='oculto2' value=1 />
				".$pg."
			</form>";

	require 'url_logica.php';

	print ("<li  class='".$estilo[$estiloin]."'> <!-- Inicio Li contenedor -->
			<div class='timeline-image'>
	<img class='<!--rounded-circle--> img-fluid' src='../Img.Art/".$rowb['myimg']."' alt=''>
			</div>
			<div class='timeline-panel'>
			<div class='timeline-heading'>
				<h6>".$rowb['datein']."</h6>
				<h5>".$rowb['tit']."</h5>
			</div>
			<div class='timeline-body'>
				".$myurl."<p class='text-muted'>".$conte."</p>
			</div>
		<div id=\"".$rowb['refart']."\"></div>
			</div>
		</li> <!-- Final Li contenedor -->
		");

		$estiloin = 1 - $estiloin;	

		} // Fin While

	print(" </ul> <!-- Fin Ul class timeline -->
			</div> <!-- Fin class col-lg-12 -->
  			</div> <!-- Fin class row-->
			");
						} 

	require '../Artic/Inc_Artic_News_Pagina_Fin_todo.php';

			} 
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

	global $db;
	global $rowout;
	global $nombre;
	global $apellido;
	global $orden;
	
	$orden = isset($_POST['Orden']);
	
	if (isset($_POST['todo'])){$nombre = "TODOS LOS USUARIOS ".$orden;};	

	$rf = isset($_POST['ref']);
	if (($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){	
										$nombre = $_SESSION['Nombre'];
										$apellido = $_SESSION['Apellidos'];}
	
	$ActionTime = date('H:i:s');

	global $dir;
	$dir = "../Log";
	
	global $text;
	$text = PHP_EOL."- ADMIN VER ".$ActionTime.PHP_EOL."\t Filtro => ".$nombre." ".$apellido;

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

	//require '../Inclu/Admin_Inclu_footer.php';
		
/* Creado por Juan Manuel Barros Pazos 2020/21 */
