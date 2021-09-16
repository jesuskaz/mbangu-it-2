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
                                    <div class="col-12 mt-3 d-flex justify-content-center">
                                        <b id="sms-rep" class=""></b>
                                    </div>
                                    <div class="card-header">
                                        <h4>Liste élèves</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>Nom</th>
                                                        <th>Post-nom</th>
                                                        <th>Matricule</th>
                                                        <th>Ecole</th>
                                                        <th>Section</th>
                                                        <th>Classe</th>
                                                        <th>Téléphone parent</th>
                                                        <th>Détails</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($eleves as $el) {
                                                        $i = $i + 1;
                                                        $sms = (int) $el->nb_sms > 0 ? '<i style="cursor:pointer" title="SMS déjà envoyé à l\'étudiant " class="fa fa-check-circle text-success"></i>' : '';
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $el->nom  ?></td>
                                                            <td><?php echo $el->postnom  ?></td>
                                                            <td><?php echo $el->matricule  ?></td>
                                                            <td><?php echo $el->ecole  ?></td>
                                                            <td><?php echo $el->section  ?></td>
                                                            <td><?php echo $el->classe  ?></td>
                                                            <td><?php echo $el->telephone  ?></td>
                                                            <td class='d-inline-flex'>
                                                                <a href="<?= site_url('manager/detail-eleve/' . $el->ideleve) ?>">
                                                                    <i class="fa fa-eye"></i> Détails
                                                                </a>
                                                                <button value='<?= $el->ideleve ?>' class='btn btn-warning btn-sm ml-2 mr-2 sms'><i class="fa fa-envelope"></i> <i>SMS</i></button>
                                                                <?= $sms ?>
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
            table = $('.table');
            table.DataTable().destroy()
            sms();
            table.DataTable(opt).draw();

            function sms() {
                $('.sms').off('click').click(function() {
                    var eleve = $(this).val();
                    var btn = $(this);
                    var txt = btn.html();
                    btn.attr('disabled', true);
                    btn.html(`<div class='spinner-border spinner-border-sm'></div>`);
                    $('#sms-rep').html('');
                    $.post('<?= site_url('sms/resend') ?>', {
                        type: 'admin',
                        source: 'ecole',
                        eleve: eleve
                    }, function(d) {
                        d = JSON.parse(d);
                        if (d.status == true) {
                            $('#sms-rep').removeClass().addClass('text-success').html(d.message);
                        } else {
                            $('#sms-rep').removeClass().addClass('text-danger').html(d.message);
                        }
                        btn.attr('disabled', false).html(txt);
                    })
                })
            }

        })
    </script>
</body>

</html>