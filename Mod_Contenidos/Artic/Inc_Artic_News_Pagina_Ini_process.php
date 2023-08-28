<?php

    global $db; 	global $db_name;
	
	//echo @$_SESSION['autor']."<br>";

	global $autor; 		global $g; 		global $titulo;

	if (strlen(@@trim(@$_SESSION['titulo'])) == 0){
		$titulo = '';
		$g = 'AND';
	}else{
		$titulo = @trim($_SESSION['titulo']);
		$titulo = "AND `tit` LIKE '%".$titulo."%' ";
		$g = 'OR';
	}

	if (strlen(@@trim(@$_SESSION['autor'])) == 0){
		$autor = '';
	}else{
		$autor = @trim($_SESSION['autor']);
		$autor = "$g `refuser` LIKE '%".$autor."%' ";
	}

	global $orden;
	if((isset($_POST['Orden']))&&($_POST['Orden']|= '')){
		$orden = $_POST['Orden'];
	}else { $orden = '`id` DESC'; }

	//global $dd1;
	
	if ((isset($_POST["page"]))||(isset($_GET["page"]))){
		global $dyt1;
		global $dy1;
		$dy1 = "20".$_SESSION['dy'];
		$dyt1 = "20".$_SESSION['dy'];
	}
	elseif ((!isset($_POST['dy']))||($_POST['dy'] == '')){	
								global $dyt1;
								global $dy1;
								$dy1 = date('Y');
								$dyt1 = date('Y');
								$_SESSION['dy'] = date('y');
											} 
							 				else {	global $dyt1;
													global $dy1;
													$dy1 = "20".$_SESSION['dy'];
													$dyt1 = "20".$_SESSION['dy'];
													}
	
	if ((isset($_POST["page"]))||(isset($_GET["page"]))){
		global $dm1;
		$dm1 = "-".$_SESSION['dm'];
	}
	elseif (!isset($_POST['dm'])){ 	global $dm1;
									$dm1 = '';} 
											 else {	global $dm1;
													$dm1 = "-".$_SESSION['dm'];
													}
	global $fil;
	$fil = $dy1.$dm1."%";
	//$fil = $dy1."-%".$dm1."%";
	global $vname;	$vname = "`".$_SESSION['clave'].$dyt1."articulos`";

	$result =  "SELECT * FROM `$db_name`.$vname WHERE `visible` = 'y' AND `datein` LIKE '$fil' $titulo $autor ";
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
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
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

	$sqlb =  "SELECT * FROM `$db_name`.$vname WHERE `visible` = 'y' AND `datein` LIKE '$fil' $titulo $autor  ORDER BY $orden $limit";
	$qb = mysqli_query($db, $sqlb);


?>