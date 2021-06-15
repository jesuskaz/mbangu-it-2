<!DOCTYPE html>
<html lang="en">



<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Otika - Admin Dashboard Template</title>
  <link rel="stylesheet" href="assets/css/app.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php include("nav.php"); ?>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html"> <img alt="image" src="assets/img/logo.png" class="header-logo" /> <span class="logo-name">MBANGU PAY</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown">
              <a href="index.html" class="nav-link"><i data-feather="monitor"></i><span>Accueil</span></a>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="briefcase"></i><span>Banque</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="liste-banque.html">Liste de Banque</a></li>
                <li><a class="nav-link" href="ajouter-compte.html">Ajouter un compte</a></li>
                <li><a class="nav-link" href="liste-compte.html">Liste de comptes</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Faculté</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="liste-faculte.html">Liste de faculté</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Etudiant</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="liste-tousetudiant.html">Voir la liste des Etudiants</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Rapport</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="liste-payetudiant.html">Liste de paiement</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="shopping-bag"></i><span>Se deconnecter</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="avatar.html">Deconnecter</a></li>
              </ul>
            </li>
          </ul>
        </aside>
      </div>
      <div class="main-content">
        <div class="card">
          <div class="boxs mail_listing">
            <div class="inbox-center table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th colspan="1">
                      <div class="inbox-header">
                        Ajouter un compte
                      </div>
                    </th>
                  </tr>
                </thead>
              </table>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <form class="composeForm">
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="email_address" class="form-control" placeholder="Banque">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="email_address" class="form-control" placeholder="Compte">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="subject" class="form-control" placeholder="Frais">
                    </div>
                  </div>
                  <textarea id="ckeditor" style="visibility: hidden;">                              </textarea>
                </form>
              </div>
              <div class="col-lg-12">
                <div class="m-l-25 m-b-20">
                  <button type="button" class="btn btn-info btn-border-radius waves-effect">Créer</button>
                  <button type="button" class="btn btn-danger btn-border-radius waves-effect">Annuler</button>
                </div>
              </div>
            </div>
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
      <footer class="main-footer">
        <div class="footer-left">
          <a href="templateshub.net">Templateshub</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/bundles/chartjs/chart.min.js"></script>
  <script src="assets/bundles/jquery.sparkline.min.js"></script>
  <script src="assets/bundles/apexcharts/apexcharts.min.js"></script>
  <script src="assets/bundles/jqvmap/dist/jquery.vmap.min.js"></script>
  <script src="assets/bundles/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="assets/bundles/jqvmap/dist/maps/jquery.vmap.indonesia.js"></script>
  <script src="assets/js/page/widget-chart.js"></script>
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>



</html>