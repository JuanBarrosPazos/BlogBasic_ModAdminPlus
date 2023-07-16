<?php

	require_once '../Mod_Admin_Plus/Conections/conection.php';
	require_once '../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	// DEFINO EL NUMERO DE ARTICULOS POR PÁGINA
	global $nitem;
	$nitem = 3;

	require 'Artic/Inc_Artic_Index_Pagina_Ini.php';
 
	if(!$qb){
		print("</br><font color='#FF0000'>Consulte L.19 Artic/Articulo_Ver_index.php: </font></br>".mysqli_error($db)."</br>");
			
	} else {
		if(mysqli_num_rows($qb)== 0){

	require 'Artic/Articulo_no_hay_datos_index.php';
	
	} else { 

	print ("<!--
				<div class='row'> Titulo
					<div class='col-lg-12 text-center'>
						<h2 class='section-heading text-uppercase'>Noticias</h2>
					</div>
				</div>
			-->
			<div class='row'> <!-- Inicio class row-->
			<div class='col-lg-12'>  <!-- Inicio class col-lg-12 -->
			<ul class='timeline'> <!-- Inicio Ul class timeline -->
				");
				
	global $estilo;
	$estilo = array('timeline','timeline-inverted');
	global $estiloin;
	$estiloin = 0;

	while($rowb = mysqli_fetch_assoc($qb)){

    // DEFINO LA RECTIFICACIÓN DE LA RUTA IMG
    global $rut;
    $rut = "";
    //$rut = "../";

	require 'Artic/Inc_Artic_Index_Form.php';

	print ("
	<li class='".$estilo[$estiloin]."'> <!-- Inicio Li contenedor -->
			<div class='timeline-image'>
	<img class='<!--rounded-circle--> img-fluid' src='Img.Art/".$rowb['myimg']."' alt=''>
			</div>
			<div class='timeline-panel'>
				<div class='timeline-heading'>
					<h6>".$rowb['datein']."</h6>
					<h5>".$rowb['tit']."</h5>
				</div>
				<div class='timeline-body'>
					<p class='text-muted'>".$conte."</p>
				</div>
		<div id=\"".$refart."\"></div>
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

	require 'Artic/Inc_Artic_Index_Pagina_Fin.php';
	
			} 
		
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

				 ver_todo();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


/* Creado por Juan Manuel Barros Pazos 2020/21 */
