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
						<!-- <div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4>--- </h4>
								</div>
								<div class="card-header">
									<form action="" method="">
										<div class="form-inline">
											<div class="form-group m-2">
												<select id='faculte' name="faculte" style="width:130px" class="custom-select">
													<option>Faculte</option>
													<?php if (isset($faculte)) {
														foreach ($faculte as $facultes) {
													?>
															<option value="<?php echo $facultes['idfaculte']; ?>"><?php echo $facultes['nomFaculte']; ?></option>
													<?php }
													} ?>
												</select>
											</div>
											<div class="form-group m-2">
												<select id='promotion' name="promotion" style="width:130px" class="custom-select">
													<option>Promotion</option>
													<?php if (isset($promotion)) {
														foreach ($promotion as $promotion) {
													?>
															<option value="<?php echo $promotion['idpromotion']; ?>"><?php echo $promotion['intitulePromotion']; ?></option>
													<?php
														}
													}
													?>
												</select>
											</div>
											<div class="form-group m-2">
												<select id='option' name="option" style="width:130px" class="custom-select">
													<option>Option</option>
													<?php if (isset($option)) {
														foreach ($option as $options) {
													?>
															<option value="<?php echo $options['idoptions']; ?>"><?php echo $options['intituleOptions']; ?></option>
													<?php
														}
													}
													?>
												</select>
											</div>
											<div class="form-group m-2">
												<input type="text" class="form-control p-3 datepicker rounded-0 w-100" name="from" id="from" placeholder="Du" />
											</div>

											<div class="form-group m-2">
												<select class="custom-select" name="" id="">
													<option selected>Choisissez la devise</option>
													<option value="USD">CDF</option>
													<option value="CDF">USD</option>
												</select>
											</div>
											<div class="form-group">
												<button type="submit" name="submit" class="btn btn-primary" style="border-radius: 5px;" id="to">
													Envoyer
												</button>
											</div>
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
						</div> -->
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4>Rapport de tous les étudiants</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-striped table-hover" style="width:100%;">
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
											<tbody>
												<?php
												if (isset($paies)) {
													foreach ($paies as $rapport) {
												?>
														<tr>
															<td><?php echo $rapport["date"]; ?></td>
															<td><?php echo $rapport["matricule"]; ?></td>
															<td><?php echo $rapport["nom"]; ?></td>
															<td><?php echo $rapport["postnom"]; ?></td>
															<td><?php echo $rapport["prenom"]; ?></td>
															<td><?php echo $rapport["numeroCompte"]; ?></td>
															<td><?php echo $rapport["designation"]; ?></td>
															<td style="text-align:center"><?php echo $rapport["intitulePromotion"]; ?></td>
															<td><?php echo $rapport["nomFaculte"]; ?></td>
															<td style="text-align:right"><?php echo $rapport["montant"]; ?> <?php echo $rapport["nomDevise"]; ?></td>
														</tr>
												<?php
													}
												} else if (isset($error)) {
													echo $error;
												}
												?>
											</tbody>
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
</body>

</html>