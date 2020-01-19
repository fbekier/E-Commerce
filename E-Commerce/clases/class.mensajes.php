<?php 
/**
 * 
 */
class Mensajes
{
	public $cod_mensaje;
	public $mensaje;

	function __construct($cod_mensaje, $mensaje)
	{
		$this->cod_mensaje = $cod_mensaje;
		$this->mensaje = $mensaje;
	}
}
?>