<?php require_once 'share/header.php' ?>
	<?php
		//var_dump($_POST);
		//echo count($_POST);
		//if(isset($_POST['nombre']))
		
		if(count($_POST) == 3)
		{
			require_once 'clases/class.users.php';
			$user = new Users();
			$user->nombre = $_POST['nombre'];
			$user->email = $_POST['email'];
			$user->apellido = $_POST['apellido'];
			$user->addUser();
		}
	?>
	<div class="container">
	  	<h3>Agregar usuario</h3>
	  	
	  	<form action="" method="POST">
			<div class="form-group">
			    <label>Email address</label>
			    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
			    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			</div>

			<div class="form-group">
			    <label>Nombre</label>
			    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Password">
			</div>

			<div class="form-group">
			    <label>Apellido</label>
			    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Password">
			</div>

			<button type="submit" class="btn btn-primary">Submit</button>
		</form>

	</div>

<?php require_once 'share/footer.php' ?>
<script src="scripts/registro.js"></script>