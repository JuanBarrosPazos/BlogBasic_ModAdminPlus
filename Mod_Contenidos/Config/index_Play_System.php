<?php
  session_start();

                ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
              ////////////////////				  ///////////////////

  global $keyBlog;    $keyBlog = 1;
  require '../Mod_Admin_Plus/Conections/conection.php';
  require '../Mod_Admin_Plus/Conections/conect.php';

  require '../Mod_Admin_Plus/Inclu/error_hidden.php';

      ayear();
         
  function articulos(){

      global $db;     global $db_name;
          
      /************** CREAMOS LA TABLA ARTICULOS ***************/

      require '../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
      $articulos = "`".$_SESSION['clave'].date('Y')."articulos`";
      
      $tg = "CREATE TABLE IF NOT EXISTS `$db_name`.$articulos (
      `id` int(6) NOT NULL auto_increment,
      `refuser` varchar(22) collate utf8_spanish2_ci NOT NULL,
      `refart` varchar(22) collate utf8_spanish2_ci NOT NULL,
      `tit` varchar(22) collate utf8_spanish2_ci NOT NULL,
      `titsub` varchar(22) collate utf8_spanish2_ci NOT NULL,
      `datein` varchar(20) collate utf8_spanish2_ci NOT NULL default '0',
      `timein` varchar(20) collate utf8_spanish2_ci NOT NULL default '0',
      `datemod` varchar(20) collate utf8_spanish2_ci NOT NULL default '0',
      `timemod` varchar(20) collate utf8_spanish2_ci NOT NULL default '0',
      `conte` text(402) collate utf8_spanish2_ci NOT NULL,
      `myimg` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
      `myvdo` varchar(30) collate utf8_spanish2_ci DEFAULT NULL,
      `myurl` varchar(50) collate utf8_spanish2_ci DEFAULT NULL,
      `visible` varchar(1) collate utf8_spanish2_ci NOT NULL default 'n',
      PRIMARY KEY  (`id`),
      UNIQUE KEY `id` (`id`),
      UNIQUE KEY `refart` (`refart`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ";
                
    if(mysqli_query($db, $tg)){
        global $dat3;   $dat3 = "\t* OK TABLA ".$articulos."\n";

        global $dateinRef;	$dateinRef = date('Y.m.d'); 
        $dateinRef1 = $dateinRef.".01.01.01";		$dateinRef1i = $dateinRef.".01.01.01.png";
        global $datein; 	$datein = date('Y-m-d');
        global $timein;		$timein = date('H:i:s');
        global $newyear;  $newyear = date('Y');   $newyear = "HAPPY NEW YEAR ".$newyear.". ";
        global $insertArt;
        $insertArt = "INSERT INTO `$db_name`.$articulos (`refuser`, `refart`, `tit`, `titsub`, `datein`, `timein`, `datemod`, `timemod`, `conte`, `myimg`, `myvdo`, `myurl`, `visible`) VALUES
        ('anonimo', '$dateinRef1', '$newyear', 'FELIZ AÑO NUEVO', '$datein', '$timein', '0000-00-00', '00:00:00', '$newyear HAS INICIADO UN NUEVO AÑO EN NUESTRA APP. QUE SEAS MUY FELIZ ESTE AÑO QUE EMPIEZA CON TODOS TUS SERES QUERIDOS.', '$dateinRef1i', NULL, '', 'y')";

          if(mysqli_query($db, $insertArt)){
            global $dat3; 	$dat3 = $dat3."\t* OK INSERT DATOS EN ".$articulos."\n";

            /* CREO LAS IMAGENES PARA LAS ENTRADAS AUTOMÁTICAS DE LA INSTALACIÓN */
            if(!file_exists('Img.Art/newyear.png')){
              if(file_exists('Img.Sys/newyear.png')){
                global $imgname1;   $imgname1 = "Img.Art/".$dateinRef1i;
                copy("Img.Sys/newyear.png", "$dateinRef1i");
                $dat3 = $dat3.PHP_EOL."\tCOPY ".$dateinRef1i;
              } else { 
                print("DON'T COPY ".$imgname1."</br>");
                $dat3 = $dat3.PHP_EOL."\tDON'T CCOPY ".$imgname1;}
            }
          }else{ 
            global $dat3; 	$dat3 = $dat3."\t* NO OK INSERT DATOS EN ".$articulos."\n";
          }

      } else {
            print( "* NO OK TABLA ".$articulos.". ".mysqli_error($db)."\n");
            global $dat3;   $dat3 = "\t* NO OK TABLA ".$articulos.". ".mysqli_error($db)."\n";
        }

    } // FIN FUNCTION articulos()
        
    function modif(){
                                           
          $filename = "Config/ayear.php";
          $fw1 = fopen($filename, 'r+');
          $contenido = fread($fw1,filesize($filename));
          fclose($fw1);
          
          $contenido = explode("\n",$contenido);
          $contenido[2] = "'' => 'YEAR',\n'".date('y')."' => '".date('Y')."',";
          $contenido = implode("\n",$contenido);
          
          //fseek($fw, 37);
          $fw = fopen($filename, 'w+');
          fwrite($fw, $contenido);
          fclose($fw);
          global $dat1;   $dat1 = "\tMODIFICADO Y ACTUALIZADO ".$filename.".\n";
    }
        
    function modif2(){
        
          $filename = "Config/year.txt";
          $fw2 = fopen($filename, 'w+');
          $date = "".date('Y')."";
          fwrite($fw2, $date);
          fclose($fw2);
          global $dat2;
          $dat2 = "\tMODIFICADO Y ACTUALIZADO ".$filename.".\n";
    }
        
        
      function ayear(){
          $filename = "Config/year.txt";
          $fw2 = fopen($filename, 'r+');
          $fget = fgets($fw2);
          fclose($fw2);
          
          if($fget == date('Y')){
            /*print(" <div style='clear:both'></div>
                <div style='width:200px'>* EL AÑO ES EL MISMO </div>".date('Y')." == ".$fget );
            */		}
          elseif($fget != date('Y')){ 
            /* 
              print(" <div style='clear:both'></div>
              <div style='width:200px'>* EL AÑO HA CAMBIADO </div>".date('Y')." != ".$fget );
            */
            modif();
            modif2();
            articulos();
            global $dat1;	global $dat2;	global $dat3;
            global $datos;
			      $datos = $dat1.$dat2.$dat3."\n";
			
		// GRABAMOS EL LOG DE CAMBIO DE TABLAS ANUALES ARTICULOS
		global $dir;        $dir = "Log";
		
		global $logdocu;  $logdocu = "AUTO_SYSTEM";
		global $logdate;  $logdate = date('Y_m_d');
		global $logtext;
		$logtext = PHP_EOL."** MODIFICACION DE TABLAS ANUALES ARTICULOS => ".$logdate;
		$logtext = $logtext.PHP_EOL.".\t USER REF: ".$logdocu;
		$logtext = $logtext.PHP_EOL.$datos;
		
		global $filename;   $filename = $dir."/".$logdate."_".$logdocu.".log";
		global $log;  		  $log = fopen($filename, 'ab+');
		fwrite($log, $logtext);
		fclose($log);

            }
        } // FIN FUNCTION function ayear()

                ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
              ////////////////////				  ///////////////////
            
    // SELECCION DE LA PLANTILLA EN INDEX
    require 'Artic/plantilla.php';
    //echo "* ".$_SESSION['plantilla']."<br>";
    if ($_SESSION['plantilla'] == 'aleaindex'){
    global $ad; $ad = date('d');
    global $ad1; $ad1 = array('01','05','09','13','17','21','25','29');
    global $ad2; $ad2 = array('02','06','10','14','18','22','26','30');
    global $ad3; $ad3 = array('03','07','11','15','18','23','27','31');
    global $ad4; $ad4 = array('04','08','12','16','20','24','28');
    if (in_array($ad, $ad1)){ $_SESSION['plantilla'] = 'Articulo_Ver_index_Card_b.php'; }
    elseif (in_array($ad, $ad1)){ $_SESSION['plantilla'] = 'Articulo_Ver_index.php'; }
    elseif (in_array($ad, $ad2)){ $_SESSION['plantilla'] = 'Articulo_Ver_index_Card.php'; }
    elseif (in_array($ad, $ad3)){ $_SESSION['plantilla'] = 'Articulo_Ver_index_Card_c.php'; }
    elseif (in_array($ad, $ad4)){ $_SESSION['plantilla'] = 'Articulo_Ver_index_Popup.php'; }
    else { $_SESSION['plantilla'] = 'Articulo_Ver_index.php'; }      
  } 
  elseif (!isset($_SESSION['plantilla'])) { $_SESSION['plantilla'] = 'Articulo_Ver_index.php'; }

                ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
              ////////////////////				  ///////////////////

          
  /* Creado por Juan Manuel Barros Pazos 2020/21 */

                ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
              ////////////////////				  ///////////////////

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Juan Barros Pazos</title>

  <link href="Img.Sys/favicon.png" type='image/ico' rel='shortcut icon' />
  
  <link href="Css/html.css" rel="stylesheet" type="text/css" />
  <link href="Css/conta.css" rel="stylesheet" type="text/css">

  <!-- Bootstrap core CSS -->
  <link href="Css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="Css/agency.min.css" rel="stylesheet">

  <link href="Css/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
  <div class="container imglogo">
      <a class="navbar-brand js-scroll-trigger" href="index.php">
        <!-- Juan Barros Pazos -->
        <img style='height: 3.2em !important; width: auto;' src="Img.Sys/logowm.png" />
      </a>

      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
        <!--
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="index.php">Inico</a>
          </li>
        -->
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="Www/services.php">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="Www/news.php">News</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="Www/contact.php">Contact</a>
          </li>
          <!--
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="Www/portfolio.php">Portfolio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="Www/team.php">Team</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="Www/clients.php">Clients</a>
          </li>
          -->
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="masthead">
    <div class="container">
      <div class="intro-text">
        <!--
        <div class="intro-lead-in">Welcome To Juan Barros Pazos</div>
        -->
        <div class="intro-heading text-uppercase">Web Monkey</div>
      </div>
    </div>
  </header>

  <!-- About -->
  <section class="page-section" id="about">
    <div class="container">

      <?php
          // DEFINO LA PLANTILLA QUE SE UTILIZA EN LA WEB
            //require 'Artic/Articulo_Ver_index.php';
            //require 'Artic/Articulo_Ver_index_Popup.php'; 
            require 'Artic/'.$_SESSION['plantilla'];
       ?>

    </div> <!-- Fin container -->
  </section>

<!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-12">
          <ul class="list-inline social-buttons">
          <li class="list-inline-item">
            <a href="http://twitter.com/JuanBarrosPazos" target="_blank">
                <i class="fab fa-twitter"></i>
              </a>
            </li>
            <li class="list-inline-item">
            <a href="https://www.facebook.com/juan.barrospazos" target="_blank">
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
            <li class="list-inline-item">
                <a href="https://github.com/JuanBarrosPazos" target="_blank">
                  <i class="fab fa-github"></i>
                </a>
              </li>
            <li class="list-inline-item">
              <a href="https://www.facebook.com/juan.barrospazos" target="_blank">
                  <i class="fab fa-linkedin-in"></i>
                </a>
            </li>
          </ul>
        </div>
        <div class="col-md-12">
          <ul class="list-inline quicklinks">
          <!-- -->
            <li class="list-inline-item">
              <a href="#">Privacy Policy</a>
            </li>
            <li class="list-inline-item">
              <a href="#">Terms of Use</a>
            </li>
          
            <li class="list-inline-item">
              <a href="../Mod_Admin_Plus/index.php" target="_blank">Admin Access</a>
            </li>
            
         </ul>
        </div>
      </div>
<div class="row align-items-center">
  <div class="col-md-12">
     <span class="copyright">Copyright &copy; Juan Barros Pazos 2020/23.</span>
  </div>  
</div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="Js/jquery.min.js"></script>
  <script src="Js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="Js/jquery.easing.min.js"></script>

  <!-- Contact form JavaScript -->
  <script src="Js/jqBootstrapValidation.js"></script>
  <script src="Js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="Js/agency.min.js"></script>

</body>

</html>
