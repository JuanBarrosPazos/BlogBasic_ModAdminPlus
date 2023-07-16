# BlogBasic_ModAdminPlus V02.0.2

### 2023/06/16

## GESTOR DE CONTENIDOS BÁSICO Y ADMIN PLUS CON CONTROL DE HORARIO LABORAL

----

----

* ADMINTE IMAGEN Y VIDEO EN LOS ARTICULOS.

----

1º. DESCOMPRIMIR EL ZIP O RAR CON TODOS LOS ARCHIVOS.

2º. COPIAR EL DIRECTORIO CON TODOS LOS ARCHIVOS EN EL SERVIDOR REMOTO O LOCAR.

3º. ACCEDER A ARCHIVO DE CONEXIONES EN RUTASERVER/index.php

    - Mediante este archivo se configura la conexión a la bbdd y se crean las carpetas que 
      necesita el sistema para poder trabajar.
      Config/index_Init_System.php actua como copia de index.php con las mismas RUTASERVER
      Config/config.php actua como index.php desde la ruta Config/

    - Config/config2.php
      Se accede directamente a él depués de haber superado el paso anterior y haber generado
      los archivos de conexión al servidor y las tablas de bbdd.
      Mediante este archivo crearemos el primer administrador con categoría de WebMaster.

4º. UNA VEZ SUPERADOS ESTOS DOS PASOS CON ÉXITO PODREMOS ACCEDER AL LOGIN ZONA DE ADMINISTRACIÓN:
    
    - Mediante el enlace que se muestra tras crear el primer admin o webmaster.

    - En la ruta: RUTASERVER/Gcb.Docs/access.php
    
    - EL index.php QUE NOS HA PROPORCIONADO LA CONEXIÓN A BBDD Y LA GENERACIÓN DE TABLAS 
      ES ELIMINADO POR EL SISTEMA Y REEMPLAZADO POR UN NUEVO index.php (Config/index_Init_System.php)
      Y NOS PRESENTA EL FRONT PAGE DEL BLOG.

5º. EN CASO DE DETECTARSE UNA INSTALACIÓN ANTERIOR, SEGUIR LOS PASOS QUE NOS INTERESEN.

6º. 
