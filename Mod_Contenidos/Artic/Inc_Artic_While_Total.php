<?php

    global $conte;
    $conte = substr($rowb['conte'],0,56);
    $conte = $conte." ...";	

    global $rutaurl;        global $rutaimg;        global $rutaurlart;
    global $rutaurlvdo;     global $rutaurlimg;     global $rectifurl;

    if ($rectifurl == 1){   $rutaurl = "../";
                            $rutaimg = "../";
                            $rutaurlart = "Artic/";
                            $rutaurlvdo = "upvdo/";
                                }
    else {  $rutaurl = "";
            $rutaimg = "../";
            $rutaurlart = "";
            $rutaurlvdo = "upvdo/";
    }

	if(strlen(@trim($rowb['myvdo'])) > 0){
		global $visual;
		$visual = "<div class='whiletotala'>
                    <video controls width='140px' height='auto'>
						<source src='".$rutaimg."Vdo.Art/".$rowb['myvdo']."' />
					</video></div>";
		global $delvdo;
		$delvdo = "<input type='submit' value='BORRAR VIDEO' class='botonrojo' />";
		global $upvdo;
		$upvdo = "<input type='submit' value='MODIFICA VIDEO' class='botonnaranja' />";
	} else { global $visual;
             $visual = "";
            /*
			 $visual = "<div class='whiletotala'>
             <img style='width:80%; height:auto;' src='".$rutaimg."Img.Art/untitled.png' />
             </div>";
             */
			 global $delvdo;
			 $delvdo = 1;
			 global $upvdo;
			 $upvdo = "<input type='submit' value='CREAR VIDEO'class='botonverde' />";
				}

    print ("<div style=\"text-align:center; display:block; margin-top:8px; padding-top: 0px;\">

            <div class='whiletotala'>
                DATE IN<br>".strtoupper($rowb['datein'])."
            </div>

            <div class='whiletotala'>
                TITULO<br>".strtoupper($rowb['tit'])."
            </div>
            
            <div class='whiletotala' style=\"width:180px !important; text-align:left;\">
                <span style=\"display:block; text-align:center;\">
                    DESCRIPCION
                </span>".strtoupper($conte)."
            </div>

            <div class='botongrupo' >
                <div class='whiletotala'>
                    <img style='width:92%; height:auto;' src='".$rutaimg."Img.Art/".$rowb['myimg']."' />
                </div>
                    ".$visual."
            </div>                           
                                
		</div>
    
        <div style='clear:both'></div>");

    if ($_SESSION['Nivel'] == 'admin') { 
        
	print("<div style=\"text-align:center; display:block;\">

    <div class='botongrupo' >

    <form name='ver' action='".$rutaurl.$rutaurlart."Articulo_Ver_02.php' method='POST' target='popup' onsubmit=\"window.open('', 'popup', 'width=520px,height=auto')\" class='whiletotala'>");

        require 'Inc_Artic_While_Total_Rows.php';
        
    print ("<input type='submit' value='VER DETALLES' class='botonverde' />
            <input type='hidden' name='oculto2' value=1 />
            </form>

        <form name='modifica_img' action='".$rutaurl.$rutaurlart."Articulo_Modificar_img.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup',  'width=540px,height=460px')\" class='whiletotala' >");
			
            require 'Inc_Artic_While_Total_Rows.php';

	print(" <input type='submit' value='MODIFICA IMAGEN' class='botonnaranja' />
			<input type='hidden' name='oculto2' value=1 />
            </form></div>");

    // INCIO MUESTRO ARTICULO

    if ($rowb['visible'] == "n"){
    print("<form name='visiblesi' action='$_SERVER[PHP_SELF]' method='POST' class='whiletotala'>");

            require 'Inc_Artic_While_Total_Rows.php';
            
    print ("<input type='submit' value='MOSTRAR ARTICULO' class='botonverde' />
            <input type='hidden' name='visiblesi' value=1 />
			<input type='hidden' name='autor' value='".@$_POST['autor']."' />
			<input type='hidden' name='Orden' value='".@$_POST['Orden']."' />
            <input type='hidden' name='dy' value=".$dyt1." />
			<input type='hidden' name='dm' value='".@$_POST['dm']."' />
			<input type='hidden' name='dd' value='".@$_POST['dd']."' />
        </form>");
    }// FIN MUESTRO ARTICULO
    elseif ($rowb['visible'] == "y"){
    // INICIO OCULTO ARTICULO
    print("<form name='ver' action='$_SERVER[PHP_SELF]' method='POST' class='whiletotala'>");

            require 'Inc_Artic_While_Total_Rows.php'; 
            
    print ("<input type='submit' value='OCULTAR ARTICULO' class='botonrojo' />
            <input type='hidden' name='visibleno' value=1 />
            <input type='hidden' name='autor' value='".@$_POST['autor']."' />
            <input type='hidden' name='Orden' value='".@$_POST['Orden']."' />
            <input type='hidden' name='dy' value=".@$dyt1." />
            <input type='hidden' name='dm' value='".@$_POST['dm']."' />
            <input type='hidden' name='dd' value='".@$_POST['dd']."' />
        </form>");
    // FIN OCULTO ARTICULO
    } else { } // FIN MOSTRAR OCULTAR ARTICULO

    print("
    <div class='botongrupo' >
		<form name='ver' action='".$rutaurl.$rutaurlart."Articulo_Modificar_02.php' method='POST' target='popup' onsubmit=\"window.open('', 'popup', 'width=420px,height=850em')\" class='whiletotala'>");

            require 'Inc_Artic_While_Total_Rows.php';

	print("	<input type='submit' value='MODIFICA DATOS' class='botonnaranja' />
			<input type='hidden' name='oculto2' value=1 />
			<input type='hidden' name='headpop' value=1 />
			</form>

		<form name='ver' action='".$rutaurl.$rutaurlart."Articulo_Borrar_02.php' method='POST' class='whiletotala'>");

            require 'Inc_Artic_While_Total_Rows.php';

	print("	<input type='submit' value='BORRAR DATOS' class='botonrojo' />
			<input type='hidden' name='oculto2' value=1 />
			</form></div>

        <div class='botongrupo' >
        <form name='videonews' action='".$rutaurl.$rutaurlart.$rutaurlvdo."upvdo.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=400px,height=560px')\" class='whiletotala'>");

            require 'Inc_Artic_While_Total_Rows.php';
			
	print( $upvdo."
		    <input type='hidden' name='oculto2' value=1 />
		    </form>");

    if($delvdo == 1){ print("</div>"); } 
    else { 
        print("<form name='videonews' action='".$rutaurl.$rutaurlart."Articulo_Vdo_Borrar.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=400px,height=560px')\" class='whiletotala'>");

        require 'Inc_Artic_While_Total_Rows.php';
			
        print( $delvdo."
                <input type='hidden' name='oculto2' value=1 />
                </form></div>");
        }

    print("</div><hr>"); } else { echo "<hr>"; }

    /* Creado por Juan Manuel Barros Pazos 2020/21 */

    ?>