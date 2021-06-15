
<!DOCTYPE html>
<?php require 'header.php';?>
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<body class="style-2">
	<div class="container">
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-4">
				<!-- Start Sign In Form -->
				<form action="<?php echo site_url('AdminCredential/schoolConnexion'); ?>" method="POST" class="fh5co-form animate-box" data-animate-effect="fadeInLeft">
					<h2>Sign In</h2>
					<div class="form-group">
					<div class="d-block">
                     <label for="username" class="sr-only">Username</label>
                    </div>
						<input type="text" class="form-control" id="username" placeholder="Login" name="login" required="" oninvalid="this.setCustomValidity('Veuillez saisir votre login')" oninput="setCustomValidity('')">
					</div>
					<div class="form-group">
						<label for="password" class="sr-only">Password</label>
						<input type="password" class="form-control" id="password" placeholder="Mot de Passe" name="code" required="" oninvalid="this.setCustomValidity('Veuillez saisir votre mot de passe')" oninput="setCustomValidity('')">
					</div>
					<div class="form-group">
						<label for="remember"><input type="checkbox" id="remember"> Se Souvenir de moi</label>
					</div>
					<div class="form-group">
						<p>Pas de Compte? <a href="sign-up2.html">S'inscrire</a> | <a href="forgot2.html">Mot de passe Oublié?</a></p>
					</div>
					<div class="form-group">
						<input type="submit" value="Se Connecter" class="btn btn-primary">
					</div>
					<p><b><?php if(isset($error)) echo "<font color=red>".$error."</font>"; ?></b></p>
				</form>
				<!-- END Sign In Form -->

			</div>
		</div>
		<?php require 'footer.php';?>

