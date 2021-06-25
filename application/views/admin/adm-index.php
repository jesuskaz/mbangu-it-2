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
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4" style="height: 200px">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Universités</h5>
                          <h2 class="mb-3 small"><?= count($universites)  ?></h2>
                          <h5 class="font-15">Facultés</h5>
                          <h2 class="mb-3 small"><?= $nb_faculte ?></h2>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="<?= site_url("assets/img/banner/1.png") ?>" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4" style="height: 200px">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15"> Etudiants</h5>
                          <h2 class="mb-3 small"><?= $nb_etudiant ?></h2>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/2.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4" style="height: 200px">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">CA du jour</h5>
                          <?php if (count($nb_ca_jour)) {
                            foreach ($nb_ca_jour as $ca) { ?>
                              <h6 class="mb-3 small"><?= "Total : $ca->montant $ca->devise <br> Commision : $ca->commission $ca->devise" ?></h6>
                            <?php }
                          } else { ?>
                            <h2 class="mb-3 danger">Aucune information</h2>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/3.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4" style="height: 200px">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">CA mensuel</h5>
                          <?php if (count($nb_ca_mensuel)) {
                            foreach ($nb_ca_mensuel as $ca) { ?>
                              <h6 class="mb-3 small"><?= "Total : $ca->montant $ca->devise <br> Commision : $ca->commission $ca->devise" ?></h6>
                            <?php }
                          } else { ?>
                            <h2 class="mb-3 danger">Aucune information</h2>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/4.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
              <div class="card ">
                <div class="card-header">
                  <h4>Statistique de Paiement</h4>
                  <div class="card-header-action">
                    <form class="form-inline form">
                      <div class="form-group p-0 ">
                        <select name="devise" class="custom-select">
                          <option value="">Choisissez la devise</option>
                          <?php foreach ($devises as $de) : ?>
                            <option value="<?= $de->iddevise ?>"><?= $de->nomDevise ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div class="form-group p-1 ">
                        <select name="universite" class="custom-select universite">
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
                  <div class="row">
                    <div class="col-lg-9">
                      <div id="graph"></div>
                    </div>
                    <div class="col-lg-3">
                      <div class="row mt-5">
                        <div class="col-7 col-xl-7 mb-3">
                          <h6>Légende</h6>
                          <h6 id='legende'></h6>
                        </div>
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
                    <h4>Liste des etudiant</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" style="width:100%;">
                        <thead>
                          <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Post-nom</th>
                            <th>Prénom</th>
                            <th>Matricule</th>
                            <th>Faculté</th>
                            <th>Promotion</th>
                            <th>Adresse</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          if (isset($etudiants)) {
                            foreach ($etudiants as $etudiant) {
                              $i = $i + 1;
                          ?>
                              <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $etudiant->nom  ?></td>
                                <td><?php echo $etudiant->postnom  ?></td>
                                <td><?php echo $etudiant->prenom  ?></td>
                                <td><?php echo $etudiant->matricule  ?></td>
                                <td><?php echo $etudiant->nomFaculte  ?></td>
                                <td><?php echo $etudiant->intitulePromotion  ?></td>
                                <td><?php echo $etudiant->adresse  ?></td>
                                <td><?php echo $etudiant->email  ?></td>
                                <td><?php echo $etudiant->telephone  ?></td>
                                <td> <a href="<?= site_url('manager/detail-etudiant/' . $etudiant->idetudiant) ?>">
                                    <i class="fa fa-eye"></i> Détails
                                  </a> </td>
                              </tr>
                          <?php
                            }
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
    </div>
  </div>
  <?php include("footer.php"); ?>

  <script>
    $(function() {

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

      form = $('.form');

      chart_data()

      function chart_data() {

        $.get("<?= site_url('ajax/chart-data') ?>", "type=admin&" + form.serialize(), function(d) {
          d = JSON.parse(d)
          var tab_data = [];
          leg = '';
          var c = 0;
          $.each(d, function(i, j) {
            tab_data.push({
              name: i,
              data: j
            });
            leg += `<span class="badge text-white" style="background: ${colors[c]}">${i}</span>`;
            c++;
          })
          $('#legende').html(leg);
          chart.updateSeries(tab_data)
        })
      }

      form.change(function() {
        chart_data();
      })


    })
  </script>
</body>

</html>