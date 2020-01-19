<?php 
/**
* Dio Azar
* Clase para encriptar cualquier parámetro
* Hay que usar solo Encriptacion::encriptar() y Encriptacion::desencriptar(), esos métodos encripatan 2 veces llamando a los métodos encriptar2() y desencriptar2()
* $keyEncriptacion se puede cambiar en cualquier momento, pero todos los usuarios deberían volver a loguearse porque las cookies que tienen grabadas ya no les servirían (porque al desencriptar usaría una contraseña que no es la que se usó para encriptar).
  En caso de grabar datos a largo plazo encriptados no debería cambiarse $keyEncriptacion o habría que hacer una tabla en la db con todas las claves con sus respectivas fechas para poder desencriptarlos... o hacer otra cosa. Recomiendo no guardar datos encriptados en la db con esta clase.
*/
class Encriptacion
{
	private static $keyEncriptacion = 'da918dcfb97cfab3b0e1db97eff0624c21496154758';

	function encriptar($string) 
	{
	   $result = '';
	   for($i=0; $i<strlen($string); $i++) {
	      $char = substr($string, $i, 1);
	      $keychar = substr(Self::$keyEncriptacion, ($i % strlen(Self::$keyEncriptacion))-1, 1);
	      $char = chr(ord($char)+ord($keychar));
	      $result.=$char;
	   }
	   $result = base64_encode($result);
	   //$result = Self::encriptar2($result);
	   return $result;
	}

	function desencriptar($string)
	{
	   $result = '';
	   //$string = Self::desencriptar2($string);
	   $string = base64_decode($string);
	   for($i=0; $i<strlen($string); $i++) {
	      $char = substr($string, $i, 1);
	      $keychar = substr(Self::$keyEncriptacion, ($i % strlen(Self::$keyEncriptacion))-1, 1);
	      $char = chr(ord($char)-ord($keychar));
	      $result.=$char;
	   }
	   return $result;
	}

	private function encriptar2($string)
	{
	    $key = Self::$keyEncriptacion;
	    $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
	    return $encrypted;
	}
	
	private function desencriptar2($string)
	{
	    $key = Self::$keyEncriptacion;
	    $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	    return $decrypted;
	}
}
?>