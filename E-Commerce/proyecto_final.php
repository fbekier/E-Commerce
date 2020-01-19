<?php
require 'share/header.php';
require_once 'clases/Conexion.php';
require_once 'clases/Producto.php';
require_once 'clases/Carrito.php';
$conexion = new Conexion();

//$arr = array('nombre' => 'dio', 'apellido' => 'azar' );
//$arrSerializado = serialize($arr);
//var_dump($arrSerializado);
//var_dump(unserialize($arrSerializado));
//die();
//$carrito = array();
//$p1 = new Producto(1, $conexion->pdo);
//$p2 = new Producto(2, $conexion->pdo);
//$p3 = new Producto(3, $conexion->pdo);
//$p4 = new Producto(4, $conexion->pdo);
//$p5 = new Producto(5, $conexion->pdo);
//$p6 = new Producto(6, $conexion->pdo);
//$carrito[1] = $p1;
//$carrito[2] = $p2;
//$carrito[3] = $p3;
//$carrito[4] = $p4;
//$carrito[5] = $p5;
//$carrito[6] = $p6;
//echo '<pre>';
//print_r($carrito);
//echo '</pre>';
//var_dump($_SESSION['carrito']);die();
//var_dump($_SESSION);
if(isset($_SESSION['carrito'])){
	$carrito = unserialize($_SESSION['carrito']);
}else{
	// si no esta abierta la sesion por primera vez crea el objeto ticket
	$carrito = new Carrito();
}

if(!empty($_GET['codigo_agregar'])){
	$p = new Producto($_GET['codigo_agregar'],$conexion->pdo);
	$carrito->agregar($p);
}

if(!empty($_GET['codigo_quitar'])){
	$p = new Producto($_GET['codigo_quitar'],$conexion->pdo);
	$carrito->quitar($p);
}

if(isset($_GET['codigo_quitar_todo'])){
	$carrito->quitarTodo();
	var_dump($carrito);
}

if(!empty($_GET['comprar'])){
	if($_GET['comprar'] == 'ok')
	{
		$carrito->comprar();
	}
}

echo '<pre>';
print_r($carrito);
echo '</pre>';

?>
<div class="container">
	<table class="table">
		<tr>
			<td valign="top" align="center">
				<h1>Listado Productos</h1>
				<?php include("reporte.php");?>
			</td>
			<td valign="top" align="center">
				<h1>Ticket</h1>
				<table class="table">
					<tr>
						<th>C&oacute;digo</th>
						<th>Nombre</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th>Total</th>
						<th>Quitar</th>
					</tr>
				<?php $carrito->imprimir();?>
				</table>
				<a class="btn btn-primary" href="?comprar=ok">Comprar</a>
				<a class="btn btn-danger" href="?codigo_quitar_todo=0">Borrar carrito</a>
			</td>

		</tr>

	</table>
</div>
<?php
	$_SESSION['carrito'] = serialize($carrito);
?>

<?php require_once 'share/footer.php' ?>