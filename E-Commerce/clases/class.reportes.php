<?php
/**
* 
*/
require_once 'Conexion.php';
require_once 'class.users.php';

class Reportes
{
	private $pdo;

	function __construct()
	{
		$conexion = new Conexion();
		$this->pdo = $conexion->pdo;
	}

	public function misCompras()
	{
		$id_usuario = Users::getMyUser();

		$stmt = $this->pdo->prepare("SELECT p.Nombre 'producto'
									  ,p.Precio 'precio'
								      ,car.fecha 'fecha'
								      ,c.id_compra 'id_compra'
								      ,c.cantidad 'cantidad'
								FROM compras c
								JOIN productos p ON p.idProducto = c.id_producto
								JOIN carrito car ON car.id_carrito = c.id_carrito
								WHERE c.id_usuario = :id_usuario");
		$stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
		$stmt->execute();
		
		$misCompras = array();

		while ($row = $stmt->fetch()) {
			array_push($misCompras, $row);
		}

		return $misCompras;
	}
} 

?>