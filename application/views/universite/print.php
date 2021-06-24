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
        <section class="section">
          <div class="section-body">
            <div class="invoice">
              <div class="invoice-print" id="print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title d-flex p-0 justify-content-center">
                      <h6 class="text-warning">Facturette</h6>
                    </div>
                    <hr>
                    <div class="row justify-content-between">
                      <div class="">
                        <address>
                          <?= "$etudiant->nom $etudiant->postnom $etudiant->prenom" ?><br>
                          Faculté : <?= $etudiant->nomFaculte ?><br>
                          Promotion : <?= $etudiant->intitulePromotion ?><br>
                          Options : <?= $etudiant->intituleOptions ?><br>
                          Matricule : <?= $etudiant->matricule ?><br>
                          Adresse : <?= $etudiant->adresse ?>
                        </address>
                      </div>
                      <div class=" text-md-right">
                        <?php $d = explode(' ', $paie->date);
                        ?>
                        <address>
                          N° Facture : <?= $etudiant->idetudiant ?><br>
                          Date : <?= @$d[0] ?><br>
                          Heure : <?= @$d[1] ?><br>
                          Universté : <?= $paie->nomUniversite ?><br>
                          Compte : <?= $paie->numeroCompte ?><br>
                        </address>
                      </div>
                    </div>

                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <thead>
                          <tr>
                            <th>Frais</th>
                            <th class="text-center">Montant à payer</th>
                            <th class="text-right">Montant payé</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><?= $paie->designation ?></td>
                            <td class="text-center"><?= "$paie->montant_frais $paie->nomDevise" ?></td>
                            <td class="text-right"><?= " $paie->montant_paye $paie->nomDevise" ?></td>
                          </tr>
                        </tbody>

                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-12 justify-content-between">
                  <button onclick="history.back()" class="btn btn-danger btn-icon "><i class="fas fa-arrow-left"></i> Retour</button>
                  <button class="btn btn-warning btn-icon print"><i class="fas fa-print"></i> Imprimer</button>
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
  <script src="<?php echo base_url() . 'assets/js/printThis.js'; ?>"></script>
  <script>
    $(function() {
      $('.table').DataTable().destroy()
      $('.print').click(function() {
        $("#print").printThis({
          importCSS: true,
        });
      })
    })
  </script>

</body>

</html>