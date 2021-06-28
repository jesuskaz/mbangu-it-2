<!DOCTYPE html>
<html lang="en">

<?php include("heade.php"); ?>

<body>
	<div class="loader"></div>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<div class="navbar-bg"></div>
			<?php include("nav.php"); ?>
			<div class="main-sidebar sidebar-style-2">
				<?php include("sidebar.php"); ?>
			</div>
		</div>

		<div class="main-content">
			<section class="section">
				<div class="section-body">
					<div class="row">

						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<h5>Université : <?= $univ->nomUniversite ?></h5>
									<h5>Login : <?= $univ->login ?> </h5>

									<?php if (!empty($univ->logo)) { ?>
										<p image>
											<img width="100" height="100" src="<?= base_url($univ->logo) ?>" alt="">
										</p>
									<?php } ?>
									<hr>
									<p>Ajouter un logo (.jpg, .png, .gif)</p>

									<form id="f-logo" method="post" enctype="multipart/form-data" action="">
										<div class="form-group">
											<input required accept=".jpg,.png,.gif" class="form-control" type="file" name="logo" id="">
										</div>
										<div class="form-group">
											<em msg></em>
										</div>
										<div class="form-group">
											<button class="btn btn-info"> <i class="fa fa-upload"></i> Ajouter</button>
										</div>
									</form>

								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<div class="settingSidebar">
				<a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
				</a>
				<div class="settingSidebar-body ps-container ps-theme-default">
					<div class=" fade show active">
						<div class="setting-panel-header">Setting Panel
						</div>
						<div class="p-15 border-bottom">
							<h6 class="font-medium m-b-10">Select Layout</h6>
							<div class="selectgroup layout-color w-50">
								<label class="selectgroup-item">
									<input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
									<span class="selectgroup-button">Light</span>
								</label>
								<label class="selectgroup-item">
									<input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
									<span class="selectgroup-button">Dark</span>
								</label>
							</div>
						</div>
						<div class="p-15 border-bottom">
							<h6 class="font-medium m-b-10">Sidebar Color</h6>
							<div class="selectgroup selectgroup-pills sidebar-color">
								<label class="selectgroup-item">
									<input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
									<span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip" data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
								</label>
								<label class="selectgroup-item">
									<input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
									<span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip" data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
								</label>
							</div>
						</div>
						<div class="p-15 border-bottom">
							<h6 class="font-medium m-b-10">Color Theme</h6>
							<div class="theme-setting-options">
								<ul class="choose-theme list-unstyled mb-0">
									<li title="white" class="active">
										<div class="white"></div>
									</li>
									<li title="cyan">
										<div class="cyan"></div>
									</li>
									<li title="black">
										<div class="black"></div>
									</li>
									<li title="purple">
										<div class="purple"></div>
									</li>
									<li title="orange">
										<div class="orange"></div>
									</li>
									<li title="green">
										<div class="green"></div>
									</li>
									<li title="red">
										<div class="red"></div>
									</li>
								</ul>
							</div>
						</div>
						<div class="p-15 border-bottom">
							<div class="theme-setting-options">
								<label class="m-b-0">
									<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="mini_sidebar_setting">
									<span class="custom-switch-indicator"></span>
									<span class="control-label p-l-10">Mini Sidebar</span>
								</label>
							</div>
						</div>
						<div class="p-15 border-bottom">
							<div class="theme-setting-options">
								<label class="m-b-0">
									<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="sticky_header_setting">
									<span class="custom-switch-indicator"></span>
									<span class="control-label p-l-10">Sticky Header</span>
								</label>
							</div>
						</div>
						<div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
							<a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
								<i class="fas fa-undo"></i> Restore Default
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<?php include("footer.php"); ?>

	<script>
		$(function() {
			$('#f-logo').submit(function(e) {
				e.preventDefault();
				var form = $(this);
				var btn = $(':submit', form);
				btn.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
				txt = '<i class="fa fa-upload"></i> Ajouter';
				$.ajax({
					url: '<?= site_url('ajax/update-logo') ?>',
					type: 'POST',
					data: new FormData(this),
					processData: false,
					contentType: false,
					success: function(res) {
						btn.attr('disabled', false).html(txt);
						form.get(0).reset();
						res = $.parseJSON(res);
						if (res.status) {
							$('p[image]').find('img').attr('src', res.logo);
							$('em[msg]').removeClass().addClass('text-success').html(res.message).fadeIn().delay(5000).fadeOut();
						} else {
							$('em[msg]').removeClass().addClass('text-danger').html(res.message).fadeIn().delay(5000).fadeOut();
						}
					},
					error: function() {
						btn.attr('disabled', false).html(txt);
						$('em[msg]').removeClass().addClass('text-danger').html('erreur').fadeIn();
					}
				})

			})
		})
	</script>
</body>

</html>