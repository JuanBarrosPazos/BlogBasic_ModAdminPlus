<?php

$errors = array();
	
if (strlen(@trim($_POST['titulo'])) < 0) {
    $errors [] = " <font color='#FF0000'>UNO DE LOS DOS CAMPOS OBLIGATORIO</font>";
    }

elseif (!preg_match('/^[a-z A-Z 0-9 ñ Ñ \s]*$/',$_POST['titulo'])){
$errors [] = "<font color='#FF0000'>¡¡ CARÁCTERES NO VALIDOS !!</font>";
}

/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>