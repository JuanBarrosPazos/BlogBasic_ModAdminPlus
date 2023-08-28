<?php
session_start();

  	require '../../Mod_Admin/Inclu/error_hidden.php';
	require '../../Mod_Admin/Inclu/my_bbdd_clave.php';

	require '../Inclu/Admin_Inclu_Head_b.php';
	require '../Inclu/mydni.php';

	require '../../Mod_Admin/Conections/conection.php';
	require '../../Mod_Admin/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if (($_SESSION['Nivel'] == 'admin') || ($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){ 

	master_index();

		if(isset($_POST['visiblesi'])){	
			visiblesi();
		}elseif(isset($_POST['visibleno'])){ 
			visibleno();
		}elseif(isset($_POST['todo'])){ 
			show_form();							
			ver_todo();
			//info();
		}elseif(isset($_POST['oculto'])){

			if($form_errors = validate_form()){
							  show_form($form_errors);
			} else { process_form();
					 //info();
				}
		}else { 
			show_form();
			ver_todoIni(); 
			}

	} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function validate_form(){
	
	require 'Inc_Show_Form_01_Val.php';

	return $errors;

		} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function process_form(){

	$_SESSION['vt'] = "";

	global $db; 	global $db_name;
	
	show_form();
		
	global $autor; 		$autor = @trim($_POST['autor']);
	global $visible;
	if(isset($_POST['visible'])){
	 	$visible = $_POST['visible'];
	}else{ $visible = "y"; }
	
	global $titulo;
	$titulo = @trim($_POST['titulo']);
	//$titulo = utf8_decode($titulo);
	$titulo = "%".$titulo."%";
	
	global $orden;
	if((isset($_POST['Orden']))&&($_POST['Orden']|= '')){
		$orden = $_POST['Orden'];
	}else { $orden = '`id` ASC'; }

	global $dyt1; 	global $dm1;
	//global $dd1;

	if ($_POST['dy'] == ''){ $dy1 = date('Y');
							 $dyt1 = $dy1;
	}elseif((isset($_POST['visiblesi']))||(isset($_POST['visibleno']))||($_POST['oculto'])){ 
												$dy1 = $_POST['dy'];
												$dyt1 = $_POST['dy'];
	}else{  $dy1 = "20".$_POST['dy'];
			$dyt1 = "20".$_POST['dy'];}

	if ($_POST['dm'] == ''){ $dm1 = '';
							 global $fil; 	 $fil = $dy1."-%";
	}else{	$dm1 = "-".$_POST['dm']."-";
			global $fil; 	$fil = $dy1.$dm1."%";
		}

	$_SESSION['dyt1'] = $dyt1;
	/*
	echo "* ".$_SESSION['dyt1']."<br>";
	echo "* ".$_POST['dy']."<br>";
	echo "* ".$fil."<br>";
	*/

global $refrescaimg;
$refrescaimg = "<form name='refresimg' action='$_SERVER[PHP_SELF]' method='POST' style='margin-top: 4px;'>
					<input type='hidden' name='autor' value='".@$_POST['autor']."' />
					<input type='hidden' name='titulo' value='".@$_POST['titulo']."' />
					<input type='hidden' name='Orden' value='".@$_POST['Orden']."' />
					<input type='hidden' name='dy' value='".@$_POST['dy']."' />
					<input type='hidden' name='dm' value='".@$_POST['dm']."' />
					<input type='hidden' name='dd' value='".@$_POST['dd']."' />
					<input type='submit' value='REFRESCAR DESPUES DE MODIFICAR DATOS' class='botonazul' />
					<input type='hidden' name='oculto' value=1 />
				</form><hr>";

	global $fil;
	$fil = $dy1.$dm1."%";
	//$fil = $dy1."-%".$dm1."%";
	global $vname;	$vname = "`".$_SESSION['clave'].$dyt1."articulos`";

	$sqlc =  "SELECT * FROM `$db_name`.$vname WHERE 1 ";

	if (strlen(@trim($_POST['autor'])) == 0){ 
		$sqlc .=  "";
	}else{
		$sqlc .=  " AND `refuser` = '$autor'";
	}

	if (strlen(@trim($_POST['titulo'])) == 0){ 
		$sqlc .=  "";
	}else{
		$sqlc .=  " AND `tit` LIKE '$titulo'";
	}

	if (strlen(@trim($_POST['visible'])) == 0){ 
		$sqlc .=  "";
	}else{
		$sqlc .=  " AND `visible` = '$visible'";
	}

	$sqlc .= " AND `datein` LIKE '$fil' ";
	$sqlc .= " ORDER BY $orden ";

	//echo $sqlc."<br>";

	$qc = mysqli_query($db, $sqlc);

	if(!$qc){
			print("<font color='#FF0000'>Consulte L.122: </font></br>".mysqli_error($db)."</br>");
			
	} else {
			if(mysqli_num_rows($qc)== 0){

				require '../Artic/Articulo_no_hay_datos_index.php';

		} else { 

	print ("<div class=\"juancentra\" style=\"vertical-align:top !important; margin-top:6px; padding-top:8px; \">
					Nº Articulos: ".mysqli_num_rows($qc)." YEAR ".$dyt1.$refrescaimg);
				
			while($rowb = mysqli_fetch_assoc($qc)){
				
			require 'Inc_Artic_While_Total.php';

		} // FIN WHILE

		print("</div>");
			
						} // HAY DATOS
			}  // SE CUMPLE EL QUERY

	} // FIN FUNCTION process_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	global $titulo; 	$titulo = "CONSULTAR ARTICULOS";

	require 'Inc_Show_Form_01.php';
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function visibleno(){

		/* GRABAMOS LOS DATOS EN LA TABLA DE ARTICULOS DE ESTE AÑO */

	global $db; 		global $db_name;
	global $dyt1; 		$dyt1 = @trim($_SESSION['dyt1']);
	
	global $tablename;	$tablename = "`".$_SESSION['clave'].$dyt1."articulos`";
 
	$sqla = "UPDATE `$db_name`.$tablename SET `visible` = 'n' WHERE $tablename.`refart` = '$_POST[refart]' LIMIT 1 ";

	if(mysqli_query($db, $sqla)){ if ($_SESSION['vt'] == "vt"){ show_form();
																ver_todo();}
								  else {process_form();}
								  
					//echo "* ARTICULO:".$_POST['refart']." - ".$tablename;
	} else { print("<h5>* MODIFIQUE LA ENTRADA L.147: ".mysqli_error($db)."</h5>");
						if ($_SESSION['vt'] == "vt"){ show_form();
													  ver_todo();}
						else {process_form();}	
					}

	}  // FIN FUNCTION visible();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function visiblesi(){

		/* GRABAMOS LOS DATOS EN LA TABLA DE ARTICULOS DE ESTE AÑO */

	global $db; 		global $db_name;
	global $dyt1; 		$dyt1 = @trim($_SESSION['dyt1']);
	global $tablename;	$tablename = "`".$_SESSION['clave'].$dyt1."articulos`";

	$sqla = "UPDATE `$db_name`.$tablename SET `visible` = 'y' WHERE $tablename.`refart` = '$_POST[refart]' LIMIT 1 ";

	if(mysqli_query($db, $sqla)){ if ($_SESSION['vt'] == "vt"){ show_form();
																ver_todo();}
								  else {process_form();}
								  
					//echo "<br>** ARTICULO:".$_POST['refart']." - ".$tablename;

	} else { print("<h5>* MODIFIQUE LA ENTRADA L.147: ".mysqli_error($db)."</h5>");
						if ($_SESSION['vt'] == "vt"){ show_form();
													  ver_todo();}
						else {process_form();}	
					//echo "<br>** ARTICULO:".$_POST['refart']." - ".$tablename;
					}

	}  // FIN FUNCTION visible();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	$_SESSION['vt'] = "vt";

	global $db; 	global $db_name;

	global $orden;
	if((isset($_POST['Orden']))&&($_POST['Orden']|= '')){
		$orden = $_POST['Orden'];
	}else { $orden = '`id` ASC'; }
	
	global $dyt1; 	global $dm1; 	global $dd1;
	
	if ($_POST['dy'] == ''){ $dy1 = date('Y');
							 $dyt1 = date('Y');}
		elseif ((isset($_POST['visiblesi']))||(isset($_POST['visibleno']))||(isset($_POST['todo']))){
													$dy1 = $_POST['dy'];
													$dyt1 = $_POST['dy'];
		} else { $dy1 = "20".$_POST['dy'];
				 $dyt1 = "20".$_POST['dy'];
					}

	if ($_POST['dm'] == ''){ $dm1 = '';} 
				else {	$dm1 = "-".$_POST['dm']."-"; }

	if ($_POST['dd'] == ''){ $dd1 = '';} else {	$dd1 = $_POST['dd']; }
	
	/**/
	if (($_POST['dm'] == '')&&($_POST['dd'] != '')){
			//$dm1 = date('m');
			$dm1 = '';
			$dd1 = $_POST['dd'];
			global $fil; 		$fil = $dy1."-%".$dm1."%-".$dd1."%";
		}else{ global $fil;		$fil = $dy1.$dm1.$dd1."%"; }

	$_SESSION['dyt1'] = $dyt1;

	/*
	echo "****** ".$_SESSION['dyt1'];
	echo "****** ".$_POST['dy'];
	global $d;
    $d = substr($dyt1, 2, 4);
	echo "* d: ".$d."<br>";
	echo "* dyt1: ".$dyt1."<br>";
	echo "* FILL: ".$fil."<br>";
	*/

global $refrescaimg;
$refrescaimg = "<form name='refresimg' action='$_SERVER[PHP_SELF]' method='POST' style='margin-top: 4px;'>
					<input type='hidden' name='autor' value='".@$_POST['autor']."' />
					<input type='hidden' name='Orden' value='".@$_POST['Orden']."' />
					<input type='hidden' name='dy' value='".@$_POST['dy']."' />
					<input type='hidden' name='dm' value='".@$_POST['dm']."' />
					<input type='hidden' name='dd' value='".@$_POST['dd']."' />
					<input type='submit' value='REFRESCAR DESPUES DE MODIFICAR DATOS' class='botonazul' />
					<input type='hidden' name='todo' value=1 />
				</form><hr>";
	
	global $vname;	$vname = "`".$_SESSION['clave'].$dyt1."articulos`";

	$sqlb =  "SELECT * FROM `$db_name`.$vname WHERE `datein` LIKE '$fil'  ORDER BY $orden  ";

	/*
	global $tablename;	$tablename = "`".$_SESSION['clave'].$dyt1."admin`";
	$sqlb =  "SELECT * FROM $tablename WHERE $tablename.`dni` <> '$_SESSION[mydni]' ORDER BY $orden ";
	*/
	$qb = mysqli_query($db, $sqlb);
	if(!$qb){
			print("<font color='#FF0000'>Consulte L.271: </font></br>".mysqli_error($db)."</br>");
			echo "<br>* VNAME: ".$vname."<br>* FIL: ".$fil;
		} else {
			if(mysqli_num_rows($qb)== 0){

				require '../Artic/Articulo_no_hay_datos_index.php';

		} else { 

	print ("<div class=\"juancentra\" style=\"vertical-align:top !important; margin-top:6px; padding-top:8px; \">
				Nº Articulos: ".mysqli_num_rows($qb)." YEAR ".$dyt1.$refrescaimg);

			while($rowb = mysqli_fetch_assoc($qb)){
				
				require 'Inc_Artic_While_Total.php';

			} // FIN WHILE

	print("</div>");
			} 

		} 
	} // FIN FUNCTION

					   ////////////////////				   ////////////////////
	////////////////////				////////////////////				////////////////////
					 ////////////////////				  ///////////////////

	function ver_todoIni(){
		
		global $db; 	global $db_name; 	global $vname;
		/* 	$vname = "gcb_".date('Y')."_articulos"; */
		/* MODIFICADA PARA DESARROLLO */
		$vname = "`".$_SESSION['clave'].date('Y')."articulos"."`";
		
		$_SESSION['dyt1'] = date('Y');

		$result =  "SELECT * FROM $vname WHERE `visible` = 'y' ";
		$q = mysqli_query($db, $result);
		global $row; 				@$row = mysqli_fetch_assoc($q);
		global $num_total_rows; 	@$num_total_rows = mysqli_num_rows($q);
	
		if(!$q || ($num_total_rows < 1)){
			echo "<div class='juancentra' style=\"margin-bottom:0.4em !important;\"><h5>** NO HAY DATOS EN ".$_SESSION['dyt1']." **</h5></div>";
		} else { }
	
		// DEFINO EL NUMERO DE ARTICULOS POR PÁGINA
		global $nitem; 	$nitem = 4;
		
		global $page;
	
		//examino la pagina a mostrar y el inicio del registro a mostrar
		if (isset($_GET["page"])) {
			global $page; 	$page = $_GET["page"];
		}
	
		if (!$page) {
			global $page; 	$start = 0; 	$page = 1;
		} else {
			$start = ($page - 1) * $nitem;
		}
		
		//calculo el total de paginas
		$total_pages = ceil($num_total_rows / $nitem);
		
		//pongo el numero de registros total, el tamaño de pagina y la pagina que se muestra
		echo '<div style="clear:both"></div>';
		echo '<h7 class="textpaginacion">* ARTICULOS: '.$num_total_rows.' * P&aacute;gina '.$page.' de ' .$total_pages.'.</h7>';
	
		global $limit;
		$limit = " LIMIT ".$start.", ".$nitem;
	
		$sqlb =  "SELECT * FROM `$db_name`.$vname WHERE `visible` = 'y' ORDER BY `refart` ASC $limit";
	
		if(isset($_POST['ocultoc'])){
	
		$defaults['Nombre'] = $_POST['Nombre'];
		$defaults['Apellidos'] = $_POST['Apellidos'];
	
		global $refrescaimg;
		$refrescaimg = "<form name='refresimg' action='$_SERVER[PHP_SELF]' method='POST' style='margin-top: 4px;'>
				<input type='hidden' name='Nombre' value='".@$defaults['Nombre']."' />
				<input type='hidden' name='Apellidos' value='".@$defaults['Apellidos']."' />
				<input type='submit' value='REFRESCAR DESPUES DE MODIFICAR DATOS' class='botonazul' />
				<input type='hidden' name='ocultoc' value=1 />
						</form>";
		} else { global $refrescaimg;
				 $refrescaimg = "<form name='refresimg' action='$_SERVER[PHP_SELF]' style='margin-top: 4px;'>
			<input type='submit' value='REFRESCAR DESPUES DE MODIFICAR DATOS' class='botonazul' />
			<input type='hidden' name='page' value=".$page." />
						</form>";
				}
		/*
		$sqlb =  "SELECT * FROM `gcb_admin` WHERE `gcb_admin`.`dni` <> '$_SESSION[mydni]' ORDER BY $orden ";
		*/
		$qb = mysqli_query($db, $sqlb);
		if(!$qb){
				print("<font color='#FF0000'>Consulte L.587: </font></br>".mysqli_error($db)."</br>");
				
			} else {
				if(mysqli_num_rows($qb)== 0){
					echo "<div class='juancentra' style=\"margin-bottom:0.4em !important;\"><h5>** NO HAY DATOS EN ".$_SESSION['dyt1']." **</h5></div>";
				} else { 
						
		print ("<div class=\"juancentra\" style='vertical-align:top !important; margin-top:6px; padding-top:8px;'>
				Nº Articulos: ".mysqli_num_rows($qb)." YEAR ".$_SESSION['dyt1'].$refrescaimg."<hr>");
				
			while($rowb = mysqli_fetch_assoc($qb)){
	
				global $rectifurl; 		$rectifurl = 1; 	
					
				require '../Artic/Inc_Artic_While_Total.php';
	
				} // FIN WHILE

				print("</div>");
			} 
		} 
	
		if ($total_pages > 1) {
	
			echo "<div class='centradivpage'>";
	
			if ($page != 1) {
				echo '<div class="paginacion">
						<a href="Articulo_Gestionar.php?page='.($page-1).'">
							<span aria-hidden="true">&laquo;</span>
						</a>
					</div>';
			}
	
			for ($i=1;$i<=$total_pages;$i++) {
				if ($page == $i) {
					echo '<div class="paginacionb">
							<a href="#">'.$page.'</a>
						</div>';
				} else {
					echo '<div class="paginacion">
							<a href="Articulo_Gestionar.php?page='.$i.'">'.$i.'</a>
						</div>';
				}
			}
	
			if ($page != $total_pages) {
				echo '<div class="paginacion">
						<a href="Articulo_Gestionar.php?page='.($page+1).'">
							<span aria-hidden="true">&raquo;</span>
						</a>
					</div>';
				}
			echo "</div>";
	
			}
	
		}	/* Final ver_todoIni() */
	
					   ////////////////////				   ////////////////////
	////////////////////				////////////////////				////////////////////
					 ////////////////////				  ///////////////////
	
	function master_index(){
		
				require '../Inclu.Menu/rutaartic.php';				
				require '../Inclu.Menu/Master_Index.php';
		
			} 

					   ////////////////////				   ////////////////////
	////////////////////				////////////////////				////////////////////
					 ////////////////////				  ///////////////////

function info(){

	global $db; 		global $rowout;
	global $nombre; 	global $apellido;
	
	global $orden;
	if((isset($_POST['Orden']))&&($_POST['Orden']|= '')){
		$orden = $_POST['Orden'];
	}else { $orden = '`id` ASC'; }
	
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

/////////////////////////////////////////////////////////////////////////////////////////////////

	require '../Inclu/Admin_Inclu_footer.php';
		
/* Creado por Juan Manuel Barros Pazos 2020/21 */
