<?php

class Producto 
{

	public $codigo;
	public $nombre;
	public $precio;
	public $cantidad;
	
	private $pdo;
	
	function __construct($cod,$pdo)
	{
		$this->pdo = $pdo;
		$stmt = $this->pdo->prepare("SELECT * FROM productos WHERE idProducto=:cod");
		$stmt->bindParam(':cod', $cod, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		// lo cargo en las propiedades
		$this->codigo   = $result['idProducto'];
		$this->nombre   = $result['Nombre'];
		$this->precio   = $result['Precio'];		
		$this->cantidad = 1;

		// en este caso como ya no voy a acceder mas a la tabla, cierro la conexion
		$this->pdo = null;
	}

	public function getProducto($cod)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM productos WHERE idProducto=$cod");
		$stmt->execute();
		
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		// lo cargo en las propiedades
		$this->codigo   = $result['idProducto'];
		$this->nombre   = $result['Nombre'];
		$this->precio   = $result['Precio'];		
		$this->cantidad = 1;

		// en este caso como ya no voy a acceder mas a la tabla, cierro la conexion
		$this->pdo = null;
	}

	public function comprar($id_carrito, $id_usuario, $cantidad, $id_producto, $pdo)
	{
		$stmt = $pdo->prepare("INSERT INTO compras (id_carrito, id_producto, id_usuario, cantidad) VALUES(:id_carrito, :id_producto, :id_usuario, :cantidad)");
		$stmt->bindParam(":id_carrito", $id_carrito, PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
		$stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
		$stmt->execute();
	}

}