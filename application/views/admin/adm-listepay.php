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
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="w-100 p-3 d-flex justify-content-between">
                    <div class="">
                      <h4 class="mb-2">Total paiement <i univ></i></h4>
                      <span paie></span>
                    </div>
                    <div class=" text-right">
                      <h4 class="mb-2">Total Comission <i univ></i></h4>
                      <span commission></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Liste de paiement</h4>
                  <div class="card-header-action">
                    <form class="form-inline form">
                      <div class="form-group p-1 ">
                        <input type="text" class="form-control p-3 datepicker data rounded-0 w-100" name="date">
                      </div>
                      <div class="form-group p-1 ">
                        <select name="universite" class="custom-select">
                          <option value="">Choisissez l'universite</option>
                          <?php foreach ($universites as $de) : ?>
                            <option value="<?= $de->iduniversite ?>"><?= $de->nomUniversite ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table id="table-r" class="table table-striped table-hover" style="width:100%;">
                      <thead>
                        <tr>
                          <th>N°</th>
                          <th>Nom</th>
                          <th>Post-nom</th>
                          <th>Prénom</th>
                          <th>Matricule</th>
                          <th>Université</th>
                          <th>Faculté</th>
                          <th>Promotion</th>
                          <th>Option</th>
                          <th>Frais</th>
                          <th>N° Compte</th>
                          <th>Banque</th>
                          <th>Montant</th>
                          <th>Commission</th>
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
      form = $('.form');
      $('.datepicker').daterangepicker({
        locale: {
          format: 'YYYY/MM/DD'
        }
      });
      opt = {
        dom: 'Bfrtip',
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      };

      table = $('#table-r');
      table.DataTable().destroy()
      table.DataTable(opt);

      _data()

      function _data() {
        var d = "type=admin&" + form.serialize();
        $('select').attr('disabled', true);

        $.getJSON("<?= site_url('ajax/liste-paie') ?>", d, function(d) {
          var str = '',
            data = d.data;
          $(data).each(function(i, data) {
            str += `
						<tr>
							<td>${i+1}</td>
							<td>${data.nom}</td>
							<td>${data.postnom}</td>
							<td>${data.prenom}</td>
							<td>${data.matricule}</td>
							<td>${data.universite}</td>
							<td>${data.faculte}</td>
							<td>${data.promotion}</td>
							<td>${data.option}</td>
							<td>${data.frais}</td>
							<td>${data.compte}</td>
							<td>${data.banque}</td>
							<td class='text-right'>${data.montant + ' '+ data.devise }</td>
							<td class='text-right'>${data.commission + ' '+ data.devise }</td>
						</tr>
						`;
          });
          $('i[univ]').html(d.universite)
          var l = c = '';
          if (d.paiement.length > 0) {
            $(d.paiement).each(function(i, p) {
              l += `<h6 class="text-danger">${Number(p.total).toFixed(2) } ${p.devise}</h6>`;
              c += `<h6 class="text-danger">${Number(p.commission).toFixed(2) } ${p.devise}</h6>`;
            })
          } else {
            l += `<h6 class="text-danger">Aucun paiement</h6>`;
            c += `<h6 class="text-danger">Aucun paiement</h6>`;
          }

          $('span[paie]').html(l)
          $('span[commission]').html(c)

          table.DataTable().destroy()
          table.children('tbody').html(str)
          table.DataTable(opt).draw()
          $('select').attr('disabled', false);
        })
      }

      form.change(function() {
        _data();
      })
    })
  </script>
</body>


</html>