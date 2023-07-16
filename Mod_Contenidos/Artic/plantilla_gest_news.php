<?php
session_start();

	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../Inclu/Admin_Inclu_Head_b.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

	require '../Inclu/mydni.php';
	require 'plantilla_news.php';

///////////////////////////////////////////////////////////////////////////////////////////////

if ($_SESSION['Nivel'] == 'admin'){

	master_index();

	if(isset($_POST['oculto'])){
		
			if($form_errors = validate_form()){
				show_form($form_errors);
					} else {
						process_form();
						show_form();
							}
		} else { show_form();}
} else { require 'table_permisos.php'; } 

//////////////////////////////////////////////////////////////////////////////////////////////

function validate_form(){
	
	$errors = array();
	
	if(strlen(@trim($_POST['plantillanews'])) == 0){
		$errors [] = "<font color='#FF0000'>SELECCIONE PLANTILLA WEB NEWS</font>";
		}
	
	return $errors;

		} 

//////////////////////////////////////////////////////////////////////////////////////////////

function process_form(){
	
	// CREA EL ARCHIVO MYDNI.TXT $_SESSION['mydni'].
		$_SESSION['plantillanews'] = $_POST['plantillanews'];

		$filename = "plantilla_news.php";
		$fw2 = fopen($filename, 'w+');
		$mydni = '<?php $_SESSION[\'plantillanews\'] = \''.$_SESSION['plantillanews'].'\'; ?>';
		fwrite($fw2, $mydni);
		fclose($fw2);
	
	/**************************************/

	print( "<table align='center' style='margin-top:10px'>
				<tr>
			<th colspan=2 class='BorderInf'>SE HA GRABADO CORRETAMENTE</th>
				</tr>
				<tr>
			<td  align='center'>INDEX PLANTILLA WEB NEWS<BR> ".$_POST['plantillanews']."</td>
				</tr>
			</table>");

		}

//////////////////////////////////////////////////////////////////////////////////////////////

function show_form($errors=[]){

	//require 'plantilla_news.php';
	
	if(isset($_POST['oculto'])){
		$defaults = array ( 'plantillanews' => $_POST['plantillanews']);
		} else {$defaults = array ( 'plantillanews' => $_SESSION['plantillanews']); }
	
	if ($errors){
		print("<table align='center'>
					<tr>
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
	
	// ARRAY PARA RADIO BOTTOM
global $plantillanews;
$plantillanews = array ('Articulo_Ver_news.php' => 'PLANTILLA CASILLAS INVERTED & DETALLES CARD EXTENDIDA ',
						'Articulo_Ver_news_Popup.php' => 'PLANTILLA CASILLAS INVERTED & DETALLES POPUP',
						'Articulo_Ver_news_Card.php' => 'PLANTILLA CARD VERTICAL 1 & DETALLES POPUP',
						'Articulo_Ver_news_Card_b.php' => 'PLANTILLA CARD HORIZONTAL & DETALLES POPUP ',
						'Articulo_Ver_news_Card_c.php' => 'PLANTILLA CARD VERTICAL 2 & DETALLES POPUP ',
						);	

/*******************************/

		global $c;
		$c = count($plantillanews);
		global $a;
		$a = 0;
		echo "<div class='juancentra'>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' >

		<legend style='text-align:center !important' >
		PLANTILLAS WEB PARA NEWS<br>PLANTILLA ACTUAL NEWS<br>".$_SESSION['plantillanews']."
		</legend><hr>";

		foreach ($plantillanews  as $key => $value){
				if ($a<$c){ $a++;}else { }
		echo"<div class='gestplantillas'>
				<input id='".$a."' name='plantillanews' type='radio' value='".$key."'";
			
			if($defaults['plantillanews'] == $key) {print(" checked=\"checked\"");} else { }
			
		echo" required />
			<label for='".$a."'>* ".$a." ".$value."</label><br>
				<div style='text-align:center;'>
					<img src='plantillas_img_news/p0".$a."a.png' />
					<img src='plantillas_img_news/p0".$a."b.png' />
				</div>
			</div><hr>";
		} // FIN FOREACH

		echo "<div class='gestplantillas'>
		<input id='aleanews' name='plantillanews' type='radio' value='aleanews'";
		
		if($defaults['plantillanews'] == 'aleanews') {print(" checked=\"checked\"");} else { }
		
		echo "required />
			<label for='aleanews'>* ".($c+1)." SELECCION AUTOMATICA ALEATORIA DE PLANTILLA</label><br>
				</div><hr>

				<div style='text-align:center;'>
				<input type='submit' value='NEWS FRONT GRABAR NUEVA PLANTILLA' class='botonverde' />
			  <input type='hidden' name='oculto' value=1 />
				</div></form></fieldset></div>";

	} // FIN FUNCTION show_form()

/////////////////////////////////////////////////////////////////////////////////////////////////
	
	function master_index(){
		
		require '../Inclu.Menu/rutaartic.php';				
		require '../Inclu.Menu/Master_Index.php';

	} 

/////////////////////////////////////////////////////////////////////////////////////////////////

	require '../Inclu/Admin_Inclu_footer.php';
		
/* Creado por Juan Barros Pazos 2020/23. */
?>
