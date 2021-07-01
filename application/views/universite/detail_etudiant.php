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
                  <div class="row">
                    <div class="col-lg-9">
                      <div id="graph"></div>
                    </div>
                    <div class="col-lg-3">
                      <div class="row mt-5">
                        <div class="col-12 mb-3">Légende :<b><span class="ml-2" id='legende'></span></b></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="invoice">
                  <div class="invoice-print" id="print">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="row justify-content-between">
                          <div class="p-3">
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
                            <address>
                              <?php if (file_exists($etudiant->picture)) { ?>
                                <a href="<?= base_url($etudiant->picture) ?>">
                                  <img width="200" height="200" src=" <?= base_url($etudiant->picture) ?>" alt="">
                                </a>

                              <?php } ?>
                              <?php if (file_exists($etudiant->carte)) { ?>
                                <br> <br>
                                <a class="mt-2" href="<?= base_url($etudiant->carte) ?>">
                                  Pièce d'identité<i class="ml-1 fa fa-file fa-2x "></i>
                                </a>
                              <?php } ?>
                            </address>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table table-striped table-hover" style="width:100%;">
                            <thead>
                              <tr>
                                <th>N°</th>
                                <th>Frais</th>
                                <th>Montant à payer</th>
                                <th>Montant payé</th>
                                <th>Total payé</th>
                                <th>Reste</th>
                                <th>Date Paiement</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $n = 1;
                              foreach ($paiements as $paie) { ?>
                                <tr>
                                  <td><?= $n++ ?></td>
                                  <td><?= $paie->frais ?></td>
                                  <td class="text-right" ><?= "$paie->montant_frais $paie->devise" ?></td>
                                  <td class="text-right" ><?= "$paie->montant_paye $paie->devise" ?></td>
                                  <td class="text-right" ><?= "$paie->cumule $paie->devise" ?></td>
                                  <td class="text-right" ><?= ($paie->montant_frais - $paie->cumule) . " $paie->devise" ?></td>
                                  <td class="text-right" ><?= $paie->date ?></td>
                                  <td> <a href="<?= site_url('banque/print/' . "$paie->idetudiant-$paie->idpaiement") ?>" class="btn btn-info"><i class="fa fa-print"></i></a> </td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
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

      update()

      function update() {
        var tab = <?= $graph ?>;
        var leg = '';
        var c = 0;
        var tab_data = [];
        $.each(tab, function(i, j) {
          tab_data.push({
            name: i,
            data: j
          });
          leg += `<span class="badge text-white" style="background: ${colors[c]}">${i}</span>`;
          c++;
        })
        $('#legende').html(leg);
        chart.updateSeries(tab_data)
      }
    })
  </script>
</body>

</html>