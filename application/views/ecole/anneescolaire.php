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
      <div class="main-content" style="min-height: 675px;">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header justify-content-between">
                    <h4>Ajouter une année scolaire</h4>
                  </div>
                  <form class="" name="add_name" method="POST" action="<?= site_url('ecole/annee_a') ?>">
                    <div class="d-flex justify-contente-center">
                      <div class="form-inline">
                        <input type="date" name="from" placeholder="De" class="form-control name_list m-3" required="" />
                        <input type="date" name="to" placeholder="A" class="form-control name_list m-3" required="" />
                      </div>
                    </div>
                    <div class="form-group ml-3">
                      <b class="text-<?= $this->session->classe; ?>"><?= $this->session->message; ?></b>
                    </div>
                    <div class="form-group ml-3">
                      <button type="submit" name="submit" id="submit" class="btn btn-warning" value="Submit">Ajouter</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Années Scolaires</h4>
                  </div>
                  <div class="col-12 text-center mb-3">
                    <b class="text-<?= $this->session->classe2; ?>"><?= $this->session->message2; ?></b>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" style="width:100%;">
                        <thead>
                          <tr>
                            <th></th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          foreach ($anneescolaires as $ann) {
                            $i = $i + 1;
                          ?>
                            <tr>
                              <td><?php echo  $i; ?></td>
                              <td><?php echo $ann->date_debut; ?></td>
                              <td><?php echo $ann->date_fin; ?></td>
                              <td class="text-center">
                                <?php if ($ann->actif == 1) { ?>
                                  <span><i class="fa fa-check-square text-success"></i> Année actuelle</span>
                                <?php } ?>
                              </td>
                              <td class="text-center">
                                <?php if ($ann->actif != 1) { ?>
                                  <a class="btn-link ml-2 text-success" href="<?= site_url('ecole/active-a/' . $ann->idannee_scolaire_ecole) ?>"> <i class="fa fa-check"></i> Activer </a>
                                <?php } ?>

                              </td>
                            </tr>
                          <?php
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
      <?php include("footer.php"); ?>

</body>

</html>