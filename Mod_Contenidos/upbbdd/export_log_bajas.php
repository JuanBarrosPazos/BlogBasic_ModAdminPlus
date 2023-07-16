<?php
session_start();

	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../Inclu/Admin_Inclu_Head_b.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if ($_SESSION['Nivel'] == 'admin'){

	master_index();

	if(isset($_POST['delete'])){delete();
								show_form();
								listfiles();
										}
	
					else {	show_form();
							listfiles();
					}
								
} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	global $db;
	global $db_name;
	
	if((isset($_POST['oculto1']))||(isset($_POST['delete']))){
				$_SESSION['tablas'] = $_POST['tablas'];
				$defaults = array ('Orden' => '`id` ASC',
								   'tablas' => $_POST['tablas'],
								   						);
		//print($_SESSION['tablas']);
										}
		else{	unset($_SESSION['tablas']);
				$defaults = array ('Orden' => '`id` ASC',
								   'tablas' => '',
								   						);
										}

	global $db;
	global $tablau;		$tablau = "`".$_SESSION['clave']."_feedback`";

	$sqlu =  "SELECT * FROM $tablau ORDER BY `ref` ASC ";
	global $qu;
	$qu = mysqli_query($db, $sqlu);
	global $qcount;
	$qcount = mysqli_num_rows($qu);

	if($qcount >= 1){
		
		print("
			<table align='center' style='border:1; margin-top:2px' width='auto'>
				
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
			
			<input type='hidden' name='Orden' value='".$defaults['Orden']."' />
				<tr>
					<td align='center'>
							EXPORTE .LOG BAJAS USERS.
					</td>
				</tr>		
				<tr>
					<td>
					<div style='float:left; margin-right:6px''>
						<input type='submit' value='SELECCIONE USER BAJA' class='botonazul' />
						<input type='hidden' name='oculto1' value=1 />
					</div>
			<div style='float:left'>
		<select name='tablas'>");

	if(!$qu){
			print("Modifique la entrada L.95 ".mysqli_error($db)."<br/>");
	} else {
					
		while($rowu = mysqli_fetch_assoc($qu)){
					
			print ("<option value='".$rowu['ref']."' ");
					if($rowu['ref'] == $defaults['tablas']){
										print ("selected = 'selected'");}
						print ("> ".$rowu['Nombre']." ".$rowu['Apellidos']." </option>");
					}
			}  
		
	print ("</select></div></td></tr></form></table>"); 

		} // FIN $qcount >= 1
		else { 	require '../Docs/Admin_Botonera.php';
			print ("<table align='center' style=\"border:0px\">
						<tr><td align='center'>
				<hr>
		<form name='boton' action='../../Mod_Admin_Plus/Admin_Ver.php' method='post' style='display: inline-block;' >
            <input type='submit' value='INICIO ADMIN GESTION' class='botonazul' />
            <input type='hidden' name='volver' value=1 />
        </form>
				<hr>
				<font color='#FF0000'>NO HAY DATOS</font>
			</td></tr></table>");
		}
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function listfiles(){
	
	if(@$_SESSION['tablas'] == ''){ $_SESSION['tablas'] = ""; }
	//print("*".$_SESSION['tablas'].".</br>");

	global $ruta;
	$ruta ="../Log/";
	//print("RUTA: ".$ruta.".</br>");
	
	global $rutag;
	$rutag = "../Log/{*}";
	//print("RUTA G: ".$rutag.".</br>");
		
	$directorio = opendir($ruta);
	global $num;
	$num=count(glob($rutag,GLOB_BRACE));
	if($num < 1){
		
		print ("<table align='center' style='border:1; margin-top:2px' width='auto'>
				<tr><td align='center'>NO HAY ARCHIVOS PARA DESCARGAR</td></tr>");
	}else{
	
	if(@$_SESSION['tablas'] != ''){
	
	print ("<table align='center' style='border:1; margin-top:2px' width='auto'>
	<tr><td align='center' colspan='3' class='BorderInf'>".strtoupper($_SESSION['tablas'])." ARCHIVOS LOG 
	</td></tr>");
	while($archivo = readdir($directorio)){

			$arch = substr($archivo, -15, 16);
			$arch = strtolower($arch);
			$ses = strtolower($_SESSION['tablas'].".log");

		if(($archivo != ',') && ($archivo != '.') && ($archivo != '..') && ($arch == $ses)){


			print("<tr>
			<td class='BorderInfDch'>
			<form name='delete' action='$_SERVER[PHP_SELF]' method='post'>
				<input type='hidden' name='tablas' value='".$_SESSION['tablas']."' />
				<input type='hidden' name='ruta' value='".$ruta.$archivo."'>
				<input type='submit' value='ELIMINAR' class='botonrojo' >
				<input type='hidden' name='delete' value='1' >
			</form>
			</td>
			<td class='BorderInfDch'>
				<form name='archivos' action='".$ruta.$archivo."' target='_blank' method='post'>
					<input type='hidden' name='tablas' value='".$_SESSION['tablas']."' />
					<input type='submit' value='DESCARGAR' class='botonverde' >
				</form>
			</td>
			<td class='BorderInf'>".strtoupper($archivo)."</td>
			");
		}else{}
	} // FIN DEL WHILE


		} // FIN $_SESSION['tablas'] != ''
		else { }

	} // FIN ELSE $num < 1

	closedir($directorio);
	print("</table>");
}

function delete(){unlink($_POST['ruta']);}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
				require '../Inclu.Menu/rutabbdd.php';
				require '../Inclu.Menu/Master_Index.php';	
					
				} /* Fin funcion master_index.*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Admin_Inclu_footer.php';

					   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>
