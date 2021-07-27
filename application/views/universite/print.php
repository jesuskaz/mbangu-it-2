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
            <div class="invoice pt-2 pb-0">
              <div class="invoice-print" id="print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title bg-w d-flex p-0 m-0 justify-content-center">
                      <h2 class="text-warning p-0 m-0">Recu</h2>
                    </div>
                    <hr class="m-0 p-0 mb-2">
                    <div class="row justify-content-between m-0 p-0">
                      <div class="col-md-4">
                        <div class="row font-weight-600 text-muted">
                          <div class="col-2">Nom </div>
                          <div class="col-10"> : <?= "$etudiant->nom $etudiant->postnom $etudiant->prenom" ?></div>
                        </div>
                        <div class="row font-weight-600 text-muted">
                          <div class="col-2">Faculté </div>
                          <div class="col-10"> : <?= "$etudiant->nomFaculte" ?></div>
                        </div>
                        <div class="row font-weight-600 text-muted">
                          <div class="col-2">Promotion </div>
                          <div class="col-10"> : <?= $etudiant->intitulePromotion ?></div>
                        </div>
                        <div class="row font-weight-600 text-muted">
                          <div class="col-2">Option </div>
                          <div class="col-10"> : <?= "$etudiant->intituleOptions" ?></div>
                        </div>
                        <div class="row font-weight-600 text-muted">
                          <div class="col-2">Matricule </div>
                          <div class="col-10"> : <?= "$etudiant->matricule" ?></div>
                        </div>
                        <div class="row font-weight-600 text-muted">
                          <div class="col-2">Adresse </div>
                          <div class="col-10"> : <?= "$etudiant->adresse" ?></div>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class=" text-md-right">
                          <?php $d = explode(' ', $paie->date);
                          ?>
                          <address class="font-weight-600 text-muted">
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
                <div class="row justify-content-center" id="qrcode">
                </div>
              </div>
              <hr>
              <div class="row pb-3">
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
  <script src="<?php echo base_url() . 'assets/js/qrcode.min.js'; ?>"></script>
  <script>
    $(function() {
      $('.table').DataTable().destroy()
      $('.print').click(function() {
        $("#print").printThis({
          importCSS: true,
        });
      });

      var qrcode = new QRCode(document.getElementById("qrcode"), {
        width: 100,
        height: 100
      });
      qrcode.makeCode('<?= "$etudiant->nom $etudiant->postnom $etudiant->prenom" ?>');

    })
  </script>

</body>

</html>