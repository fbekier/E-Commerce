<?php require_once 'share/header.php' ?>
<?php 
	require 'clases/class.users.php';
	
	if (isset($_SESSION["Usuario"])) //Solo puedo acceder a la lista de usuarios si está iniciada la Sesión
	{
		$users = new Users();
		$usuarios = $users->getUsuarios();
	}
	else
		header ('Location: index.php');
	
?>
	<div class="container">
	  	<h3>Usuarios</h3>
	  	
	  	<a href="agregar-usuario.php" class="btn btn-primary">Agregar usuario</a>
	  	<table class="table">
	  		<thead>
	  			<th>Nombre</th>
		  		<th>Apellido</th>
		  		<th>Email</th>
		  		<th>Modificar</th>
				<th>Eliminar</th>

	  		</thead>
	  		<tbody>
	  			<?php foreach ($usuarios as $key => $value): ?>
	  				<tr>
	  					<td><?php echo $value->nombre ?></td>
	  					<td><?php echo $value->apellido ?></td>
	  					<td><?php echo $value->email ?></td>
	  					<td><a href="modificar-usuario.php?id=<?php echo urlencode($value->id_usuario); ?>">Modificar</a></td>
						<td><a href="eliminar-usuario.php?id=<?php echo urlencode($value->id_usuario); ?>">Eliminar</a></td>  
	  				</tr>
	  			<?php endforeach ?>
	  		</tbody>
	  		
	  	</table>

	</div>

<?php require_once 'share/footer.php' ?>
<script src="scripts/login.js"></script>