<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<footer id="fh5co-footer" class="p-0" role="contentinfo" style="background-image: url(<?= base_url('first/images/img_bg_4.jpg'); ?>);">
	<div class="overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-6 fh5co-widget">
				<h3>A Propos de Mbangu pay </h3>
				<p>MbanguPay est une solution informatique qui répondra correctement aux besoins des étudiants et élèves, de la banque aussi bien des universités, Instituts supérieurs, Ecoles… .</p>
			</div>
			<div class="col-md-6 fh5co-widget">
				<h3>MbanguPay</h3>
				<ul class="fh5co-footer-links">
					<li><a href="<?= site_url('index/'); ?>">Accueil</a></li>
					<li><a href="<?= site_url('index/about'); ?>">A propo de nous</a></li>
					<li><a href="<?= site_url(); ?>">Information</a></li>
					<li><a href="<?= site_url('index/contact'); ?>">Contact</a></li>
				</ul>
			</div>
		</div>
		<div class="row copyright">
			<div class="col-md-12 text-center">
				<p>
					<small class="block">&copy;MbanguPay 2021. </small>
				</p>
			</div>
		</div>
	</div>
</footer>
<div class="gototop js-top">
	<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
</div>
<script src="<?= base_url('first/js/jquery.min.js'); ?>"></script>
<script src="<?= base_url('first/js/jquery.easing.1.3.js'); ?>"></script>
<script src="<?= base_url('first/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('first/js/jquery.waypoints.min.js'); ?>"></script>
<script src="<?= base_url('first/js/jquery.stellar.min.js'); ?>"></script>
<script src="<?= base_url('first/js/owl.carousel.min.js'); ?>"></script>
<script src="<?= base_url('first/js/jquery.flexslider-min.js'); ?>"></script>
<script src="<?= base_url('first/js/jquery.countTo.js'); ?>"></script>
<script src="<?= base_url('first/js/jquery.magnific-popup.min.js'); ?>"></script>
<script src="<?= base_url('first/js/magnific-popup-options.js'); ?>"></script>
<script src="<?= base_url('first/js/simplyCountdown.js'); ?>"></script>
<script src="<?= base_url('first/js/main.js'); ?>"></script>
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