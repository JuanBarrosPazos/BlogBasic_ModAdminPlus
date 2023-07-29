<?php

function regresarConexion(){

  global $conexion;

  if(file_exists("../Mod_Admin_Plus/Conections/conection.php")){
        require "../Mod_Admin_Plus/Conections/conection.php";
        require "../Mod_Admin_Plus/Conections/conect.php";
        require "../Mod_Admin_Plus/Inclu/my_bbdd_clave.php";
        $conexion = $db;
  } elseif(!file_exists("../Mod_Admin_Plus/Conections/conection.php")) { 
          $db_host = "localhost";
          $db_user = "root";
          $db_pass = "root";
          $db_name = "web_calendar";
        $conexion = mysqli_connect($db_host,$db_user,$db_pass,$db_name) or die ("Problemas con la Conexion");
        mysqli_set_charset($conexion, 'utf8');
  } else { }

  return $conexion;

  } // FIN FUNCTION

?>
