<?php

	require_once '../Mod_Admin_Plus/Conections/conection.php';
	require_once '../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){

	echo "<style> 
			.jcard { margin: 0.3em auto auto auto !important; text-align:left; }
			video { background-color: #343434; }
			.img-fluid { max-height: 190px !important;}
		  </style>";

	// DEFINO EL NUMERO DE ARTICULOS POR PÁGINA
	global $nitem;
	$nitem = 3;

	require 'Artic/Inc_Artic_Index_Pagina_Ini.php';

	if(!$qb){
			print("<font color='#FF0000'>Consulte L.78: </font></br>".mysqli_error($db)."</br>");
			
	} else {
		if(mysqli_num_rows($qb)== 0){

	require 'Artic/Articulo_no_hay_datos_index.php';

	} else { 

    // INICIO DISEÑO PLANTILLA
	print ("<!-- Titulo -->
			<!-- <div class='projects-clean'> 
				<div class='intro'>
					<h2 class='section-heading text-uppercase'>Noticias</h2>
					<h3 class='section-subheading text-muted'>Lorem ipsum dolor sit amet consectetur.</h3>
				</div>
		  	</div> -->
            <div class='row projects'><!-- Inicio class row-->
				");

	while($rowb = mysqli_fetch_assoc($qb)){

        if(strlen(@trim($rowb ['myvdo'])) > 0){
            global $visual;
            $visual = "<video class='img-fluid' controls>
                            <source class'vdo' src='Vdo.Art/".$rowb['myvdo']."' />
                        </video>";
        } else { global $visual;
                 $visual = "<img class='img-fluid' src='Img.Art/".$rowb['myimg']."' alt=''>";
                 //$visual = "";
                    }
    
	global $conte;
	$conte = substr($rowb['conte'],0,160);
	$conte = $conte." ...&nbsp;
	<form name='ver' method='POST' action='Artic/Articulo_Ver_index_Popup_Ver.php' target='popup' onsubmit=\"window.open('', 'popup', 'width=500px, height=650px')\">
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
			</form>";	

	require 'url_logica.php';

	print ("<div class='jcard tarecol-sm-6 col-lg-4 item'>
				".$visual."
                <h3 class='name'>".$rowb['tit']."</h3>
				<h7>".$rowb['titsub']."<br>".$rowb['datein']."</h7>
				".$myurl."<h6 class='description'>".$conte."</h6>
		 	</div>");

	} // Fin While

	print(" </div> <!-- Fin class row-->");
			
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
