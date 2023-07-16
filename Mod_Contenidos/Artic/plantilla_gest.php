<?php
session_start();

  	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../Inclu/Admin_Inclu_Head_b.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

	require '../Inclu/mydni.php';
	require 'plantilla.php';

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
	
	if(strlen(@trim($_POST['plantilla'])) == 0){
		$errors [] = "<font color='#FF0000'>SELECCIONE PLANTILLA WEB</font>";
		}
	
	return $errors;

		} 

//////////////////////////////////////////////////////////////////////////////////////////////

function process_form(){
	
	// CREA EL ARCHIVO MYDNI.TXT $_SESSION['mydni'].
		$_SESSION['plantilla'] = $_POST['plantilla'];

		$filename = "plantilla.php";
		$fw2 = fopen($filename, 'w+');
		$mydni = '<?php $_SESSION[\'plantilla\'] = \''.$_SESSION['plantilla'].'\'; ?>';
		fwrite($fw2, $mydni);
		fclose($fw2);
	

	/**************************************/

	print( "<table align='center' style='margin-top:10px'>
				<tr>
					<th colspan=2 class='BorderInf'>
						SE HA GRABADO CORRETAMENTE
					</th>
				</tr>
								
				<tr>
					<td  align='center'>
						INDEX PLANTILLA WEB<BR> "
						.$_POST['plantilla'].
					"</td>
				</tr>
				
			</table>");

		}

//////////////////////////////////////////////////////////////////////////////////////////////

function show_form($errors=[]){

	//require 'plantilla.php';
	
	if(isset($_POST['oculto'])){
		$defaults = array ( 'plantilla' => $_POST['plantilla']);
		} else {$defaults = array ( 'plantilla' => $_SESSION['plantilla']); }
	
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
	
	// ARRAY PARA EL SELECT
	/*
	$plantilla = array ('' => 'PLANTILLAS DISPONIBLES',
						'Articulo_Ver_index.php' => 'PLANTILLA 1',
						'Articulo_Ver_index_Popup.php' => 'PLANTILLA 1 POPUP',
						'Articulo_Ver_index_Card.php' => 'PLANTILLA TARGETAS',
											);
	FIN ARRAY PARA EL SELECT */
	
	// ARRAY PARA RADIO BOTTOM
	global $plantilla;
	$plantilla = array ('Articulo_Ver_index.php' => 'PLANTILLA CASILLAS INVERTED & DETALLES CARD EXTENDIDA ',
						'Articulo_Ver_index_Popup.php' => 'PLANTILLA CASILLAS INVERTED & DETALLES POPUP',
						'Articulo_Ver_index_Card.php' => 'PLANTILLA CARD VERTICAL 1 & DETALLES POPUP',
						'Articulo_Ver_index_Card_b.php' => 'PLANTILLA CARD HORIZONTAL & DETALLES POPUP ',
						'Articulo_Ver_index_Card_c.php' => 'PLANTILLA CARD VERTICAL 2 & DETALLES POPUP ',
						);	

/*******************************/

		global $c;
		$c = count($plantilla);
		global $a;
		$a = 0;
		echo "<div class='juancentra'>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' >
						
		<legend style='text-align:center !important' >
			PLANTILLAS WEB PARA INDEX<br>INDEX PLANTILLA ACTUAL<br>".$_SESSION['plantilla']."
		</legend><hr>";

		foreach ($plantilla as $key => $value){
				if ($a<$c){ $a++;}else { }
		echo"<div class='gestplantillas'>
				<input id='".$a."' name='plantilla' type='radio' value='".$key."'";
			
			if($defaults['plantilla'] == $key) {print(" checked=\"checked\"");} else { }
			
		echo" required />
			<label for='".$a."'>* ".$a." ".$value."</label><br>
				<div style='text-align:center;'>
					<img src='plantillas_img/p0".$a."a.png' />
					<img src='plantillas_img/p0".$a."b.png' />
				</div>
			</div><hr>";
		} // FIN FOREACH

		echo"<div class='gestplantillas'>
				<input id='aleaindex' name='plantilla' type='radio' value='aleaindex'";
		
		if($defaults['plantilla'] == 'aleaindex') {print(" checked=\"checked\"");} else { }

		echo " required />
			<label for='aleaindex'> * ".($c+1)." SELECCION AUTOMATICA ALEATORIA DE PLANTILLA </label><br>
				</div><hr>

				<div style='text-align:center;'>
				<input type='submit' value='INDEX FRONT GRABAR NUEVA PLANTILLA' class='botonverde' />
			  <input type='hidden' name='oculto' value=1 />
				</div></form></fieldset></div>";

	/*******************************/
		// GESTIONAR PLANTILLA MEDIANTE UN SELECT
		/*
		print("<table style=\"margin-top:4px\">
				<tr><th class='BorderInf'>PLANTILLA ACTUAL<br>".$_SESSION['plantilla']."</th></tr>
				<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' >
				<tr><td>
				<select name='plantilla'>");
				foreach($plantilla as $optionnv => $labelnv){
					print ("<option value='".$optionnv."' ");
					if($optionnv == $defaults['plantilla']){
										print ("selected = 'selected'");}
												print ("> $labelnv </option>");
									}	
	print ("</select></td></tr>
				<tr><td valign='middle'  class='BorderSup'>
					<input type='submit' value='INDEX FRONT GRABAR NUEVA PLANTILLA' class='botonnaranja' />
					<input type='hidden' name='oculto' value=1 />
				</td></tr>
			</form></table>"); 
		FIN GESTIONAR PLANTILLAS INDEX CON UN SELECT */ 
	/*******************************/
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
