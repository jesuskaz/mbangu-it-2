<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between">
                    <h4>Identité de l'élève</h4>
                    <h4>Pièce d'identité</h4>
                    <h4 class="pr-5">Portrait élève</h4>
                  </div>
                  <div class="card-body">
                    <div class="row justify-content-between">
                      <div class="col-md-4">
                        <div class="row d-flexi justify-content-betweeni">
                          <div class="col-4">Nom </div>
                          <div class="col-8"> : <?= "$eleve->nom $eleve->postnom $eleve->prenom" ?></div>
                        </div>
                        <div class="row d-flexi justify-content-betweeni">
                          <div class="col-4">Section </div>
                          <div class="col-8"> : <?= "$eleve->intitulesection" ?></div>
                        </div>
                        <div class="row d-flexi justify-content-betweeni">
                          <div class="col-4">Classe </div>
                          <div class="col-8"> : <?= "$eleve->intituleclasse" ?></div>
                        </div>
                        <div class="row d-flexi justify-content-betweeni">
                          <div class="col-4">Option </div>
                          <div class="col-8"> : <?= $eleve->intituleOption ?? '-' ?></div>
                        </div>
                        <div class="row d-flexi justify-content-betweeni">
                          <div class="col-4">Matricule </div>
                          <div class="col-8"> : <?= "$eleve->matricule" ?></div>
                        </div>
                        <div class="row d-flexi justify-content-betweeni">
                          <div class="col-4">Tel. Parent </div>
                          <div class="col-8"> : <?= $eleve->telephoneparent ?></div>
                        </div>
                        <div class="row d-flexi justify-content-betweeni">
                          <div class="col-4">Adresse </div>
                          <div class="col-8"> : <?= "$eleve->adresse" ?></div>
                        </div>

                      </div>
                      <div class="col-md-4 d-flex justify-content-center">
                        <?php if (file_exists(@$eleve->carte)) { ?>
                          <a href="<?= base_url($eleve->carte) ?>">
                            <img class="user-img-radious-style" width="100" height="100" style="umargin-left: -60px; border-radius: 5px;" src=" <?= base_url($eleve->carte) ?>" alt="">
                          </a>
                        <?php } ?>
                      </div>
                      <div class="col-md-4 d-flex justify-content-end pr-5">
                        <address>
                          <?php if (file_exists(@$eleve->picture)) { ?>
                            <a href="<?= base_url($eleve->picture) ?>">
                              <img class="user-img-radious-style" width="100" height="100" style="border-radius: 100%;" src=" <?= base_url($eleve->picture) ?>" alt="">
                            </a>
                          <?php } ?>
                        </address>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
               
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" style="width:100%;">
                        <thead>
                          <tr>
                            <th>N°</th>
                            <th>Frais</th>
                            <th>Montant à payer</th>
                            <th>Montant payé</th>
                            <th>Commission</th>
                            <th>Date Paiement</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $n = 1;
                          foreach ($paiements as $paie) { ?>
                            <tr>
                              <td><?= $n++ ?></td>
                              <td><?= $paie->frais ?></td>
                              <td><?= "$paie->montant_frais $paie->devise" ?></td>
                              <td><?= "$paie->montant_paye $paie->devise" ?></td>
                              <td><?= "$paie->commission $paie->devise" ?></td>
                              <td><?= $paie->date ?></td>
                            </tr>
                          <?php } ?>
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