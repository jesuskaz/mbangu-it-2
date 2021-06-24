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
        <div class="sidebar-brand">

        </div>
      </div>
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Liste des etudiant</h4>
                  </div>
                  <div class="card-header">
                    <form id='form-change' method="">
                      <div class="form-inline">
                        <div class="form-group m-2">
                          <select name="faculte" style="width:130px" class="custom-select">
                            <option value="">Faculte</option>
                            <?php foreach ($facultes as $faculte) {
                            ?>
                              <option value="<?php echo $faculte['idfaculte']  ?>"><?php echo $faculte['nomFaculte']  ?></option>
                            <?php
                            } ?>
                          </select>
                        </div>
                        <div class="form-group m-2">
                          <select name="promotion" style="width:130px" class="custom-select">
                            <option value="">Promotion</option>
                            <?php
                            foreach ($promotions as $promotion) {
                            ?>
                              <option value="<?php echo $promotion['idpromotion']  ?>"><?php echo $promotion['intitulePromotion'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group m-2">
                          <select name="option" style="width:130px" class="custom-select">
                            <option value="">Option</option>
                            <?php foreach ($options as $option) { ?>
                              <option value="<?php echo $option['idoptions'] ?>"><?php echo $option['intituleOptions'] ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="table-r" class="table table-striped table-hover" style="width:100%;">
                        <thead>
                          <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Post-nom</th>
                            <th>Prénom</th>
                            <th>Faculté</th>
                            <th>Pomotion</th>
                            <th>Matricule</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Téléphone</th>
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

  <script>
    $(function() {

      opt = {
        dom: 'Bfrtip',
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      };

      table = $('#table-r');
      form = $('#form-change');

      table.DataTable().destroy()
      table.DataTable(opt);
      var s_promotion = $('select[name=promotion]');
      var s_faculte = $('select[name=faculte]');

      data();

      function data() {
        $('select').attr('disabled', false);
        var t = "type=univ&" + form.serialize();
        $('select').attr('disabled', true);

        $.getJSON("<?= site_url('ajax/liste-etudiant') ?>", t, function(d) {
          var str = '',
            data = d.data;
          $(data).each(function(i, data) {
            str += `
						<tr>
							<td>${i+1}</td>
							<td>${data.nom}</td>
							<td>${data.postnom}</td>
							<td>${data.prenom}</td>
							<td>${data.faculte}</td>
							<td>${data.promotion}</td>
              <td>${data.matricule ? data.matricule : ''}</td>
							<td>${data.email ? data.email : ''}</td>
							<td>${data.adresse ? data.adresse : ''}</td>
							<td>${data.telephone ? data.telephone : ''}</td>
						</tr>
						`;
          })
          table.DataTable().destroy()
          table.children('tbody').html(str)
          table.DataTable(opt).draw()
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
            $('select').attr('disabled', true);
            data()
          })
        } else {
          data()
        }
      })

    })
  </script>
</body>

</html>