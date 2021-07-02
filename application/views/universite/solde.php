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
						<!-- <div class="col-md-12">
							<div class="card ">
								<div class="card-header">
									<h4>Statistiques</h4>
									<div class="card-header-action">
										<div class="form-group p-0 ">
											<select class="custom-select devise">
												<option value="">Choisissez la devise</option>
												<?php foreach ($devises as $de) : ?>
													<option value="<?= $de->iddevise ?>"><?= $de->nomDevise ?></option>
												<?php endforeach ?>
											</select>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-lg-9">
											<div id="graph"></div>
										</div>
										<div class="col-lg-3">
											<div class="row mt-5">
												<div class="col-7 col-xl-7 mb-3">Total Etudiant</div>
												<div class="col-5 col-xl-5 mb-3">
													<span class="badge badge-primary"> <b></b> </span>
												</div>

												<div class="col-7 col-xl-7 mb-3">
													<h6>Légende</h6>
													<h6 id='legende'></h6>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div> -->
						<div class="col-md-12">
							<div class="card ">
								<div class="card-header">
									<h4>Solde : <span frais></span></h4>
									<div class="card-header-action">
										<form id="f-solde" class="form-inline">
											<div class="form-group form-form-group-sm ">
												<input type="text" class="form-control form-change p-3 datepicker data rounded-0 w-100" name="date">
											</div>
											<div class="form-group form-group-sm p-0 ">
												<select name="frais" class="custom-select ml-1 m-0  custom-select-sm devise">
													<option value="">Choisissez le frais</option>
													<?php foreach ($frais as $de) : ?>
														<option value="<?= $de->idfrais ?>"><?= $de->designation ?></option>
													<?php endforeach ?>
												</select>
											</div>
										</form>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<h6 class="text-muted">Situation année académique <?= str_replace('| AA - ', '', $an) ?> </h6>
											<div class="">
												.
											</div>
										</div>
										<div class="col-md-6 p-5">
											<div id="res">
												<div class="text-center"><i class="spinner-border"></i></div>
											</div>
											<div class="float-right">
												<a detail class="btn btn-link" style="display: none" href="">Détails</a>
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
	<script type="text/javascript" src="<?= base_url('assets/js/daterangepicker/moment.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/daterangepicker/daterangepicker.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/daterangepicker/daterangepicker.css') ?>" />

	<script>
		$(function() {
			$('.datepicker').daterangepicker({
				locale: {
					format: 'YYYY/MM/DD'
				}
			});

			colors = ["#786BED", "#ff7694", "#21b0ff"];
			var options = {
				chart: {
					height: 300,
					type: "line",
					shadow: {
						enabled: true,
						color: "#000",
						top: 18,
						left: 7,
						blur: 10,
						opacity: 1
					},
					toolbar: {
						show: false
					}
				},
				colors: colors,
				dataLabels: {
					enabled: true
				},
				stroke: {
					curve: "smooth"
				},
				series: [{
						name: "High - 2019",
						data: []
					},
					{
						name: "Low - 2019",
						data: []
					}
				],
				grid: {
					borderColor: "#e7e7e7",
					row: {
						colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
						opacity: 0.0
					}
				},
				markers: {
					size: 6
				},
				xaxis: {
					categories: ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"],
					labels: {
						style: {
							colors: "#9aa0ac"
						}
					}
				},
				yaxis: {
					labels: {
						style: {
							color: "#9aa0ac"
						}
					},
				},
				legend: {
					position: "top",
					horizontalAlign: "right",
					floating: true,
					offsetY: -25,
					offsetX: -5
				}
			};
			var chart = new ApexCharts(document.querySelector("#graph"), options);
			chart.render();

			form = $('#f-solde');
			form.change(function() {
				solde();
			})

			link = $('a[detail]');
			solde()

			function solde() {
				var spinner = `<div class="text-center"><i class="spinner-border"></i></div>`;
				$('#res').html(spinner);
				link.fadeOut('slow');

				lien = '<?= site_url('index/detail-solde/') ?>';

				$.getJSON("<?= site_url('ajax/solde') ?>", form.serialize(), function(f) {
					var str = '';
					var sel = $('select>option:selected', form);
					var lab = '';
					if (f.length > 0) {
						for (i in f) {
							str += `<h3 class="text-center" >${f[i].devise} ${f[i].total} </h3>`;
						}
					} else {
						str = '<h1 class="text-center text-muted small" >Aucune information </h1>'
					}

					if (sel.val() != '' && f.length > 0) {
						link.attr('href', lien + sel.val());
						link.fadeIn('slow');
					}
					if (sel.val() == '') {
						lab = 'Tous les frais';
					} else {
						lab = sel.text();
					}
					$('#res').html(str);
					$('span[frais]').html(lab);
				})
			}


		})
	</script>
</body>

</html>