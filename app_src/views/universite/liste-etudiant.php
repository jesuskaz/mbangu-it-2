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
                    <form method="">
                      <div class="form-inline">
                        <div class="form-group m-2">
                          <select name="faculte" style="width:130px" class="custom-select form-change" id="faculte">
                            <option value="">Faculte</option>
                            <?php foreach ($facultes as $faculte) {
                            ?>
                              <option value="<?php echo $faculte['idfaculte']  ?>"><?php echo $faculte['nomFaculte']  ?></option>
                            <?php
                            } ?>
                          </select>
                        </div>
                        <div class="form-group m-2">
                          <select name="option" style="width:130px" class="custom-select form-change" id="option">
                            <option value="">Option</option>
                          </select>
                        </div>
                        <div class="form-group m-2">
                          <select name="promotion" style="width:130px" class="custom-select form-change" id="promotion">
                            <option value="">Promotion</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between">
                    <h4>Importer la liste d'étudiants</h4>
                    <button class="btn btn-success float-right rounded-0" onclick="location.assign('<?= base_url('assets/model_importation_etudiant.xlsx') ?>')">
                      <i class="fa fa-file-excel "></i> Modèle d'importation
                    </button>
                  </div>
                  <div class="card-body">
                    <form method="" id="f-import">
                      <div class="form-inline">
                        <div class="form-group m-2">
                          <div class="custom-file">
                            <input accept=".xls,.xlsx" type="file" class="custom-file-input" id="customFile" name="file">
                            <label class="custom-file-label" for="customFile">fichier Excel</label>
                          </div>
                        </div>
                        <div class="form-group" id="rep"></div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card">
                  <div class="col-12 mt-3 d-flex justify-content-center">
                    <b id="sms-rep" class=""></b>
                  </div>
                  <div class="card-header d-flex justify-content-between">
                    <h4>Liste d'Etudiants</h4>
                    <button class="btn btn-warning all-sms" style="border-radius: 5px;"><i class="fa fa-sms"></i> Envoyer SMS</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="table-r" class="table table-striped table-hover" style="width:100%;">
                        <thead>
                          <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Post-nom</th>
                            <th>Faculté</th>
                            <th>Pomotion</th>
                            <th>Matricule</th>
                            <th>Détails</th>
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
          'copy', 'excel', 'pdf', 'print'
        ]
      };

      table = $('#table-r');
      form = $('.form-change');

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
            var url = "<?= site_url('banque/detail-etudiant/') ?>" + data.idetudiant;
            var sms = data.nb_sms > 0 ? `<i style='cursor:pointer' title="SMS déjà envoyé à l'étudiant " class="fa fa-check-circle text-success"></i>` : '';
            str += `
						<tr>
							<td>${i+1}</td>
							<td>${data.nom}</td>
							<td>${data.postnom}</td>
							<td>${data.faculte}</td>
							<td>${data.promotion}</td>
              <td>${data.matricule ? data.matricule : ''}</td>
							<td style="text-align:center" class='d-inline-flex'>
                <a href="${url}"><i class="fa fa-eye"></i> Détail</a>
                <button value='${data.idetudiant}' class='btn btn-warning btn-sm ml-2 mr-2 sms'><i class="fa fa-envelope"></i> <i>SMS</i></button>
                ${sms}
              </td>
						</tr>
						`;
          })
          table.DataTable().destroy()
          table.children('tbody').html(str)
          sms();
          table.DataTable(opt).draw()
          $('select').attr('disabled', false);
        })
      }

      $('#faculte').change(function() {
        $('select').attr('disabled', true);
        $.getJSON("<?= site_url('ajax/select-data') ?>", {
          'faculte': s_faculte.val(),
          type: 'univ'
        }, function(res) {
          var str = '<option value="">Option</option>';
          $(res.options).each(function(i, d) {
            str += `<option value="${d.option}">${d.option}</option>`;
          })
          $('select[name=option]').html(str);
          $('select[name=classe]').html('<option value="">Classe</option>');
          data();
        })
      })

      $('#option').change(function() {
        $('select').attr('disabled', true);
        $.getJSON("<?= site_url('ajax/promotion') ?>", {
          option: $(this).val(),
          type: 'univ'
        }, function(res) {
          var str = '<option value="">Promotion</option>';
          $(res).each(function(i, d) {
            str += `<option value="${d.idpromotion}">${d.promotion}</option>`;
          })
          $('select[name=promotion]').html(str);
          data();
        })
      })

      $('#promotion').change(function() {
        $('select').attr('disabled', true);
        data();
      })


      $('#f-import').change(function(e) {
        e.preventDefault();
        var spin = `
                <div class="spinner-border text-warning" role="status">
                <span class="sr-only">Loading...</span>
                </div>`;
        var m = $('#rep');
        m.html(spin);
        var f = $(this);
        var d = new FormData(this);
        d.append('type', 'univ');
        d.append('faculte', $('#faculte').val());
        d.append('promotion', $('#promotion').val());
        d.append('option', $('#option').val());

        $(':input', f).attr('disabled', true);
        $.ajax({
          url: '<?= site_url('json/import-2') ?>',
          type: 'POST',
          data: d,
          timeout: 0,
          processData: false,
          contentType: false,
          success: function(res) {
            f.get(0).reset();
            res = $.parseJSON(res);
            if (res.status) {
              data();
            }
            m.html(res.message);
            $(':input', f).attr('disabled', false);

          },
          error: function() {
            m.html("<b>Une erreur s'est produite.</b>");
            $(':input', f).attr('disabled', false);

          }
        })

      })

      $('#f-import').change(function(e) {
        e.preventDefault();
        var spin = `
                <div class="spinner-border text-warning" role="status">
                <span class="sr-only">Loading...</span>
                </div>`;
        var m = $('#rep');
        m.html(spin);
        var f = $(this);
        var d = new FormData(this);
        d.append('type', 'ecole');
        d.append('section', $('#section').val());
        d.append('option', $('#option').val());
        d.append('classe', $('#classe').val());

        $(':input', f).attr('disabled', true);
        $.ajax({
          url: '<?= site_url('json/import') ?>',
          type: 'POST',
          data: d,
          timeout: 0,
          processData: false,
          contentType: false,
          success: function(res) {
            f.get(0).reset();
            res = $.parseJSON(res);
            if (res.status) {
              data();
            }
            m.html(res.message);
            $(':input', f).attr('disabled', false);

          },
          error: function() {
            m.html("<b>Une erreur s'est produite.</b>");
            $(':input', f).attr('disabled', false);

          }
        })
      })

      function sms() {
        $('.sms').off('click').click(function() {
          var etudiant = $(this).val();
          var btn = $(this);
          var txt = btn.html();
          btn.attr('disabled', true);
          btn.html(`<div class='spinner-border spinner-border-sm'></div>`);
          $('#sms-rep').html('');
          $.post('<?= site_url('sms/resend') ?>', {
            type: 'univ',
            etudiant: etudiant
          }, function(d) {
            d = JSON.parse(d);
            if (d.status == true) {
              $('#sms-rep').removeClass().addClass('text-success').html(d.message);
              data();
            } else {
              $('#sms-rep').removeClass().addClass('text-danger').html(d.message);
            }
            btn.attr('disabled', false).html(txt);
          })
        })
      }

      $('.all-sms').click(function() {
        var btn = $(this);
        var txt = btn.html();
        btn.attr('disabled', true);
        btn.html(`<div class='spinner-border spinner-border-sm'></div>`);
        $('#sms-rep').html('');
        $.post('<?= site_url('sms/notification') ?>', {
          type: 'univ'
        }, function(d) {
          d = JSON.parse(d);
          if (d.status == true) {
            $('#sms-rep').removeClass().addClass('text-success').html(d.message);
            data();
          } else {
            $('#sms-rep').removeClass().addClass('text-danger').html(d.message);
          }
          btn.attr('disabled', false).html(txt);
        })
      })

    })
  </script>
</body>

</html>