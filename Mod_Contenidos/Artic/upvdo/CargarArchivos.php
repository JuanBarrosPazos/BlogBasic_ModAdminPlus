<?php
    @session_start();

    require '../../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
    require '../../../Mod_Admin_Plus/Conections/conection.php';
    require '../../../Mod_Admin_Plus/Conections/conect.php';
    
    global $errora;
    $errora = "<script>$(\"#progressDivId\").hide();</script><div class=\"error\">";
    global $errorb;
    $errorb = "</div>";

if (isset($_POST['btnSubmit'])) {

    global $uploadfile;
    $uploadfile = $_FILES["uploadImage"]["tmp_name"];
    global $folderRuta;
    //$folderRuta = "subidas/";
    $folderRuta = "../../Vdo.Art/";

    // LIMITE 1000 KBytes (1Megabyte) * 1000 BYTES 
    global $limitimg;
    //$limitimg = 500 * 1000;
    $limitimg = 1000 * 1000;
    // LIMITE 50000 KBytes (50Megabyte) * 1000 BYTES
    global $limitvid;
    $limitvid= 60000 * 1000;
    /*
    LIMITE SERVIDOR KB
    global $limit_serv;
    $limit_serv = 70000 * 1000;
    APACHE en php.ini en: wamp64\bin\apache\apache2.4.51\bin\ && C:\wamp64\bin\php\php8.1.0\.
    upload_max_filesize = xxM && post_max_size = xxM && [connect_timeout (in seocnds) = xx]
    */

    // SIZE DEL ARCHIVO EN KB
    global $tamanho;
    $tamanho = $_FILES['uploadImage']['size'];
    //echo $tamanho;
    // SIZE DEL ARCHIVO EN MB
    global $tamanhom;
    $tamanhom = number_format(($tamanho / 1000),2,",",".");

    $myimg = $_FILES["uploadImage"]["name"];
    global $myimg;
    $myimg = str_replace(" ","_",$myimg);

    global $extension;
    $extension = substr($_FILES["uploadImage"]["name"],-4);
    $extension = strtolower($extension);
    //print($extension)." Extension<br>";

    global $extvdo;
    $extvdo = str_replace(".","",$extension);
    global $new_name;
    $new_name = $_SESSION['myvdo'].".".$extvdo;

    //$ext_img = array('.jpg','.gif','.png','.bmp','jpeg');
    //$ext_imgok = in_array($extension, $ext_img);
    $ext_vid = array('.mp4','.avi','.mkv','webm');
    $ext_vidok = in_array($extension, $ext_vid);

    
    echo "<h6>".$myimg."</h6>";
    //echo isset($ext_imgok)." Imagen <br>";
    //echo isset($ext_vidok)." Video <br>";
    
    /* PASE LO QUE PASE VALIDO EL LIMITE DEL SERVIDOR
    if($tamanho > $limit_serv){
        global $tamanhom;
        echo $errora."SUPERADO LIMITE SERVIDOR, MAYOR DE 70 MB: ".$tamanhom." MBytes".$errorb;
    }

    else*/
    if ((!is_writable($folderRuta)) || (!is_dir($folderRuta))) {
        echo $errora."error".$errorb;
    }
    // NO SE ADMITE LA EXTENSION
    elseif/*((!$ext_imgok)&&*/(!$ext_vidok)/*)*/{
        echo $errora."TIPO DE ARCHIVO NO ADMITIDO".$errorb;
    }
    // SE ADMITE LA EXTENSIÓN
    /*
    // SI EXISTE YA ESTE ARCHIVO
    elseif(file_exists(($folderRuta.$myimg))){
        echo $errora."ESTE ARCHIVO YA EXISTE".$errorb;
    }
    // SI ES IMGEN LIMITE DE SIZE
    elseif(($ext_imgok)&&($tamanho > $limitimg)){
            global $tamanhom;
            echo $errora."ARCHIVO NO PERMITIDO, MAYOR DE 1 MB: ".$tamanhom." MBytes".$errorb;
    }
    */
    // SI ES VIDEO LIMITE DE SIZE
    elseif(($ext_vidok)&&($tamanho > $limitvid)){
            global $tamanho;
            echo $errora."ARCHIVO NO PERMITIDO, MAYOR DE 50 MB: ".$tamanhom." MBytes".$errorb;
    }

    // SE PROCESA EL ARCHIVO
    // CARGA ETIQUETA IMG O VIDEO SEGUN TIPO ARCHIVO
    elseif(file_exists(($folderRuta.$myimg))){
            unlink($folderRuta.$myimg);

        if (move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $folderRuta.$myimg)) {           
            if($ext_vidok){

            rename($folderRuta.$myimg, $folderRuta.$new_name);

            echo '<video class="myimg" controls><source src="'.$folderRuta.$new_name.'" /></video>';
            print("<!-- PARA CERRAR VENTANA POPUP  -->
        <form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
                <button type='submit' class=\"btn btn-primary mb-2\">CERRAR VENTANA</button>
        </form>
           
        <!-- PARA VOLVER SIN POPUP
        <form name='closewindow' action='../News_Modificar_01.php' >
                <button type='submit' class=\"btn btn-primary mb-2\">CERRAR Y VOLVER ADMIN SYST</button>
        </form> -->");

        global $db;     global $db_name;
        global $dyt1;   $dyt1 = substr($_SESSION['refart'],0,4);
        global $tablename;	$tablename = "`".$_SESSION['clave'].$dyt1."articulos`";
        $sqlc = "UPDATE `$db_name`.$tablename SET `myvdo` = '$new_name' WHERE $tablename.`refart` = '$_SESSION[myvdo]' LIMIT 1 ";
        if(mysqli_query($db, $sqlc)){
            global $folderRuta;
            global $rutav;
            $rutav = $folderRuta.$_SESSION['oldvdo'];
            if(file_exists($rutav)){ unlink($rutav); } else { }
        }
        else{   print("<font color='#FF0000'>
                            * ESTOS DATOS NO SON VALIDOS, MODIFIQUE ESTA ENTRADA: </font>
                            </br>
                            &nbsp;&nbsp;&nbsp;".mysqli_error($db))."
                            </br>";
                }
                exit();

            }else{  unlink($folderRuta.$new_name);
                    unlink($folderRuta.$myimg);
                    echo '<h6>NO HAY VISTA PREVIA</h6>';
                    exit();
                }
            }  // FIN UPLOADED_FILE                  
        }  // FIN IF FILE EXISTS

    elseif (move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $folderRuta.$myimg)) {

        rename($folderRuta.$myimg, $folderRuta.$new_name);

        /*
        if($ext_imgok){
            echo "<img class='myimg' src='".$folderRuta.$myimg."' >";
            exit();
        }else*/if($ext_vidok){
           echo '<video class="myimg" controls><source src="'.$folderRuta.$new_name.'" /></video>';
        print("<!-- PARA CERRAR VENTANA POPUP -->
        <form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
                <button type='submit' class=\"btn btn-primary mb-2\">CERRAR VENTANA</button>
        </form>
        <!-- PARA VOLVER SIN POPUP
        <form name='closewindow' action='../News_Modificar_01.php' >
                <button type='submit' class=\"btn btn-primary mb-2\">CERRAR Y VOLVER ADMIN SYST</button>
        </form> -->");
        
        global $db;     global $db_name;
        global $dyt1;   $dyt1 = substr($_SESSION['refart'],0,4);
        global $tablename;	$tablename = "`".$_SESSION['clave'].$_SESSION['dyt1']."articulos`";
        $sqlc = "UPDATE `$db_name`.$tablename SET `myvdo` = '$new_name' WHERE $tablename.`refart` = '$_SESSION[myvdo]' LIMIT 1 ";
        if(mysqli_query($db, $sqlc)){
            global $folderRuta;
            global $rutav;
            $rutav = $folderRuta.$_SESSION['oldvdo'];
            if(file_exists($rutav)){ unlink($rutav); } else { }
        }
        else{   print("<font color='#FF0000'>
                            * ESTOS DATOS NO SON VALIDOS, MODIFIQUE ESTA ENTRADA: </font>
                            </br>
                            &nbsp;&nbsp;&nbsp;".mysqli_error($db))."
                            </br>";
                }
           exit();

        }else{  unlink($folderRuta.$new_name);
                unlink($folderRuta.$myimg);
                echo '<h6>NO HAY VISTA PREVIA</h6>';
                exit();
            }
        } // FIN UPLOADED_FILE
    // SI NO SE PROCESA LA IMAGEN
    else {
        echo $errora."NO SE HA PODIDO GUARDAR EN ".$folderRuta.$myimg.$errorb;
    }

} // FIN isset($_POST['btnSubmit']

/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>
