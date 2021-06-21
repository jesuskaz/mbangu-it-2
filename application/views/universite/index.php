<!DOCTYPE html>
<html lang="en">
<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<?php include("heade.php"); ?>
</script>

<body>
	<!-- <div class="loader"></div> -->
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<div class="navbar-bg"></div>
			<nav class="navbar navbar-expand-lg main-navbar sticky">
				<div class="form-inline mr-auto">
					<ul class="navbar-nav mr-3">
						<li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
						<li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
								<i data-feather="maximize"></i>
							</a></li>
						<li>
							<form class="form-inline mr-auto">
								<div class="search-element">
									<input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
									<button class="btn" type="submit">
										<i class="fas fa-search"></i>
									</button>
								</div>
							</form>
						</li>
					</ul>
				</div>

			</nav>

			<div class="main-sidebar sidebar-style-2">
				<?php include('sidebar.php'); ?>
			</div>
			<!-- Main Content -->
			<div class="main-content">
				<section class="section">
					<div class="row">
						<div class="col-12 col-sm-12 col-lg-12">
							<div class="card ">
								<div class="card-header">
									<h4>Revenue chart</h4>
									<div class="card-header-action">
										<div class="form-group p-0 ">
											<select class="custom-select devise">
												<option value="">Choisissez la devise</option>
												<?php foreach ($devises as $de) : ?>
													<option value="<?= $de->iddevise ?>"><?= $de->nomDevise ?></option>
												<?php endforeach ?>
											</select>
										</div>
										<div class="dropdown">
											<a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle">Options</a>
											<div class="dropdown-menu">Revenue
												<a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
												<a href="#" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
												<div class="dropdown-divider"></div>
												<a href="#" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i>
													Delete</a>
											</div>
										</div>
										<a href="#" class="btn btn-primary">View All</a>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-lg-9">
											<div id="graph"></div>
											<div class="row mb-0">
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
													<div class="list-inline text-center">
														<div class="list-inline-item p-r-30"><i data-feather="arrow-up-circle" class="col-green"></i>
															<h5 class="m-b-0">$675</h5>
															<p class="text-muted font-14 m-b-0">Weekly Earnings</p>
														</div>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
													<div class="list-inline text-center">
														<div class="list-inline-item p-r-30"><i data-feather="arrow-down-circle" class="col-orange"></i>
															<h5 class="m-b-0">$1,587</h5>
															<p class="text-muted font-14 m-b-0">Monthly Earnings</p>
														</div>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
													<div class="list-inline text-center">
														<div class="list-inline-item p-r-30"><i data-feather="arrow-up-circle" class="col-green"></i>
															<h5 class="mb-0 m-b-0">$45,965</h5>
															<p class="text-muted font-14 m-b-0">Yearly Earnings</p>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="row mt-5">
												<div class="col-7 col-xl-7 mb-3">Total Etudiant</div>
												<div class="col-5 col-xl-5 mb-3">
													<span class="text-big">...</span>
													<sup class="col-green">%</sup>
												</div>
												<div class="col-7 col-xl-7 mb-3">Total Payé</div>
												<div class="col-5 col-xl-5 mb-3">
													<span class="text-big">...</span>
													<sup class="text-danger">%</sup>
												</div>
												<div class="col-7 col-xl-7 mb-3">Total Payé partiellement</div>
												<div class="col-5 col-xl-5 mb-3">
													<span class="text-big">...</span>
													<sup class="col-green">%</sup>
												</div>
												<div class="col-7 col-xl-7 mb-3">Nombre Etudiant Payer</div>
												<div class="col-5 col-xl-5 mb-3">
													<span class="text-big">...</span>
													<sup class="col-green">%</sup>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="section-body">
						<div class="row">

							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h4>Rapport de tous les étudiants</h4>
										<?php
										// var_dump($promotions);
										?>
									</div>
									<div class="card-header">
										<form id='form-change' method="">
											<div class="form-inline">
												<div class="form-group m-2">
													<select name="faculte" style="width:130px" class="custom-select data">
														<option value="">Faculte</option>
														<?php foreach ($selectFaculte as $facultes) {
														?>
															<option value="<?php echo $facultes['idfaculte']  ?>"><?php echo $facultes['nomFaculte']  ?></option>
														<?php
														} ?>
													</select>
												</div>
												<div class="form-group m-2">
													<select name="promotion" style="width:130px" class="custom-select data">
														<option value="">Promotion</option>
														<?php
														foreach ($promotions as $promotion) {
														?>
															<option value="<?php echo $promotion['idpromotion']  ?>"><?php echo $promotion['intitulePromotion'] ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="form-group m-2">
													<select name="option" style="width:130px" class="custom-select data">
														<option value="">Option</option>
														<?php foreach ($options as $option) { ?>
															<option value="<?php echo $option['idoptions'] ?>"><?php echo $option['intituleOptions'] ?></option>
														<?php
														}
														?>
													</select>
												</div>

												<div class="form-group m-2">
													<input type="text" class="form-control p-3 datepicker data rounded-0 w-100" name="date">
												</div>
												<div class="form-group m-2">
													<select class="custom-select data" name="devise">
														<option value="" selected>Choisissez la devise</option>
														<?php foreach ($devises as $dev) { ?>
															<option value="<?php echo $dev->iddevise ?>"><?php echo $dev->nomDevise ?></option>
														<?php } ?>
													</select>
												</div>
												<!-- <div class="form-group">
													<button type="button" name="submit" class="btn btn-primary" style="border-radius: 5px;" id="to">
														Envoyer
													</button>
												</div> -->
											</div>

										</form>
										<style>
											.custom-select {
												position: relative;
												font-family: Arial;
											}

											.custom-select select {
												display: none;
												/*hide original SELECT element: */
											}
										</style>
									</div>
								</div>
							</div>


							<div class="col-12">
								<div class="card">

									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-striped table-hover" id='table-r' iiid="tableExport" style="width:100%;">
												<thead>
													<tr>
														<th>Date</th>
														<th>Matricule</th>
														<th>Nom</th>
														<th>PostNom</th>
														<th>Prénom</th>
														<th>Compte</th>
														<th>Frais</th>
														<th>Promotion</th>
														<th>Faculté</th>
														<th>Montant</th>
													</tr>
												</thead>
												<tbody></tbody>
											</table>
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

			table = $('#table-r');
			form = $('.data');
			table.DataTable();

			data();

			function data() {
				$.getJSON("<?= site_url('ajax/getallrapport') ?>", "type=univ&"+form.serialize(), function(d) {
					var str = '',
						data = d.data;
					$(data).each(function(i, data) {
						str += `
						<tr>
							<td> ${data.date}</td>
							<td>${data.matricule}</td>
							<td>${data.nom}</td>
							<td>${data.postnom}</td>
							<td>${data.prenom}</td>
							<td>${data.numeroCompte}</td>
							<td>${data.designation}</td>
							<td style="text-align:center">${data.intitulePromotion}</td>
							<td>${data.nomFaculte}</td>
							<td style="text-align:right">${data.montant} ${data.nomDevise}</td>
						</tr>
						`;
					})
					table.DataTable().destroy()
					table.children('tbody').html(str)
					table.DataTable().draw()
					$('select').attr('disabled', false);
				})
			}

			form.change(function(r) {
				var name = $(this).attr('name');
				$('select').attr('disabled', true);
				if (name == 'faculte' || name == 'promotion') {
					$.getJSON("<?= site_url('ajax/select-data') ?>", {
						'faculte': s_faculte.val(),
						'promotion': s_promotion.val()
					}, function(d) {
						var str = '<option value="">Option</option>';
						if (d.length > 0) {
							$(d).each(function(i, j) {
								var _o = j.intituleOptions;
								var _v = j.idoptions;
								str += `<option value="${j.idoptions}">${j.intituleOptions}</option>`;
							})
						}
						$('select[name=option]').html(str);
						data()
					})
				} else {
					data()
				}
			})

			var s_promotion = $('select[name=promotion]');
			var s_faculte = $('select[name=faculte]');

			// $('select[name=faculte]').change(function(r) {
			// 	$.getJSON("<?= site_url('ajax/select-data') ?>", {
			// 		'name': 'faculte',
			// 		'id': $(this).val(),
			// 		'promotion': s_promotion.val()
			// 	}, function(d) {
			// 		var str = '<option value="">Option</option>';
			// 		if (d.length > 0) {
			// 			$(d).each(function(i, j) {
			// 				var _o = j.intituleOptions;
			// 				var _v = j.idoptions;
			// 				str += `<option value="${j.idoptions}">${j.intituleOptions}</option>`;
			// 			})
			// 		}
			// 		$('select[name=option]').html(str)
			// 	})
			// 	// data()
			// })

			// chart();

			// function chart() {
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
				colors: ["#786BED", "#999b9c"],
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
					title: {
						text: "Income"
					},
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
			// }

			chart_data()

			function chart_data(devise = '') {
				$.get("<?= site_url('ajax/chart-data') ?>", {
					devise: devise,
					type:'univ'
				}, function(d) {
					d = JSON.parse(d)
					var tab_data = [];
					$.each(d, function(i, j) {
						tab_data.push({
							name: i,
							data: j
						})
					})
					chart.updateSeries(tab_data)
				})
			}

			$('.devise').change(function() {
				chart_data($(this).val())
			})

		});
	</script>
</body>
</body>
<!-- index.html  21 Nov 2019 03:47:04 GMT -->

</html>