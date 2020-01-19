<?php
require_once 'clases/Conexion.php';

$conexion = new Conexion();

$pdo = $conexion->pdo;

// preparo la query para obtener los codigos de todas las peliculas
$stmt = $pdo->query("SELECT * FROM productos");

?>

<table class="table">
<tr>
	<th>Codigo</th>
	<th>Nombre</th>
	<th>Precio</th>
	<th>Comprar</th>
</tr>


<?php while($campos=$stmt->fetch(PDO::FETCH_ASSOC)){
	$producto = new Producto($campos['idProducto'],$conexion->pdo);
 ?>

	<tr>
		<td><?php echo $producto->codigo?></td>
		<td><?php echo $producto->nombre?></td>
		<td><?php echo $producto->precio?></td>
		
		<td><a href="?codigo_agregar=<?php echo $producto->codigo?>"><img src="images/carrito.jpg" width="92" height="27" border="0"></a></td>
	</tr>
	
<?php } ?>	
	
</table>