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
								<div class="card-header">
									<h5>Banque : <span univ><?= $bank->denomination ?></span> | Login : <?= $bank->login ?> </h5>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="p-3">
											<form id="f-profil" method="post">
												<input type="hidden" name="type" value="banque">
												<div class="form-group">
													<input value="<?= $bank->denomination ?>" class="form-control" type="text" name="banque" placeholder="Banque">
													<em class="text-danger" name='banque'></em>
												</div>
												<p class="m-0 p-0"><em msg3></em></p>
												<div class="form-group">
													<button class="btn btn-warning text-white"><i class="fa fa-edit"></i> Modifier le nom</button>
												</div>
											</form>
											<form action="" method="post" id="f-pass">
												<input type="hidden" name="type" value="banque">
												<div class="form-group">
													<input class="form-control" type="password" name="pass" placeholder="Mot de passe actuel">
													<em class="text-danger" name='pass'></em>
												</div>
												<div class="form-group">
													<input class="form-control" type="password" name="new" placeholder="Nouveau mot passe actuel">
													<em class="text-danger" name='new'></em>
												</div>
												<div class="form-group">
													<input class="form-control" type="password" name="cnew" placeholder="Confirmer">
													<em class="text-danger" name='cnew'></em>
												</div>
												<p><em msg2></em></p>
												<div class="form-group">
													<button class="btn btn-warning text-white"><i class="fa fa-edit"></i> Modifier le mot de passe</button>
												</div>
											</form>
										</div>

									</div>
									<div class="col-md-6">
										<div class="card-body">
											<div class="mb-3">
												<div image class="d-flex justify-content-center">
													<?php if (!empty($bank->logo)) { ?>
														<img width="100" height="100" src="<?= base_url($bank->logo) ?>" alt="">
													<?php } ?>
												</div>
											</div>
											<div class="">
												<p class="d-flex justify-content-center m-2 ">Ajouter un logo (.jpg, .png, .gif)</p>
												<form id="f-logo" method="post" enctype="multipart/form-data" action="">
													<input type="hidden" name="type" value="banque">
													<div class="form-group">
														<input id="file" style="display: none" required accept=".jpg,.png,.gif" class="form-control" type="file" name="logo" id="">
													</div>
													<div class="form-group m-0 p-0 d-flex justify-content-center">
														<em msg></em>
													</div>
													<div class="form-group d-flex justify-content-center">
														<label for='file' class="btn btn-warning text-white"> <i class="fa fa-upload"></i> Ajouter</label>
													</div>
												</form>
											</div>
										</div>
									</div>
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

			form = $('#f-logo');

			form.change(function() {
				upload();
			})

			function upload() {
				var btn = $('label[for="file"]', form);
				btn.html('<i class="fa fa-spinner fa-spin"></i>');
				txt = '<i class="fa fa-upload"></i> Ajouter';
				$.ajax({
					url: '<?= site_url('ajax/update-logo') ?>',
					type: 'POST',
					data: new FormData(form[0]),
					processData: false,
					contentType: false,
					success: function(res) {
						btn.attr('disabled', false).html(txt);
						form.get(0).reset();
						res = $.parseJSON(res);
						var img = `<img width="100" height="100" src="${res.logo}" alt="">`;
						if (res.status) {
							$('div[image]').html(img);
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
			}

			$('#f-pass').submit(function(e) {
				e.preventDefault();
				var form = $(this);
				var btn = $(':submit', form);
				var cl = btn.find('i').prop('class');
				btn.attr('disabled', true).find('i').removeClass().addClass('fa fa-spinner fa-spin');
				$(`em[name]`).html('');
				$(`em[msg2]`).html('');

				$.post('<?= site_url('ajax/update-pass') ?>', form.serialize(), function(data) {
					data = JSON.parse(data);
					if (data.status) {
						$(`em[msg2]`).removeClass().addClass('text-success small').html(data.message);
						form.get(0).reset();
					} else {
						var err = data.error;
						for (i in err) {
							$(`em[name=${i}]`).html(err[i]);
						}
						$(`em[msg2]`).removeClass().addClass('text-danger small').html(data.message);
					}
					btn.attr('disabled', false).find('i').removeClass().addClass(cl);
				})
			});

			$('#f-profil').submit(function(e) {
				e.preventDefault();
				var form = $(this);
				var btn = $(':submit', form);
				var cl = btn.find('i').prop('class');
				btn.attr('disabled', true).find('i').removeClass().addClass('fa fa-spinner fa-spin');
				$(`em[name]`).html('');
				$(`em[msg3]`).html('');

				$.post('<?= site_url('ajax/update-profil') ?>', form.serialize(), function(data) {
					data = JSON.parse(data);
					if (data.status) {
						$(`em[msg3]`).removeClass().addClass('text-success small').html(data.message);
						var n = $(':input[name=banque]', form).val();
						$('span[univ]').html(n)

					} else {
						var err = data.error;
						for (i in err) {
							$(`em[name=${i}]`).html(err[i]);
						}
						$(`em[msg3]`).removeClass().addClass('text-danger small').html(data.message);
					}
					btn.attr('disabled', false).find('i').removeClass().addClass(cl);
				})
			});


		})
	</script>
</body>

</html>