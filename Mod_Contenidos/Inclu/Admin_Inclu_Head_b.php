<!DOCTYPE html>
	
<head>
	
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="content-type" content="text/html" charset="utf-8" />
<meta http-equiv="Content-Language" content="es-es">
<meta name="Language" content="Spanish">
<meta name="description" content="Gestor Basico Contenidos" />
<meta name="keywords" content="Juan Barros Pazos, Programas gratis, Spain, Mallorca, Palma de Mallorca" />
<meta name="robots" content="all, index, follow" />
<meta name="audience" content="All" />
<title>Juan Manuel Barros Pazos</title>
	
<link href="../Css/html.css" rel="stylesheet" type="text/css" />
<link href="../Css/conta.css" rel="stylesheet" type="text/css" />
<link href="../Css/menu.css" rel="stylesheet" type="text/css" />
<link href="../Css/menuico.css" rel="stylesheet" type="text/css" />

<link href="../Img.Sys/favicon.png" type='image/ico' rel='shortcut icon' />

<script type="text/JavaScript">

function limitac(elEvento, maximoCaracteres) {
  var elemento = document.getElementById("coment");
 
  var evento = elEvento || window.event;
  var codigoCaracter = evento.charCode || evento.keyCode;
  if(codigoCaracter == 37 || codigoCaracter == 39) {
    return true;
  }
 
  if(codigoCaracter == 8 || codigoCaracter == 46) {
    return true;
  }
  else if(elemento.value.length >= maximoCaracteres ) {
    return false;
  }
  else {
    return true;
  }
}
 
function actualizaInfoc(maximoCaracteres) {
  var elemento = document.getElementById("coment");
  var info = document.getElementById("infoc");
 
  if(elemento.value.length >= maximoCaracteres ) {
    info.innerHTML = "Máximo "+maximoCaracteres+" caracteres";
  }
  else {
    info.innerHTML = "You can write up to "+(maximoCaracteres-elemento.value.length)+" additional characters";
  }
}

</script>
</head>

<body topmargin="0">
<div id="Conte">

  <div id="head"> 
  			<span style="font-size:18px">
			  		JUAN BARROS PAZOS
            </span>
  	</br>
  			<span style="font-size:12px">
			  	Design & Programming in Palma de Mallorca
            </span>
   </div>

  				<div style="clear:both"></div>
   
<!--
////////////////////////////////
////////////////////////////////
	Inicio contenedor de datos.
////////////////////////////////
////////////////////////////////
-->

  <div id="Caja2Admin">


