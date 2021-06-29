<!DOCTYPE HTML>
<html>

<head>
	<meta charset="UTF-8">
	<title>Mbangu Pay</title>
	<?php include 'header.php' ?>
</head>

<body>
	<div class="fh5co-loader">
	</div>
	<div id="page">
		<?php include 'nav.php' ?>
		<aside id="fh5co-hero">
			<div class="flexslider">
				<ul class="slides">
					<li style="background-image: url(<?= base_url('first/images/img_bg_4.jpg'); ?>);">
						<div class="overlay-gradient"></div>
						<div class="container">
							<div class="row">
								<div class="col-md-8 col-md-offset-2 text-center slider-text">
									<div class="slider-text-inner">
										<h1 class="heading-section">Contact us</h1>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</aside>
		<div id="fh5co-contact">
			<div class="container">
				<div class="row">
					<div class="col-md-5 col-md-push-1 animate-box">
						<div class="fh5co-contact-info">
							<h3>Contact Information</h3>
							<ul>
								<li class="address">198 West 21th Street, <br> Av, Kapenda, C/ Lubumbashi RDC</li>
								<li class="phone"><a href="tel://243814512680">+243 81 4512680</a></li>
								<li class="email"><a href="mailto:info@mbangupay.com">info@yoursite.com</a></li>
								<li class="url"><a href="#">Mbangu pay</a></li>
							</ul>
						</div>

					</div>
					<div class="col-md-6 animate-box">
						<h3>Get In Touch</h3>
						<form action="#">
							<div class="row form-group">
								<div class="col-md-6">
									<!-- <label for="fname">First Name</label> -->
									<input type="text" id="fname" class="form-control" placeholder="Your firstname">
								</div>
								<div class="col-md-6">
									<!-- <label for="lname">Last Name</label> -->
									<input type="text" id="lname" class="form-control" placeholder="Your lastname">
								</div>
							</div>

							<div class="row form-group">
								<div class="col-md-12">
									<!-- <label for="email">Email</label> -->
									<input type="text" id="email" class="form-control" placeholder="Your email address">
								</div>
							</div>

							<div class="row form-group">
								<div class="col-md-12">
									<!-- <label for="subject">Subject</label> -->
									<input type="text" id="subject" class="form-control" placeholder="Your subject of this message">
								</div>
							</div>

							<div class="row form-group">
								<div class="col-md-12">
									<!-- <label for="message">Message</label> -->
									<textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="Say something about us"></textarea>
								</div>
							</div>
							<div class="form-group">
								<input type="submit" value="Send Message" class="btn btn-primary">
							</div>

						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
	<?php include 'footer.php' ?>
</body>

</html>