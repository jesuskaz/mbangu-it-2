
<!DOCTYPE html>
	<?php include('header.php'); ?>
	<body class="style-2">
		<div class="container">
	<div class="row">
		<div class="col-md-4">
		<!-- Start Sign In Form -->
		<form action="#" class="fh5co-form animate-box" data-animate-effect="fadeInLeft">
			<h2>Sign In</h2>
			<div class="form-group">
				<label for="username" class="sr-only">Username</label>
				<input type="text" class="form-control" id="username" placeholder="Username" autocomplete="off">
			</div>
			<div class="form-group">
				<label for="password" class="sr-only">Password</label>
				<input type="password" class="form-control" id="password" placeholder="Password" autocomplete="off">
			</div>
			<div class="form-group">
				<label for="remember"><input type="checkbox" id="remember"> Se Souvenir de moi</label>
			</div>
			<div class="form-group">
				<p>Pas de Compte? <a href="sign-up2.html">S'inscrire</a> | <a href="forgot2.html">Mot de passe Oublié?</a></p>
			</div>
			<div class="form-group">
				<input type="submit" value="Sign In" class="btn btn-primary">
			</div>
		</form>
		<!-- END Sign In Form -->

		</div>
	</div>
<?php require 'footer.php';?>