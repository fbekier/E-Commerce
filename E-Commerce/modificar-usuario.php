<?php require_once 'share/header.php' ?>
<?php 
	require 'clases/class.users.php';

	$id = $_GET['id'];

	$usuario = new Users();
	$usuario->getUsuarioById($id);	
	
?>
	<div class="container">
	  	<h3>Modificar usuario</h3>
	  	
	  	<form action="javascript:void(0)">
	  		<div class="form-group">
	  			<label>Nombre</label>
	  			<input type="text" class="form-control" id="nombre" value="<?php echo $usuario->nombre; ?>">
	  		</div>
	  		<div class="form-group">
	  			<label>Apellido</label>
	  			<input type="text" class="form-control" id="apellido" value="<?php echo $usuario->apellido; ?>">
	  		</div>
	  		<div class="form-group">
			    <label>Email</label>
			    <input type="email" class="form-control" id="email" value="<?php echo $usuario->email; ?>">
			</div>
			<input type="hidden" id="idEnc" value="<?php echo $id; ?>">
			<div class="form-group">
				<button type="button" class="btn btn-primary" onclick="editarUsuario()">Modificar</button>
			</div>
	  	</form>

	</div>

<?php require_once 'share/footer.php' ?>
<script src="scripts/modificar-usuario.js"></script>