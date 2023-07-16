<?php

	global $page; 	global $defaults;

	if(isset($_POST['oculto'])){$_SESSION['titulo'] = $_POST['titulo'];
								$_SESSION['autor'] = $_POST['autor'];
								$_SESSION['dy'] = $_POST['dy'];
								$_SESSION['dm'] = $_POST['dm'];
								$defaults = $_POST;
		}
	else {	$defaults = array ('titulo' => @$_SESSION['titulo'],
								'autor' => @$_SESSION['autor'],
								'dy' => @$_SESSION['dy'],
								'dm' => @$_SESSION['dm']
							);
										}
	
	if ($errors){
		print("	<div  class='errors'>
					<table align='left' style='border:none'>
					<th style='text-align:left'>
					<font color='#FF0000'>* SOLUCIONE ESTOS ERRORES:</font><br/>
					</th>
					<tr>
					<td style='text-align:left'>");
			
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#FF0000'>**</font>  ".$errors [$a]."<br/>");
			}
		print("</td>
				</tr>
				</table>
				</div>
				<div style='clear:both'></div>");
		}
		
		require "../Config/ayear.php";
			
		$dm = array (	'' => 'MES TODOS', '01' => 'ENERO', '02' => 'FEBRERO',
						'03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO',
						'06' => 'JUNIO', '07' => 'JULIO', '08' => 'AGOSTO',
						'09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE',
						'12' => 'DICIEMBRE', );
		
		$dd = array (	'' => 'DÍA TODOS', '01' => '01', '02' => '02',
						'03' => '03', '04' => '04', '05' => '05', '06' => '06',
						'07' => '07', '08' => '08', '09' => '09', '10' => '10',
						'11' => '11', '12' => '12', '13' => '13', '14' => '14',
						'15' => '15', '16' => '16', '17' => '17', '18' => '18',
						'19' => '19', '20' => '20', '21' => '21', '22' => '22',
						'23' => '23', '24' => '24', '25' => '25', '26' => '26',
						'27' => '27', '28' => '28', '29' => '29', '30' => '30',
						'31' => '31', );
											

	print("<table align='center' style=\"border:0px;margin-top:4px;width:auto\">
				
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
				<tr>
					<td align='right'>
						<input type='submit' value='FILTRO NOTICIAS' class='botonleer' />
						<input type='hidden' name='oculto' value=1 />
		<!-- --> 
	<input type='hidden' name='titulo' size=20 maxlenth=10 value='".$defaults['titulo']."' />
		<select name='autor'>
		<option value=''>SELECCIONE AUTOR</option>");
						
	/* RECORREMOS LOS VALORES DE LA TABLA PARA CONSTRUIR CON ELLOS UN SELECT */	
	global $db;
	global $tablename;	$tablename = "`".$_SESSION['clave']."admin`";
	$sqlb =  "SELECT * FROM $tablename ORDER BY `Apellidos` ASC ";
	$qb = mysqli_query($db, $sqlb);
	if(!$qb){
			print("* ".mysqli_error($db)."</br>");
	} else {
		while($rows = mysqli_fetch_assoc($qb)){
				print ("<option value='".$rows['ref']."' ");
				if($rows['ref'] == $defaults['autor']){ print ("selected = 'selected'");}
						print ("> ".$rows['Apellidos']." ".$rows['Nombre']."</option>");
				}
			}  
	print ("</select>
				<select name='dy'>");
					foreach($dy as $optiondy => $labeldy){
						print ("<option value='".$optiondy."' ");
						if($optiondy == @$defaults['dy']){print ("selected = 'selected'");}
										print ("> $labeldy </option>");
									}	
			print ("</select>
					<!--<select name='dm'>-->
					<input type='hidden' name='dm' value='' />");
		/*
			foreach($dm as $optiondm => $labeldm){
					print ("<option value='".$optiondm."' ");
					if($optiondm == @$defaults['dm']){ print ("selected = 'selected'"); }
									print ("> $labeldm </option>");
										}	
		*/														
		print ("<!--</select>-->
				</td></tr>
				</form>	</table>");

?>