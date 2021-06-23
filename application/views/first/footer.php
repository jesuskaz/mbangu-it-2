<div id="fh5co-register" style="background-image: url(<?=base_url('first/images/img_bg_2.jpg'); ?>);">
		<div class="overlay"></div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2 animate-box">
				<div class="date-counter text-center">
					<h2> Fini les longues files d’attente</h2>
					<h3>dans les agences pour percevoir les frais</h3>
					<div class="simply-countdown simply-countdown-one"></div>
					<p><strong>Crée votre compte</strong></p>
					<p><a href="#" class="btn btn-primary btn-lg btn-reg">Register Now!</a></p>
				</div>
			</div>
		</div>
	</div>

	<div id="fh5co-gallery" class="fh5co-bg-section">
		<div class="row text-center">
			<h2><span>Gallerie Mbangu </span></h2>
		</div>
		<div class="row">
			<div class="col-md-3 col-padded">
				<a href="#" class="gallery" style="background-image: url(<?=base_url('first/images/project-5.jpg'); ?>);"></a>
			</div>
			<div class="col-md-3 col-padded">
				<a href="#" class="gallery" style="background-image: url(<?=base_url('first/images/project-2.jpg'); ?>);"></a>
			</div>
			<div class="col-md-3 col-padded">
				<a href="#" class="gallery" style="background-image: url(<?=base_url('first/images/project-3.jpg'); ?>);"></a>
			</div>
			<div class="col-md-3 col-padded">
				<a href="#" class="gallery" style="background-image: url(<?=base_url('first/images/project-4.jpg'); ?>);"></a>
			</div>
		</div>
	</div>

	<footer id="fh5co-footer" role="contentinfo" style="background-image: url(<?=base_url('first/images/img_bg_4.jpg'); ?>);">
		<div class="overlay"></div>
		<div class="container">
			<div class="row row-pb-md">
				<div class="col-md-3 fh5co-widget">
					<h3>A Propos de Mbangu pay </h3>
					<p>Mbangupay est une solution informatique qui répondra correctement aux besoins des étudiants et élèves, de la banque aussi bien des universités, Instituts supérieurs, Ecoles…  .</p>
				</div>
				<div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
					<h3>Administrateurs</h3>
					<ul class="fh5co-footer-links">
						<li><a href="<?=site_url('AdminCredential/');?>">Université</a></li>
						<li><a href="<?=site_url('AdminCredential/ecole');?>">Ecole</a></li>
                        <li><a href="<?=site_url('AdminCredential/loginBanque');?>">Admin</a></li>
                        <li><a href="<?=site_url('AdminCredential/loginAdmin');?>">Admin1</a></li>
					</ul>
				</div>

				<div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
					<h3>Mbangu pay</h3>
					<ul class="fh5co-footer-links">
						<li><a href="<?=site_url('index/');?>">Accueil</a></li>
						<li><a href="<?=site_url('index/about');?>">A propo de nous</a></li>
						<li><a href="<?=site_url();?>">Information</a></li>
						<li><a href="<?=site_url('index/contact');?>">Contact</a></li>
					</ul>
				</div>
			</div>

			<div class="row copyright">
				<div class="col-md-12 text-center">
					<p>
						<small class="block">&copy;Mbangu pay 2021. </small>
					</p>
				</div>
			</div>
		</div>
	</footer>
	</div>
	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
	</div>
	<!-- jQuery -->
	<script src="<?=base_url('first/js/jquery.min.js'); ?>"></script>
	<!-- jQuery Easing -->
	<script src="<?=base_url('first/js/jquery.easing.1.3.js'); ?>"></script>
	<!-- Bootstrap -->
	<script src="<?=base_url('first/js/bootstrap.min.js'); ?>"></script>
	<!-- Waypoints -->
	<script src="<?=base_url('first/js/jquery.waypoints.min.js'); ?>"></script>
	<!-- Stellar Parallax -->
	<script src="<?=base_url('first/js/jquery.stellar.min.js'); ?>"></script>
	<!-- Carousel -->
	<script src="<?=base_url('first/js/owl.carousel.min.js'); ?>"></script>
	<!-- Flexslider -->
	<script src="<?=base_url('first/js/jquery.flexslider-min.js'); ?>"></script>
	<!-- countTo -->
	<script src="<?=base_url('first/js/jquery.countTo.js'); ?>"></script>
	<!-- Magnific Popup -->
	<script src="<?=base_url('first/js/jquery.magnific-popup.min.js'); ?>"></script>
	<script src="<?=base_url('first/js/magnific-popup-options.js'); ?>"></script>
	<!-- Count Down -->
	<script src="<?=base_url('first/js/simplyCountdown.js'); ?>"></script>
	<!-- Main -->
	<script src="<?=base_url('first/js/main.js'); ?>"></script>
	<script>
    var d = new Date(new Date().getTime() + 1000 * 120 * 120 * 2000);

    // default example
    simplyCountdown('.simply-countdown-one', {
        year: d.getFullYear(),
        month: d.getMonth() + 1,
        day: d.getDate()
    });

    //jQuery example
    $('#simply-countdown-losange').simplyCountdown({
        year: d.getFullYear(),
        month: d.getMonth() + 1,
        day: d.getDate(),
        enableUtc: false
    });
	</script>
	</body>
</html>