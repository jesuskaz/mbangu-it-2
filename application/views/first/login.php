<!DOCTYPE HTML>
<html>

<head>
	<meta charset="UTF-8">
	<title>Mbangu Pay | Connexion</title>
	<?php include 'header.php' ?>

	<link rel="stylesheet" href="<?php echo base_url() . 'assets/css/app.min.css'; ?>">

	<link rel="stylesheet" href="<?= base_url('foot/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?= base_url('foot/css/animate.css'); ?>">
	<link rel="stylesheet" href="<?= base_url('foot/css/style.css'); ?>">

</head>

<body class="style-2">
	<div class="fh5co-loader">
	</div>
	<div id="page">
		<?php include 'nav.php' ?>
		<div class="container mb-5">
			<div class="row">
				<div class="col-md-4">
					<form method="POST" class="fh5co-form animate-box" data-animate-effect="fadeInLeft">
						<h2>Connexion</h2>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Login" name="login">
							<em class="text-danger small" name="login"></em>
						</div>
						<div class="form-group">
							<input type="password" class="form-control" placeholder="Mot de Passe" name="code">
							<em class="text-danger small" name="code"></em>
						</div>
						<div class="form-group m-0 p-0">
							<label for="remember"><input type="checkbox" id="remember"> Se Souvenir de moi</label>
						</div>
						<p><em class="text-danger small" msg></em></p>
						<div class="form-group ">
							<button type="submit" class="btn btn-warning">
								<i class="fa fa-unlock"></i>
								Se Connecter</button>
						</div>
						<div class="form-group">
							<p>Pas de Compte? <a href="sign-up2.html">S'inscrire</a> | <a href="forgot2.html">Mot de passe Oublié?</a></p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php include 'footer.php' ?>

	<script>
		$(function() {
			$('form').submit(function(e) {
				e.preventDefault();
				var form = $(this);
				var btn = $(':submit', form);
				var txt = btn.html();
				btn.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Connexion');
				$(`em[name]`).html('');
				$(`em[msg]`).html('');

				$.post('<?= site_url('ajax/login') ?>', form.serialize(), function(log) {
					log = JSON.parse(log);
					if (log.status) {
						btn.attr('disabled', true).html('<i class="fa fa-check-circle"></i> Connexion');
						form.get(0).reset();
						setTimeout(() => {
							location.assign(log.url);
						}, 500);
					} else {
						btn.attr('disabled', false).html(txt);
						$('em[msg]').html(log.message).fadeIn('slow');
						var err = log.error;
						for (i in err) {
							$(`em[name=${i}]`).html(err[i]);
							console.log(i)
						}
					}
				})
			})
		})
	</script>
</body>
</html>