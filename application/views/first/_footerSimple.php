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