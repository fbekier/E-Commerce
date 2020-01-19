<?php

require_once 'Conexion.php';
require_once 'Producto.php';
require_once 'class.users.php';

class Carrito
{

	public $items;
	
	function __construct()
	{
		$this->items = array();
	}
	
	function agregar($producto)
	{
		if(isset($this->items[$producto->codigo]))
			$this->items[$producto->codigo]->cantidad++;
		else
			$this->items[$producto->codigo] = $producto;
	}
	
	function quitar($producto)
	{
		if(isset($this->items[$producto->codigo]))
		{
			if($this->items[$producto->codigo]->cantidad <= 1)
				unset($this->items[$producto->codigo]);
			else
				$this->items[$producto->codigo]->cantidad--;
		}
	}

	function quitarTodo()
	{
		$this->items = null;
	}
	
	function imprimir()
	{
		// aca recorro la coleccion items, donde cada objeto de la
		// coleccion es asignado a la variable $valor
		$cantProductos = 0;		//inicializo la variable donde acumulo la cantidad de productos para imprimir al final
		$total = 0;				//inicializo la variable donde acumulo el total facturado para imprimir al final

		if(!empty($this->items)) 
		{
			foreach($this->items as $valor)
			{
				echo("<tr>");
				echo("<td>$valor->codigo</td>");
				echo("<td>$valor->nombre</td>");
				echo("<td>$valor->cantidad</td>");
				echo("<td>$valor->precio</td>");									
				echo("<td>".$valor->cantidad*$valor->precio."</td>");				
				echo("<td align='center'><a href='?codigo_quitar=$valor->codigo'><img src='images/borrar.jpg' border=0></a></td>");
				echo("</tr>");
				
				$cantProductos += $valor->cantidad;
				$total += $valor->cantidad * $valor->precio;
			}
		}
	?>
		<tr>
			<td> - </td>
			<td> Total: </td>
			<td> <b><?php echo $cantProductos; ?> </b></td>
			<td> - </td>
			<td> <b><?php echo $total; ?> </b></td>
			<td> - </td>
		</tr>		
	<?php
	}

	function getProductos()
	{
		
	}

	function comprar()
	{
		if($this->items == null || count($this->items) < 1){
			echo 'No hay nada en el carrito';
			return false;
		}
		
		$this->insertCarrito();
		//session_start();
		//$_SESSION['carrito'] = unserialize($_SESSION['carrito']);
		//$_SESSION['carrito'] = "";
		//var_dump($_SESSION['carrito']);
		//session_unset($_SESSION['carrito']);
		//unset( $_SESSION['carrito'] );
		$this->quitarTodo($producto, $producto->cantidad);
		
		header('location:compra-exitosa.php');
	}

	private function insertCarrito()
	{
		$conexion = new Conexion();
		$pdo = $conexion->pdo;

		$id_usuario = Users::getMyUser();

		$stmt = $pdo->prepare("INSERT INTO carrito (fecha, id_usuario) VALUES(NOW(), :id_usuario)");
		$stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
		if($stmt->execute())
		{
			$stm = $pdo->prepare("SELECT id_carrito FROM carrito WHERE id_usuario = :id_usuario ORDER BY fecha DESC LIMIT 1");
			$stm->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
			$stm->execute();
			$params = $stm->fetch();
			$this->insertarProductos($params['id_carrito'], $pdo, $id_usuario);
		}
	}

	private function insertarProductos($id_carrito, $pdo, $id_usuario)
	{
		//echo '<pre>';
		//print_r($this->items);
		//echo '</pre>';

		foreach ($this->items as $producto) {
			//$producto = new Producto($producto->codigo, $pdo);
			//$producto->comprar();
			Producto::comprar($id_carrito, $id_usuario, $producto->cantidad, $producto->codigo, $pdo);
		}
	}

}

?>