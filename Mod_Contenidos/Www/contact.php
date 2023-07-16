<?php
session_start();

/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>

<!DOCTYPE html>
<html lang="en">

<head>

<script type="text/JavaScript">

// Esta función limita el número de carácteres del text area de comentarios.
function limita(elEvento, maximoCaracteres) {
  var elemento = document.getElementById("mensaje");
 
  // Obtener la tecla pulsada 
  var evento = elEvento || window.event;
  var codigoCaracter = evento.charCode || evento.keyCode;
  // Permitir utilizar las teclas con flecha horizontal
  if(codigoCaracter == 37 || codigoCaracter == 39) {
    return true;
  }
 
  // Permitir borrar con la tecla Backspace y con la tecla Supr.
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
 
function actualizaInfo(maximoCaracteres) {
  var elemento = document.getElementById("mensaje");
  var info = document.getElementById("info");
 
  if(elemento.value.length >= maximoCaracteres ) {
    info.innerHTML = "Máximo "+maximoCaracteres+"caracteres";
  }
  else {
    info.innerHTML = "You can write up to "+(maximoCaracteres-elemento.value.length)+" additional characters";
  }
}
// Tendremos que dar el id que tenga el text area y añadir onkeypress="return limita(event, 200);" onkeyup="actualizaInfo(200)" para limitar los caracteres a 200 en este caso.
function MM_validateForm() { 
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }

</script>

  <title>Juan Barros Pazos - Contact</title>

  <?php 

    require '../../Mod_Admin_Plus/Conections/conection.php';
    require '../../Mod_Admin_Plus/Conections/conect.php';

    global $head;
    $head = "head2";

   require 'Inc_Header_Nav_Head.php'; 
  
  /* Creado por Juan Manuel Barros Pazos 2020/21 */

  ?>

  <!-- Contact -->
  <section class="page-section" id="contact">
    <div class="container">



    <div class="row">
        <div class="col-lg-12 text-center" style="color: #ababab">
          <h4 >
              DISEÑO WEB Y PROGRAMACIÓN
          </h4>
          <h6>
              PALMA DE MALLORCA<br>
              SPAIN<br>
              +34 696969696<br>
              JuanBarrosPazos@hotmail.es<br>
          </h6>
        </div>
      </div>

  <?php 

    // LLAMO AL FORMULARIO DE CONTACTO
    require 'Inc_Contact_Form.php';

  ?>

    </div>
  </section>

  <?php require 'Inc_Footer.php';  ?> 

  <?php require 'Inc_Jquery_Boots_Foot.php';  ?>

</body>

</html>
