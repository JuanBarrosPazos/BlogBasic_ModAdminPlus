<?php

    global $db;
	global $db_name;

	global $dyt1;
	$dyt1 = date('Y')/*-1*/;
	if(!isset($_SESSION['dy'])){$_SESSION['dy'] = date('y')/*-1*/;
								$_SESSION['dm'] = '';
	} else { }

	global $fil;
	$fil = $dyt1."-%";
	//$fil = $dy1.$dm1.$dd1."%";
	global $vname;	$vname = "`".$_SESSION['clave'].$dyt1."articulos`";

	$result =  "SELECT * FROM $vname WHERE `visible` = 'y' AND `datein` LIKE '$fil'";
	$q = mysqli_query($db, $result);
	global $row;
	@$row = mysqli_fetch_assoc($q);
	global $num_total_rows;
	@$num_total_rows = mysqli_num_rows($q);

	if(!$q || ($num_total_rows < 1)){
		echo "<div class='juancentra' style=\"margin-bottom:0.4em !important;\"><h5>** NO HAY DATOS EN ".$dyt1." **</h5></div>";
	} else { }

	// DEFINO EL NUMERO DE ARTICULOS POR PÁGINA
	//global $nitem;
	//$nitem = 4;
	
	global $page;

     if (isset($_POST["page"])) {
		global $page;
        $page = $_POST["page"];
	}
	
   //examino la pagina a mostrar y el inicio del registro a mostrar
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    }

    if (!$page) {
        $start = 0;
        $page = 1;
    } else {
        $start = ($page - 1) * $nitem;
    }
    
    //calculo el total de paginas
	$total_pages = ceil($num_total_rows / $nitem);
	
    //pongo el n�mero de registros total, el tama�o de p�gina y la p�gina que se muestra
    echo '<h7>* Noticias: '.$num_total_rows.' * P&aacute;gina '.$page.' de ' .$total_pages.'.</h7>';

	global $limit;
	$limit = " LIMIT ".$start.", ".$nitem;

	$sqlb =  "SELECT * FROM `$db_name`.$vname WHERE `visible` = 'y' AND `datein` LIKE '$fil' ORDER BY `id` DESC $limit";

	/*
	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";
	$sqlb =  "SELECT * FROM $tablename WHERE $tablename.`dni` <> '$_SESSION[mydni]' ORDER BY $orden ";
	*/


?>