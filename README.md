smsuplib_php
============

Clase que facilita el uso de la api de smsup.es para el envio de sms.

En index.php esta disponible un ejemplo de cada metodo de la API.

Documentacion de la API disponible en:

http://www.smsup.es/docs/api/

Instalacion
-----------

- Usando composer:

Descargar la libreria y añadir la dependencia

``` bash
composer.phar require smsup/smsuplib
```

Añadir el autoload creado por composer

``` php
<?php

require 'vendor/autoload.php';

?>
```

- Copiando a mano la libreria a tu proyecto:

Añadir el archivo smsuplib.php a tu proyecto.

Incluir el archivo php.

``` php
<?php

require 'ruta/al/archivo/smsuplib.php';

?>
```

Uso
---

``` php
<?php

$s = new smsup\smsuplib('TU_ID_USUARIO','TU_CLAVE_SECRETA');
$s->NuevoSMS($texto, $numeros, $fechaenvio, $referencia, $remitente);

?>
```

En index.php se indica un ejemplo completo de como usarla.