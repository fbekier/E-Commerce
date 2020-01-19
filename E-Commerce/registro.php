<?php require_once 'share/header.php' ?>
	<div class="container">
	  	<h3>Registro</h3>
	  	
	  	<form>
			<div class="form-group">
			    <label>Email address</label>
			    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
			    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			</div>

			<div class="form-group">
			    <label>Nombre</label>
			    <input type="text" class="form-control" id="nombre" placeholder="Password">
			</div>

			<div class="form-group">
			    <label>Apellido</label>
			    <input type="text" class="form-control" id="apellido" placeholder="Password">
			</div>

			<div class="form-group">
			    <label>Password</label>
			    <input type="password" class="form-control" id="pass" placeholder="Password">
			</div>

			<button type="button" class="btn btn-primary" onclick="registro()">Submit</button>
		</form>

	</div>

<?php require_once 'share/footer.php' ?>
<script src="scripts/registro.js"></script>