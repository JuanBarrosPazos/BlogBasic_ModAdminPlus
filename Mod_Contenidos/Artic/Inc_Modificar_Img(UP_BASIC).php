<?php


$trf = $_SESSION['iniref'];

global $new_name;
global $carpetaimg;
$carpetaimg = "../Img.Art";

if($_FILES['myimg']['size'] == 0){
    $nombre = $carpetaimg."/untitled.png";
    global $new_name;
    $rename_filename = $carpetaimg."/".$new_name;							
    copy("untitled.png", $rename_filename);
                      }
                      
else{	$safe_filename = @trim(str_replace('/', '', $_FILES['myimg']['name']));
    $safe_filename = @trim(str_replace('..', '', $safe_filename));

     $nombre = $_FILES['myimg']['name'];
      $nombre_tmp = $_FILES['myimg']['tmp_name'];
      $tipo = $_FILES['myimg']['type'];
      $tamano = $_FILES['myimg']['size'];
    
    $destination_file = $carpetaimg.'/'.$safe_filename;

 if( file_exists( $carpetaimg.'/'.$nombre) ){
    unlink($carpetaimg."/".$nombre);
  //	print("* El archivo ".$nombre." ya existe, seleccione otra imagen.</br>");
                      }
    
elseif (move_uploaded_file($_FILES['myimg']['tmp_name'], $destination_file)){
    
    // Renombrar el archivo:
    $extension = substr($_FILES['myimg']['name'],-3);
    // print($extension);
    // $extension = end(explode('.', $_FILES['myimg']['name']) );
    global $new_name;
    $rename_filename = $carpetaimg."/".$new_name;								
    rename($destination_file, $rename_filename);

    // print("El archivo se ha guardado en: ".$destination_file);

    }
    
  else {print("NO SE HA PODIDO GUARDAR EN ".$destination_file);}
  
  }

/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>