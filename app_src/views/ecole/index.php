<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<?php include("heade.php"); ?>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php include("nav.php"); ?>
      <div class="main-sidebar sidebar-style-2">
        <?php include('sidebar.php'); ?>
      </div>
      <div class="main-content">
        <section class="section">
          <div class="row">
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header">
                  <h4>Statistiques de paiement</h4>
                  <div class="card-header-action">
                    <div class="form-group form-group-sm p-0 m-0 ">
                      <select class="custom-select custom-select-sm  devise  m-0">
                        <option value="">Choisissez la devise</option>
                        <?php foreach ($devises as $de) : ?>
                          <option value="<?= $de->iddevise ?>"><?= $de->nomDevise ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-9">
                      <div id="graph"></div>
                    </div>
                    <div class="col-lg-3">
                      <div class="row mt-5">
                        <div class="col-7 col-xl-7 mb-3"><a href="<?= site_url('ecole/eleves') ?>">Total élève</a></div>
                        <div class="col-5 col-xl-5 mb-3">
                          <span class="text-big"> <?= $tot_eleve ?> </span>
                        </div>
                        <div class="col-7 col-xl-7 mb-3"><a href="<?= site_url('ecole/rapport') ?>">Elève ayant payés</a></div>
                        <div class="col-5 col-xl-5 mb-3">
                          <span class="text-big"> <?= $eleve_paie ?> </span>
                        </div>
                        <div class="col-7 col-xl-7 mb-3">Elève n'ayant pas payés</div>
                        <div class="col-5 col-xl-5 mb-3">
                          <span class="text-big"> <?= $eleve_pas_paie ?> </span>
                        </div>
                        <div class="col-12 mb-3">Légende :<b><span class="ml-2" id='legende'></span></b></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <form class='' method="">
                      <div class="form-inline">
                        <div class="form-group m-2">
                          <select name="section" class="custom-select form-change">
                            <option value="">Section</option>
                            <?php foreach ($sections as $se) {
                            ?>
                              <option value="<?php echo $se->idsection  ?>"><?php echo $se->intitulesection  ?></option>
                            <?php
                            } ?>
                          </select>
                        </div>
                        <div class="form-group m-2">
                          <select name="option" class="custom-select form-change">
                            <option value="">Option</option>
                          </select>
                        </div>
                        <div class="form-group m-2">
                          <select name="classe" class="custom-select form-change">
                            <option value="">Classe</option>
                          </select>
                        </div>
                        <div class="form-group m-2">
                          <input type="text" class="form-control form-change p-3 datepicker data rounded-0 w-100" name="date">
                        </div>
                        <div class="form-group m-2">
                          <select class="custom-select form-change data" name="devise">
                            <option value="" selected>Choisissez la devise</option>
                            <?php foreach ($devises as $dev) { ?>
                              <option value="<?php echo $dev->iddevise ?>"><?php echo $dev->nomDevise ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Rapport de tous les élèves</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id='table-r' style="width:100%;">
                        <thead>
                          <tr>
                            <th>Nom</th>
                            <th>Postnom</th>
                            <th>Prénom</th>
                            <th>Matricule</th>
                            <th>Compte</th>
                            <th>Frais</th>
                            <th>Option</th>
                            <th>Classe</th>
                            <th>Montant</th>
                            <th>Date</th>
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
      form = $('.form-change');
      table.DataTable().destroy()
      table.DataTable(opt);
      var s_promotion = $('select[name=promotion]');
      var s_faculte = $('select[name=faculte]');

      liste();

      function liste() {
        $('select').attr('disabled', false);
        var t = "type=ecole&" + form.serialize();
        $('select').attr('disabled', true);
        $.getJSON("<?= site_url('ajax/getallrapport') ?>", t, function(d) {
          var str = '',
            data = d.data;
          $(data).each(function(i, data) {
            str += `
						<tr>
							
							<td>${data.nom}</td>
							<td>${data.postnom}</td>
							<td>${data.prenom}</td>
              <td>${data.matricule}</td>
							<td>${data.compte}</td>
							<td>${data.frais}</td>
							<td>${data.option ? data.option : '-'}</td>
							<td>${data.classe}</td>
							<td style="text-align:right">${data.montant} ${data.devise}</td>
              <td>${data.date}</td>
						</tr>
						`;
          })
          table.DataTable().destroy()
          table.children('tbody').html(str)
          table.DataTable(opt).draw()
          $('select').attr('disabled', false);
        })
      }

      form.change(function() {
        var name = $(this).attr('name');
        if (name == 'section') {
          // getOption('section', 'Option');
          $.getJSON("<?= site_url('ajax/options-ecole') ?>", {
            section: $(this).val(),
            type: 'ecole'
          }, function(res) {
            var str = '<option value="">Aucun</option>';
            $(res.options).each(function(i, d) {
              str += `<option value="${d.option}">${d.option}</option>`;
            })
            $('select[name=option]').html(str);
            $('select[name=classe]').html('<option value="">Classe</option>');

            str = '<option value="">Classe</option>';
            if (res.options.length == 0) {
              $(res.classes).each(function(i, d) {
                str += `<option value="${d.idclasse}">${d.intituleclasse} </option>`;
              })
              $('select[name=classe]').html(str);
            }
            liste();
          })
        } else if (name == 'option') {
          // getOption('option', 'Classe');
          $.getJSON("<?= site_url('ajax/classes-ecole') ?>", {
            option: $(this).val(),
            type: 'ecole'
          }, function(res) {
            var str = '<option value="">Classe</option>';
            $(res).each(function(i, d) {
              str += `<option value="${d.idclasse}">${d.classe}</option>`;
            })
            $('select[name=classe]').html(str);
            liste();
          })
        } else {
          liste()
        }
      })

      // getOption = function(source, label) {
      //   var t = `source=${source}&` + form.serialize();
      //   $('select').attr('disabled', true);
      //   $.getJSON("<?= site_url('ajax/select_data2') ?>", t, function(data) {
      //     var str = `<option value="">${label}</option>`;
      //     if (data.length > 0) {
      //       $(data).each(function(i, j) {
      //         var _o = j.nom;
      //         var _v = j.id
      //         str += `<option value="${_v}">${_o} </option>`;
      //       })
      //     }
      //     $(`select[name=${label.toLowerCase()}]`).html(str);
      //     if (source == 'section') {
      //       $(`select[name=classe]`).html('<option value="">Classe</option>');
      //     }
      //     $('select').attr('disabled', false);
      //     liste()
      //   })
      // }


      colors = ["#786BED", "#ff7694", "#21b0ff"];
      var options = {
        chart: {
          height: 300,
          type: "line",
          shadow: {
            enabled: true,
            color: "#000",
            top: 18,
            left: 7,
            blur: 10,
            opacity: 1
          },
          toolbar: {
            show: false
          }
        },
        colors: colors,
        dataLabels: {
          enabled: true
        },
        stroke: {
          curve: "smooth"
        },
        series: [{
            name: "High - 2019",
            data: []
          },
          {
            name: "Low - 2019",
            data: []
          }
        ],
        grid: {
          borderColor: "#e7e7e7",
          row: {
            colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
            opacity: 0.0
          }
        },
        markers: {
          size: 6
        },
        xaxis: {
          categories: ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"],
          labels: {
            style: {
              colors: "#9aa0ac"
            }
          }
        },
        yaxis: {
          labels: {
            style: {
              color: "#9aa0ac"
            }
          },
        },
        legend: {
          position: "top",
          horizontalAlign: "right",
          floating: true,
          offsetY: -25,
          offsetX: -5
        }
      };
      var chart = new ApexCharts(document.querySelector("#graph"), options);
      chart.render();

      chart_data()

      function chart_data(devise = '') {
        $.get("<?= site_url('ajax/chart-data') ?>", {
          devise: devise,
          type: 'ecole'
        }, function(d) {
          d = JSON.parse(d)
          var tab_data = [];
          leg = '';
          var c = 0;
          $.each(d, function(i, j) {
            tab_data.push({
              name: i,
              data: j
            });
            leg += `<span class="badge text-white m-1" style="background: ${colors[c]}; margin: 5px">${i}</span>`;
            c++;
          })

          $('#legende').html(leg);
          chart.updateSeries(tab_data)
        })
      }

      $('.devise').change(function() {
        chart_data($(this).val())
      })

    });
  </script>
</body>
</body>

</html>