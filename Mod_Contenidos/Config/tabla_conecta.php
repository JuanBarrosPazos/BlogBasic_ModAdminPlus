<?php

	print("<table align='center' style=\"margin-top:10px\">
				<tr><td style='color:red' align='center'>
					INTRODUZCA LOS DATOS DE CONEXI&Oacute;N A LA BBDD.
					</br>
			SE CREAR&Aacute; EL ARCHIVO DE CONEXI&Oacute;N Y LAS TABLAS DE CONFIGURACI&Oacute;N.
				</td></tr>
			</table>
			
			<table style=\"margin-top:10px\">
				<tr>
					<th colspan=2 class='BorderInf'>INIT CONFIG DATA</th>
				</tr>
				
	<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>
						
				<tr>
					<td style='text-align:right; width:150px;'>	
						<font color='#FF0000'>*</font>
						DB HOST ADRESS
					</td>
					<td style='text-align:left; width:150px;'>
		<input type='text' name='host' size=25 maxlength=30 value='".$defaults['host']."' />
					</td>
				</tr>
					
				<tr>
					<td style='text-align:right;'>	
						<font color='#FF0000'>*</font>
						DB USER NAME
					</td>
					<td style='text-align:left;'>
		<input type='text' name='user' size=25 maxlength=25 value='".$defaults['user']."' />
					</td>
				</tr>
					
				<tr>
					<td style='text-align:right;'>	
						<font color='#FF0000'>*</font>
						DB PASSWORD
					</td>
					<td style='text-align:left;'>
		<input type='text' name='pass' size=25 maxlength=25 value='".$defaults['pass']."' />
					</td>
				</tr>
				
				<tr>
					<td style='text-align:right;'>	
						<font color='#FF0000'>*</font>
						DB NAME
					</td>
					<td style='text-align:left;'>
		<input type='text' name='name' size=25 maxlength=25 value='".$defaults['name']."' />
					</td>
				</tr>
					
				<tr>
					<td class='BorderSup' colspan='2'>
						<input type='submit' value='INIT CONFIG' class='botonverde' />
						<input type='hidden' name='config' value=1 />
						
					</td>
				</tr>
		</form>														
			</table>"); 


?>