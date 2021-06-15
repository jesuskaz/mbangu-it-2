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
      <div class="main-content">
        <div class="card">
          <div class="boxs mail_listing">
            <div class="inbox-center ">
              <div class="form-inline">
                <div class="inbox-header p-3 w-100" style="background: whitesmoke;">
                  Ajouter un frais
                  <center><b><?php if (isset($success)) echo "<font color=blue>" . $success . "</font>"; ?></b></center>
                  <center><b><?php if (isset($error)) echo "<fomt color=red>" . $error . "</font>"; ?></b></center>
                </div>
                <div class="form-group m-4">
                  <a type="button" class="btn btn-success" href="<?php echo site_url('Faculte/anneeAcademique') ?>">Ajouter annee Academique</a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <form class="composeForm" action="<?php echo base_url('Banque/createBanque'); ?>" method="POST">
                  <div class="row">
                    <div class="form-group col-6">
                      <select name="annee" class="custom-select data" required focus>
                        <?php
                        foreach ($anneeAcademiques as $annee) {
                        ?>
                          <option <?php echo $annee['actif'] == 1 ? 'selected' : '' ?> value="<?php echo $annee['idanneeAcademique'] ?>"><?php echo $annee['annee'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-6">
                      <?php if (empty($banque)) echo "" ?>
                      <div class="form-line">
                        <select type="text" id="email_address" name="banque" class="custom-select data" placeholder="Banque" required focus>
                          <?php foreach ($banques as $banque) {
                          ?>
                            <option value="<?php echo $banque->idbanque; ?>"><?php echo $banque->denomination; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <div class="form-line">
                        <input type="text" id="email_address" name="compte" class="form-control" placeholder="Compte" required focus>
                        <div class="invalid-feedback">
                          Ce champs est obligatoire
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-6">
                      <div class="form-line">
                        <input type="text" id="subject" name="frais" class="form-control" placeholder="Frais" required focus>
                        <div class="invalid-feedback">
                          Ce champs est obligatoire
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <div class="form-line">
                        <input type="text" id="subject" name="montant" class="form-control" placeholder="Montant" required focus>
                        <div class="invalid-feedback">
                          Ce champs est obligatoire
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-6">
                      <div class="form-line">
                        <select type="text" id="email_address" name="devise" class="custom-select data" placeholder="Banque" required focus>
                          <?php foreach ($devise as $dev) { ?>
                            <option value="<?= $dev->iddevise ?>"><?= $dev->nomDevise ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="col-lg-12">
                <div class="m-l-25 m-b-20">
                  <button type="submit" class="btn btn-info btn-border-radius waves-effect">Créer</button>
                  <button type="button" class="btn btn-danger btn-border-radius waves-effect">Annuler</button>
                </div>
              </div>
            </div>
            </form>
          </div>
        </div>
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