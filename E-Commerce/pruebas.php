<?php 
	require 'share/header.php'; 
	require 'clases/class.encriptacion.php';

	//var_dump($_SESSION);

	$usuario = $_SESSION['Usuario'];

	$user = json_decode($usuario);
	echo $user->id_usuario;

	echo encriptacion::desencriptar($user->id_usuario);

	try {
		$user = json_decode($usuario);
		echo $user->id_usuario;

		echo encriptacion::desencriptar($user->id_usuario);
	} catch (Exception $e) {
		
	}
?>