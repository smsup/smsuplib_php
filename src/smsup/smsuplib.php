<?php

namespace smsup;

class smsuplib {

	const HOST = 'https://www.smsup.es';
	const URLsms = '/api/sms/';
	const URLcreditos = '/api/creditos/';
	const URLenvio = '/api/peticion/';

	protected $usuario = '';
	protected $clave = '';

	public function __construct ($usuario,$clave){
		$this->usuario = $usuario;
		$this->clave = $clave;
	}

	public function NuevoSMS($texto, Array $numeros, $fechaenvio='', $referencia='', $remitente=''){
		$post = json_encode(array('texto'=>$texto, 'fecha' => (($fechaenvio=='')?'NOW':$fechaenvio->format('c')),
			'telefonos' => $numeros, 'referencia'=>$referencia, 'remitente'=> $remitente));
		$cabeceras = $this->generarCabeceras('POST', self::URLsms, $post);
		return $this->enviar(self::URLsms, 'POST', $cabeceras, $post);
	}

	public function EliminarSMS($idsms){
		$url = self::URLsms.$idsms.'/';
		$cabeceras = $this->generarCabeceras('DELETE', $url);
		return $this->enviar($url, 'DELETE', $cabeceras);
	}

	public function EstadoSMS($idsms){
		$url = self::URLsms.$idsms.'/';
		$cabeceras = $this->generarCabeceras('GET', $url);
		return $this->enviar($url, 'GET', $cabeceras);
	}

	public function CreditosDisponibles(){
		$cabeceras = $this->generarCabeceras('GET', self::URLcreditos);
		return $this->enviar(self::URLcreditos, 'GET', $cabeceras);
	}

	public function ResultadoPeticion($referencia){
		$url = self::URLenvio.$referencia.'/';
		$cabeceras = $this->generarCabeceras('GET', $url);
		return $this->enviar($url, 'GET', $cabeceras);
	}



	protected function generarCabeceras($verbo, $url, $post=''){
		$cabeceras = array();
		$smsdate = date('c');
		$cabeceras[] = 'Sms-Date: '.$smsdate;
		$text = $verbo.$url.$smsdate.$post;
		$firma = hash_hmac('sha1', $text, $this->clave);
		$cabeceras[] = 'Firma: '.$this->usuario.':'.$firma;
		return $cabeceras;
	}

	protected function enviar($url, $method, $cabeceras, $body = null){
		$url = self::HOST.$url;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if($method == "POST") {
			curl_setopt($ch, CURLOPT_POST, true);
		}else if($method=='DELETE'){
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, array_values($cabeceras));
		if($body != null) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		}
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$data = curl_exec($ch);
		if (curl_errno($ch)) {
			throw new Exception($ch);
		} else {
			$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
		curl_close($ch);
		if ($data != false) {
			$result = json_decode($data,true);
			if ($result != null) {
				return array('httpcode'=>$statusCode, 'resultado' => $result);
			}
		}

		return false;
	}
}