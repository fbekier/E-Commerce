<?php 
	require 'share/header.php';
	require_once 'clases/class.reportes.php';

	$reporte = new Reportes();
	$misCompras = $reporte->misCompras();
	echo '<pre>';
	print_r($misCompras);
	echo '</pre>';
?>
<div class="container">
	<h1>Mis compras</h1>
	<table class="table table-hover">
		<thead>
			<th>Producto</th>
			<th>Precio</th>
			<th>Cantidad</th>
			<th>Fecha</th>
		</thead>
		<tbody>
			<?php foreach ($misCompras as $key => $value): ?>
				<tr>
					<td><?php echo $value['producto'] ?></td>
					<td><?php echo $value['precio'] ?></td>
					<td><?php echo $value['cantidad'] ?></td>
					<td><?php echo $value['fecha'] ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
<?php require 'share/footer.php'; ?>