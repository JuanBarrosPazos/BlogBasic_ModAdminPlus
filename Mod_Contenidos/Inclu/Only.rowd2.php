
<?php

global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";
$sqld =  "SELECT * FROM $tablename WHERE `ID` = '$_POST[ID]'";
$qd = mysqli_query($db, $sqld);
$rowd = mysqli_fetch_assoc($qd);

/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>