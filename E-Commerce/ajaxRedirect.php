<?php 
	function debug_to_console( $data ) {
		$output = $data;
		if ( is_array( $output ) )
			$output = implode( ',', $output);

		echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
	}
	
	if(isset($_POST['action']))
	{
		switch ($_POST['action']) //action seria la class , despues iria el metodo (call)
		{
			case 'registroUsuario':
				require 'clases/class.users.php';

				$usuario = new Users();

				$nombre   = $_POST['nombre'];
				$apellido = $_POST['apellido'];
				$email    = $_POST['email'];
				$pass     = $_POST['pass'];

				echo $usuario->registro($nombre, $apellido, $email, $pass);

				break;

			case 'login':
				require 'clases/class.users.php';

				$usuario = new Users();

				$email    = $_POST['email'];
				$pass     = $_POST['pass'];

				echo $usuario->login($email, $pass);

				break;

			case 'logout':
				require 'clases/class.users.php';

				$usuario = new Users();
				echo $usuario->logout();

				break;

			case 'editarUsuario':
				require 'clases/class.users.php';

				$usuario = new Users();

				$nombre    = $_POST['nombre'];
				$apellido  = $_POST['apellido'];
				$email     = $_POST['email'];
				$idEnc     = $_POST['idEnc'];

				echo $usuario->editar($nombre, $apellido, $email, $idEnc);

				break;

			default:
				$class  = ucwords($_POST['action']);
				$method = $_POST['call'];
				require_once 'clases/class.'.$_POST['action'].'.php';
				$result = $class::$method($_POST);
				if(is_array($result))
					echo json_encode($result);
				else
					echo $result;
				break;
		}
	}
?>