<?php /**
 * 
 */
require_once 'Conexion.php';
require_once 'class.mensajes.php';
require_once 'class.encriptacion.php';

class Users
{
	public $id_usuario;
	public $nombre;
	public $apellido;
	public $email;

	private $pdo;


	function __construct()
	{
		$conexion = new Conexion();
		$this->pdo = $conexion->pdo;
	}

	function checkEmail($email) 
	{
	   if ( strpos($email, '@') !== false ) {
	      $split = explode('@', $email);
	      return (strpos($split['1'], '.') !== false ? true : false);
	   }
	   else {
	      return false;
	   }
	}

	function login($email, $pass)
	{
		$mensaje = new Mensajes(0, '');

		if(!Self::checkEmail($email))
		{
			$mensaje->mensaje = 'El email es incorrecto';
		}else{
			$stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);

			if ( $stmt->execute() && $stmt->rowCount() > 0 ) {
				$stmt = $stmt->fetch();

				if (password_verify($pass, $stmt["Pass"])) {
					session_start();

					$this->nombre = $stmt["Nombre"];
					$this->apellido = $stmt["Apellido"];
					$this->email = $stmt["Email"];
					$this->id_usuario = Encriptacion::encriptar($stmt["idUsuario"]);

					$_SESSION["Usuario"] = json_encode($this);

					$mensaje->cod_mensaje = -1;
					$mensaje->mensaje = 'Login correcto';
				}else{
					$mensaje->mensaje = 'El password es incorrecto';
				}
			}else{
				$mensaje->mensaje = 'No email no está registrado';
			}
		}
		return json_encode($mensaje);
	}

	function registro($nombre, $apellido, $email, $pass)
	{
		$mensaje = new Mensajes(0, '');

		if(!Self::checkEmail($email)){
			$mensaje->mensaje = 'El email es incorrecto';
			return json_encode($mensaje);
		}

		$stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
		$stmt->bindParam(":email", $email, PDO::PARAM_STR);
		$stmt->execute();

		if ( $stmt->rowCount() == 0 ) {

			$hash = password_hash($pass, PASSWORD_DEFAULT);
			$estado = 1;

			$stmt = $this->pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, pass, activacion, estado) VALUES (:nombre, :apellido, :email, :pass, :activacion, :estado)");

			$stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
			$stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
			$stmt->bindParam(":pass", $hash, PDO::PARAM_STR);
			$stmt->bindParam(":activacion", $hash, PDO::PARAM_STR);
			$stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
				
			if ( $stmt->execute() ) 
			{
				$this->nombre = $nombre;
				$this->apellido = $apellido;
				$this->email = $email;

				$mensaje->cod_mensaje = -1;
				$mensaje->mensaje = 'Registro correcto';
			} else {
				$mensaje->mensaje = 'Hubo un error';
			}
		}else{
			$mensaje->mensaje = 'El email ya existe';
		}

		return json_encode($mensaje);
	}

	public function addUser()
	{
		//MAGIA
		if(!$this->checkEmail($this->email))
		{
			echo 'El email no es valido';
			return;
		}

		if($this->checkEmailDB($this->email))
		{
			$pass = md5(rand(0,1000));
			$hash = password_hash($pass, PASSWORD_DEFAULT);
			$estado = 1;

			$stmt = $this->pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, pass, activacion, estado) VALUES (:nombre, :apellido, :email, :pass, :activacion, :estado)");

			$stmt->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
			$stmt->bindParam(":apellido", $this->apellido, PDO::PARAM_STR);
			$stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
			$stmt->bindParam(":pass", $hash, PDO::PARAM_STR);
			$stmt->bindParam(":activacion", $hash, PDO::PARAM_STR);
			$stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
				
			if ( $stmt->execute() ) 
			{
				echo 'Registro correcto';
			} else {
				echo 'Hubo un error';
			}
		}else{
			echo 'El email ya existe en la base de datos';
		}

		$rand = rand(0,100);
	}

	private function checkEmailDB($email)
	{
		//esto checkea que el email exista en la base de datos
		$stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
		$stmt->bindParam(":email", $email, PDO::PARAM_STR);
		$stmt->execute();
		if($stmt->rowCount() == 0)
			return true;
		return false;
	}

	function getDatosUsuario()
	{
		$sesionUsuario = $_SESSION["Usuario"];
		$sesionUsuario = json_decode($sesionUsuario);

		$id_usuario = $sesionUsuario->id_usuario;

		$stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE idUsuario = :id_usuario");
		$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
	}

	function getUsuarioById($idEnc)
	{
		$id_usuario = Encriptacion::desencriptar($idEnc);

		$stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE idUsuario = :id_usuario");
		$stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
		if ( $stmt->execute() ) 
		{
			$row = $stmt->fetch();
			$this->nombre = $row['Nombre'];
			$this->apellido = $row['Apellido'];
			$this->email = $row['Email'];
		}
	}

	function getUsuarios()
	{
		$stmt = $this->pdo->prepare("SELECT * FROM usuarios");
		$stmt->execute();

		$usuarios = array();
		$i = 0;

		while ( $row = $stmt->fetch() ) 
		{
			$myUsuario = new Users();

			$myUsuario->nombre = $row['Nombre'];
			$myUsuario->apellido = $row['Apellido'];
			$myUsuario->email = $row['Email'];
			$myUsuario->id_usuario = Encriptacion::encriptar($row['idUsuario']);

			$usuarios[$i] = $myUsuario;
			$i++;
		}
		
		return $usuarios;
	}

	function editar($nombre, $apellido, $email, $idEnc)
	{
		$mensaje = new Mensajes(0, '');

		if(!Self::checkEmail($email)){
			$mensaje->mensaje = 'El email es incorrecto';
			return json_encode($mensaje);
		}

		$id_usuario = Encriptacion::desencriptar($idEnc);

		$stmt = $this->pdo->prepare("UPDATE usuarios SET Email = :email, Nombre = :nombre, Apellido = :apellido WHERE idUsuario = :id_usuario");
		$stmt->bindParam(":email", $email, PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
		$stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
		if ( $stmt->execute() ) 
		{
			$this->nombre = $nombre;
			$this->apellido = $apellido;
			$this->email = $email;

			$mensaje->cod_mensaje = -1;
			$mensaje->mensaje = 'Editado correctamente';
		} else {
			$mensaje->mensaje = 'Hubo un error';
		}

		return json_encode($mensaje);
	}

	function eliminarUsuario($idEnc)
	{
		$id_usuario = Encriptacion::desencriptar($idEnc);
		$stmt = $this->pdo->prepare("DELETE FROM usuarios WHERE idUsuario = :id_usuario");
		$stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
		if ($stmt->execute())
		{
			$mensaje->cod_mensaje = -2;
			$mensaje->mensaje = 'Eliminado correctamente';
		}
		else{
			$mensaje->mensaje = "Hubo un error";
		}
	}

	public function getMyUser()
	{
		$usuario = $_SESSION['Usuario'];
		$user = json_decode($usuario);
		
		$user->id_usuario;
		//$this->getUsuarioById($ser->id_usuario);
		$id_usuario = encriptacion::desencriptar($user->id_usuario);
		return $id_usuario;
	}

	function logout()
	{
		session_start();
		setcookie(session_name(), '', time() - 42000, '/'); 
		unset( $_SESSION );
		session_destroy();

		$mensaje = new Mensajes(-1, 'Logout correcto');
		return json_encode( $mensaje );
	}
} 

?>
