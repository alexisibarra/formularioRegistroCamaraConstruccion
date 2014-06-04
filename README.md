# Formulario de registro para la Cámara Bolivariana de Construcción

## Instrucciones de instalación

1 Crear la base de datos 

2 Modificar los datos de conexión a la base de datos en la función construct 
del archivo Model/model.php (local o remoto)

3 Cargar el esquema de la base de datos (db/schema.sql)

4 Modificar los valores de destinatario, emisor, transporte SMTP en el archivo
Controller/swiftMailerValues.php

## Bugs

La implementación de Swift es genérica. Dependiendo del servidor en el cual se
suba puede presentarse problemas al enviar los correos.

