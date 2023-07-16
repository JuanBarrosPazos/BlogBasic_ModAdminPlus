<?php

	require '../Mod_Admin_Plus/Conections/conection.php';
	require '../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){

	echo "<style>
			video {
				max-width: 98% !important;
				height: auto;
				max-height: 190px !important;
				overflow: hidden;
				border-radius: 8px;
				}
		</style>";

	// DEFINO EL NUMERO DE ARTICULOS POR PÁGINA
	global $nitem;
	$nitem = 4;

	require 'Artic/Inc_Artic_Index_Pagina_Ini.php';

	if(!$qb){
			print("</br><font color='#FF0000'>Consulte L.29 Articulo_Ver_index_Card_b.php: </font></br>".mysqli_error($db)."</br>");
			
	} else {
		if(mysqli_num_rows($qb)== 0){

	require 'Artic/Articulo_no_hay_datos_index.php';

	} else { 	

	print ("<!-- Titulo --> 
			<!-- <div class='projects-horizontal'> 
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
            $visual = "<video controls>
                            <source src='Vdo.Art/".$rowb['myvdo']."' />
                        </video>";
        } else { global $visual;
                 $visual = "<img class='img-fluid' src='Img.Art/".$rowb['myimg']."' alt=''>";
                 //$visual = "";
                    }
    
	global $conte;
	$conte = substr($rowb['conte'],0,160);
	$conte = $conte." ...&nbsp;
	<form name='ver' method='POST' action='Artic/Articulo_Ver_index_Popup_Ver.php' target='popup' onsubmit=\"window.open('', 'popup', 'width=500px, height=650px')\">
				<input type='hidden'  name='id'value='".$rowb['id']."' />
				<input type='hidden' name='refuser' value='".$rowb['refuser']."' />
				<input type='hidden' name='refart' value='".$rowb['refart']."' />
				<input type='hidden'  name='tit'value='".$rowb['tit']."' />
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

	print ("<div class='col-sm-6 item' style='margin: 0.5em auto 0.2em auto;' >
				<div class='row' style='text-align:left !important;'>
                    <div class='col-md-12 col-lg-5'>
						".$visual."
                    </div>
                    <div class='col'>
                        <h3 class='name'>".$rowb['tit']."</h3>
						<h7>".$rowb['titsub']."<br>".$rowb['datein']."</h7>
						".$myurl."<p class='description'>".$conte."</p>
                    </div>
				</div>
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
