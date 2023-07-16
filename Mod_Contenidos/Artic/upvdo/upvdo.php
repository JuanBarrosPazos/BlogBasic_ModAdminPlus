<?php
session_start();

	require '../../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';

	require 'upvdo_head.php';

	require '../../../Mod_Admin_Plus/Conections/conection.php';
	require '../../../Mod_Admin_Plus/Conections/conect.php';

	///////////////////////////////////////////////////////////////////////////////////////

	if (($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){

		if (isset($_POST['oculto2'])){
			$_SESSION['myvdo'] = $_POST['refart'];
			$_SESSION['oldvdo'] = $_POST['myvdo'];
			echo "REFERENCIA ARTICULO ".$_SESSION['myvdo'];
			show_form();
		}
		else{	global $a;
				$a = '';}
	
	} else { require '../../Inclu/table_permisos.php'; }

	///////////////////////////////////////////////////////////////////////////////////////

function show_form(){
	
	if(isset($_POST['oculto2'])){
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
	} else { }

	print("<!-- Begin page content -->

	<div class=\"container\">
	
	  <h5 class=\"mt-5\">SOLO SE ADMINTEN VIDEOS INFERIORES A 50MG CON FORMATO MKV MP4 AVI WEBM</h5>
	  <hr>
	
	  <div class=\"row\">
		<div class=\"col-12 col-md-12\"> 
	
	<!-- Contenido -->
	
	<div class=\"form-container\"> 
	
	  <form class=\"form-inline\" action=\"CargarArchivos.php\" id=\"uploadForm\" name=\"frmupload\" method=\"post\" enctype=\"multipart/form-data\">
	
		<div class=\"form-group mx-sm-3 mb-2\">
		  <input type=\"file\" id=\"uploadImage\" name=\"uploadImage\" />
		</div>
	
		<button id=\"submitButton\" type=\"submit\" class=\"btn btn-primary mb-2\" name='btnSubmit'>
		  CARGAR VIDEO MKV MP4 AVI WEBM
		</button>
		<button id=\"borrar\" type=\"reset\" class=\"btn btn-primary mb-2\">BORRAR FORMULARIO</button>
	  </form>
	
		<!-- PARA CERRAR VENTANA POPUP -->
		<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
				<button type='submit' class=\"btn btn-primary mb-2\">CERRAR VENTANA</button>
		</form>
		
		<!-- PARA VOLVER SIN POPUP 
		<form name='closewindow' action='../News_Modificar_01.php' >
				<button type='submit' class=\"btn btn-primary mb-2\">CERRAR Y VOLVER ADMIN SYST</button>
		</form>
		-->
	
		<div class='progress' id=\"progressDivId\">
			<div class='progress-bar' id='progressBar'></div>
			<div class='percent' id='percent'>0%</div>
		</div>
	<!--   
		<div style=\"height: 10px;\"></div>
	-->
		<div id='salidaImagen'></div>
	
	 </div>
	 
	 <!-- Fin Form-container -->  
	
		  <!-- Fin Contenido --> 
	
		</div>
	  </div>
	
	  <!-- Fin row --> 
	  
	</div>
	<!-- Fin container -->
	
	");
} // FIN FUNCTION SHOWFORM
  
	///////////////////////////////////////////////////////////////////////////////////////

	require 'upvdo_footer.php';

	/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>
