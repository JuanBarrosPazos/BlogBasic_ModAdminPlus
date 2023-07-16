<!DOCTYPE html>
<html lang="es">
	
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
	
<link href="../../Img.Sys/favicon.png" type='image/ico' rel='shortcut icon' />

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/style.css">
<!--
<script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
-->

<link href="../../Css/html.css" rel="stylesheet" type="text/css" />
<link href="../../Css/conta.css" rel="stylesheet" type="text/css" />
<link href="../../Css/menu.css" rel="stylesheet" type="text/css" />
<link href="../../Css/menuico.css" rel="stylesheet" type="text/css" />

    <!-- Only for jquery -->

<script src='js/jquery-3.4.1' type="text/javascript"></script>
<script src='js/jquery-3.4.1.min.js' type="text/javascript"></script>

<script type="text/javascript" src="js/jquery.form.min.js"></script>

<script type="text/javascript">

$(document).ready(function () {
	$('#borrar').click(function(){
		$("#progressDivId").hide();
		$("#salidaImagen").hide();
	});

    $('#submitButton').click(function () {
    	$('#uploadForm').ajaxForm({
    	    target: '#salidaImagen',
    	    url: 'CargarArchivos.php',
    	    beforeSubmit: function () {
    	        $("#salidaImagen").hide();
    	        if($("#uploadImage").val() == "") {
    	        	$("#salidaImagen").show();
    	        	$("#salidaImagen").html("<div class='error'>SELECCIONE UN ARCHIVO PARA SUBIR</div>");
                    return false; 
				}
				
			// EL INPUT TIENE DATOS
			if($("#uploadImage").val() != "") {

				// SIZE DEL ARCHIVO, EN KB, REDONDEO DECIMALES A 2
				var docsize = (($("#uploadImage")[0].files[0].size)/1000).toFixed(2);

				// PASE LO QUE PASE VALIDO EL LIMITE DEL SERVIDOR
				var limit_serv = 70000;
				if (docsize >= limit_serv){
					$("#progressDivId").hide();
					$("#salidaImagen").show();
					$("#salidaImagen").html("<div class='error'>SERVER LIMIT "+limit_serv+" DOC > "+docsize+"</div>");
					return false;
				} // FIN LIMITE SERVIDOR
				else{
				// 0 GENERAL INICIO VALIDACION EXTENSION ARCHIVO
				//ext_ok = new Array(".gif", ".jpg", ".png", ".jpeg", ".mkv", ".mp4", ".avi", ".webm");
				ext_ok = new Array(".mkv", ".mp4", ".avi", ".webm");
				var archivo = $("#uploadImage").val();
				//RECUPERO LA EXTENSION DEL ARCHIVO
				var ext = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
				//COMPRUEBO SI LA EXTENSION ESTA PERMITIDA
				permitida = "";
				for (var i = 0; i < ext_ok.length; i++) {
				    if (ext_ok[i] == ext) { permitida = "yes";
				       						break;
					 }else {permitida = "no";}
				} // FIN for

				// 1 GENERAL EXTENSION PERMITIDA
				if(permitida == "yes"){

					// 2 COMPROBAMOS SI ES UNA IMAGEN
					ext_img = new Array(".gif", ".jpg", ".png", ".jpeg");
					console.info(ext_img.includes(ext));
					if(ext_img.includes(ext)){
						// 3 SI ES IMAGEN SE VALIDA EL SIZE PERMITIDO
						// 3 LIMITE 1000 KBytes (1Megabyte) * 1000 BYTES 
						//var limitimg = 1000;
						var limitimg = 1;
							if(docsize > limitimg){
								$("#progressDivId").hide();
								$("#salidaImagen").show();
	/*
	$("#salidaImagen").html("<div class='error'>IMAGEN DOC SIZE "+docsize+" > "+limitimg+"</div>");
	*/
	$("#salidaImagen").html("<div class='error'>SOLO VIDEO MKV MP4 AVI WEBM</div>");
								return false;
							} // 3 FIN IMAGEN LIMITE SIZE
							else{}
						} // 2 FIN SI ES IMAGEN

					// 2 NO ES IMAGEN
					if(!ext_img.includes(ext)){
						// 4 COMPROBAMOS SI ES VIDEO
						ext_vid = new Array(".mkv", ".mp4", ".avi", ".webm");
						console.info(ext_vid.includes(ext));
						if(ext_vid.includes(ext)){
							// 4 SI ES VIDEO SE VALIDA EL SIZE PERMITIDO
							// 4 LIMITE 50000 KBytes (50Megabyte) * 1000 BYTES
							var limitvid= 60000;
							if(docsize > limitvid){
								$("#progressDivId").hide();
								$("#salidaImagen").show();
			$("#salidaImagen").html("<div class='error'>VIDEO DOC SIZE "+docsize+" > "+limitvid+"</div>");
								return false;
						} // 4 FIN VIDEO LIMITE SIZE
					} // 4 FIN SI ES VIDEO
					// 4 NO ES VIDEO
					if(!ext_vid.includes(ext)){}
				} // 2 FIN NO ES IMAGEN
						
			} // 1 GENERAL FIN EXTENSION PERMITIDA
			// 1 GENERAL EXTENSION NO PERMITIDA
			if(permitida == "no"){
				$("#progressDivId").hide();
				$("#salidaImagen").show();
				$("#salidaImagen").html("<div class='error'>TIPO DE ARCHIVO NO PERMITIDO "+ext+"</div>");
				return false;}

			} // 0 GENERAL FIN VALIDACION TIPO DE EXTENSION
		} // FIN INPUT DATOS

    	            $("#progressDivId").css("display", "block");
    	            var percentValue = '0%';
    	            $('#progressBar').width(percentValue);
					$('#percent').html(percentValue);
    	        }, // FIN beforeSubmit
    	        uploadProgress: function (event, position, total, percentComplete) {

    	            var percentValue = percentComplete + '%';
    	            $("#progressBar").animate({
    	                width: '' + percentValue + ''
    	            }, {
    	                //duration: 5000,
    	                duration: 300, // 300 microsegundos = 3 centesimas de segundo
    	                easing: "linear",
    	                step: function (x) {
                        percentText = Math.round(x * 100 / percentComplete);
    	                    /*$("#percent").text(percentText + "%");*/
                          $("#percent").text("");
                        if(percentText == "100") {
                        	   $("#salidaImagen").show();
                        }
    	                }
    	            });
    	        },
    	        error: function (response, status, e) {
    	            alert('Oops something went.');
    	        },
    	        /* */
    	        complete: function (xhr) {
    	            if (xhr.responseText && xhr.responseText != "error")
    	            {
    	            	  //$("#salidaImagen").html(xhr.responseText);
    	            }
    	            else{  
    	               	//$("#salidaImagen").show();
						$("#progressDivId").hide();
        	            $("#salidaImagen").html("<div class='error'>Problema al cargar el archivo.</div>");
        	            //$("#progressBar").stop();
    	            }
              }

    	    });

    }); // FIN #submitButton.click
});
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



