<?php
session_start();

header('Content-Type: application/json');

  require("conexion.php");
  $conexion = regresarConexion();

  global $eventN;
  $eventN = $_SESSION['clave']."eventos";

  global $eventPred;
  $eventPred = $_SESSION['clave']."eventospredefinidos";

  switch ($_GET['accion']) {

  case 'listar':
    $datos = mysqli_query($conexion, "SELECT id, titulo AS title, descripcion, inicio AS start, fin AS end, colortexto AS textColor, colorfondo AS backgroundColor FROM $eventN");
    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode($resultado);
    break;

  case 'agregar':
    $respuesta = mysqli_query($conexion, "INSERT INTO $eventN (titulo, descripcion, inicio, fin, colortexto, colorfondo) VALUES ('$_POST[titulo]','$_POST[descripcion]','$_POST[inicio]','$_POST[fin]','$_POST[colortexto]','$_POST[colorfondo]')");
    echo json_encode($respuesta);
    break;

  case 'modificar':
    $respuesta = mysqli_query($conexion, "UPDATE $eventN SET titulo='$_POST[titulo]', descripcion='$_POST[descripcion]', inicio='$_POST[inicio]', fin='$_POST[fin]', colortexto='$_POST[colortexto]', colorfondo='$_POST[colorfondo]' WHERE id=$_POST[id]");
    echo json_encode($respuesta);
    break;

  /* NO SE MODIFIVAN LAS FECHAS EN LOS EVENTOS */
  case 'modificarRel':
    $respuesta = mysqli_query($conexion, "UPDATE $eventN SET titulo = '$_POST[titulo]', descripcion = '$_POST[descripcion]', inicio=CONCAT(SUBSTRING(inicio,1,11),SUBSTRING('$_POST[inicio]',12, 16),':00'),  fin=CONCAT(SUBSTRING(fin,1,11),SUBSTRING('$_POST[fin]',12, 16),':00'), colortexto='$_POST[colortexto]', colorfondo='$_POST[colorfondo]' WHERE titulo = '$_GET[oldtitle]'");
    echo json_encode($respuesta);
    break;

  /* NO SE MODIFIVAN LAS FECHAS EN LOS EVENTOS */
  
  case 'modificarRelTot':
    $respuesta = mysqli_query($conexion, "UPDATE $eventN AS a1 INNER JOIN $eventPred AS a2 
                            ON a1.titulo='$_GET[oldtitle]' 
                            SET a1.titulo='$_POST[titulo]', 
                                a1.descripcion='$_POST[descripcion]',
                                a1.inicio=CONCAT(SUBSTRING(inicio,1,11),SUBSTRING('$_POST[inicio]',12, 16),':00'), 
                                a1.fin=CONCAT(SUBSTRING(fin,1,11),SUBSTRING('$_POST[fin]',12, 16),':00'), 
                                a1.colortexto='$_POST[colortexto]', 
                                a1.colorfondo='$_POST[colorfondo]', 
                                a2.titulo='$_POST[titulo]', 
                                a2.horainicio=CONCAT(SUBSTRING('$_POST[inicio]',12, 16),':00'), 
                                a2.horafin=CONCAT(SUBSTRING('$_POST[fin]',12, 16),':00'), 
                                a2.colortexto='$_POST[colortexto]', 
                                a2.colorfondo='$_POST[colorfondo]' 
                            WHERE a2.titulo='$_GET[oldtitle]'");

    echo json_encode($respuesta);
    break;
  /* NO SE MODIFIVAN LAS FECHAS EN LOS EVENTOS */

  case 'borrar':
      $respuesta = mysqli_query($conexion, "delete from $eventN where id = $_POST[id]");
      echo json_encode($respuesta);
    break;

  case 'borrarRel':
      $respuesta = mysqli_query($conexion, "DELETE FROM $eventN WHERE titulo='$_GET[titulo]'");
      echo json_encode($respuesta);
    break;


}

 ?>
