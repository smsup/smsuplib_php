<?php

require 'lib/smsuplib.php';

$s = new smsuplib('TU_ID_USUARIO','TU_CLAVE_SECRETA');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if($_POST['ord']=='envio'){
		$texto = $_POST['texto'];
		$numeros = array($_POST['tel']);
		$referencia = $_POST['ref'];
		$remitente = (array_key_exists('remit', $_POST))?$_POST['remit']:'';
		var_dump($s->NuevoSMS($texto,$numeros,'', $referencia, $remitente));
	}else if($_POST['ord']=='eliminar'){
		var_dump($s->EliminarSMS($_POST['id']));
	}else if($_POST['ord']=='estado'){
		var_dump($s->EstadoSMS($_POST['id']));
	}else if($_POST['ord']=='creditos'){
		var_dump($s->CreditosDisponibles());
	}else if($_POST['ord']=='resultado'){
		var_dump($s->ResultadoPeticion($_POST['ref']));
	}
}

?>

<form method="POST">
	<h3>Enviar sms</h3>
	<input type="hidden" name="ord" value="envio" />
	Texto:<br>
	<textarea maxlenght="160" name="texto" cols="50" rows="10"></textarea>
	<br>Telefono:<br>
	<input type="text" name="tel" />
	<br>Referencia:<br>
	<input type="text" name="ref" />
	<br>Remitente:<br>
	<input type="text" name="remit" />
	<br>
	<input type="submit" value="Enviar sms" />
</form>
<br>
<form method="POST">
	<h3>Estado sms</h3>
	<input type="hidden" name="ord" value="estado" />
	Id sms obtenido del envio:<br>
	<input type="text" name="id" />
	<br>
	<input type="submit" value="Ver estado" />
</form>
<br>
<form method="POST">
	<h3>Eliminar sms</h3>
	<input type="hidden" name="ord" value="eliminar" />
	Id sms obtenido del envio:<br>
	<input type="text" name="id" />
	<br>
	<input type="submit" value="Eliminar sms" />
</form>
<br>
<form method="POST">
	<h3>Resultado envio anterior</h3>
	<input type="hidden" name="ord" value="resultado" />
	Referencia de la peticion:<br>
	<input type="text" name="ref" />
	<br>
	<input type="submit" value="Ver resultado" />
</form>
<br>
<form method="POST">
	<h3>Creditos disponibles</h3>
	<input type="hidden" name="ord" value="creditos" />
	<input type="submit" value="Ver creditos" />
</form>