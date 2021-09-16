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
          <div class="row ">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4>Création Université</h4>
                  <center><b class="text-<?= $this->session->classe ?>"><?= $this->session->message ?></b></center>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <form action="<?php echo site_url('AdmUniversite/univCreate'); ?>" method="POST">
                      <div class="card-body">
                        <div class="form-group">
                          <label>Nom de l'université</label>
                          <input type="text" class="form-control" name="nom" required autofocus>
                          <div class="invalid-feedback">
                            Veuillez remplir ce champ svp
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Nom de utilisateur</label>
                          <input type="text" class="form-control" name="login" required >
                          <div class="invalid-feedback">
                            Veuillez remplir ce champ svp
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Mot de pass</label>
                          <input type="password" class="form-control" name="password" required >
                          <div class="invalid-feedback">
                            Veuillez remplir ce champ svp
                          </div>
                        </div>
                      </div>
                      <div class="card-footer text-right">
                        <button class="btn btn-warning">Submit</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4>Liste d'universités</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover mb-0" style="width: 100%;">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Nom de l'université</th>
                          <th>Login</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (isset($ecoles)) {
                          $i = 0;
                          foreach ($ecoles as $ecole) {
                            $i = $i + 1;
                        ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo $ecole->nomUniversite ?></td>
                              <td><?php echo $ecole->login ?></td>
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