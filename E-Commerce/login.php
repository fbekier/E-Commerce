<?php require_once 'share/header.php' ?>
	<div class="container">
	  	<h3>Login</h3>
	  	
	  	<form>
			<div class="form-group">
			    <label>Email address</label>
			    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
			    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			</div>

			<div class="form-group">
			    <label>Password</label>
			    <input type="password" class="form-control" id="pass" placeholder="Password">
			</div>
			
			<button type="button" class="btn btn-primary" onclick="login()">Submit</button>
		</form>

	</div>

<?php require_once 'share/footer.php' ?>
<script src="scripts/login.js"></script>