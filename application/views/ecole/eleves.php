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
                                        <form method="" id="f-change">
                                            <div class="form-inline">
                                                <div class="form-group m-2">
                                                    <select name="section" class="custom-select" id="section">
                                                        <option value="">Section</option>
                                                        <?php foreach ($sections as $sec) {
                                                        ?>
                                                            <option value="<?php echo $sec->idsection ?>"><?php echo $sec->intitulesection  ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group m-2">
                                                    <select name="option" class="custom-select" id="option">
                                                        <option value="">Option</option>
                                                    </select>
                                                </div>
                                                <div class="form-group m-2">
                                                    <select name="classe" class="custom-select" id="classe">
                                                        <option value="">Classe</option>
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
                                        <h4>Liste d'Elèves</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="table-r" class="table table-striped table-hover" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>Nom</th>
                                                        <th>Post-nom</th>
                                                        <th>Section</th>
                                                        <th>Classe</th>
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
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            };

            table = $('#table-r');
            form = $('#f-change');

            table.DataTable().destroy()
            table.DataTable(opt);

            data();

            function data() {
                $('select').attr('disabled', false);
                var t = "type=ecole&" + form.serialize();
                $('select').attr('disabled', true);

                $.getJSON("<?= site_url('ajax/liste-eleve') ?>", t, function(d) {
                    var str = '',
                        data = d.data;
                    $(data).each(function(i, data) {
                        var url = "<?= site_url('ecole/detail-eleve/') ?>" + data.ideleve;
                        str += `
						<tr>
							<td>${i+1}</td>
							<td>${data.nom}</td>
							<td>${data.postnom}</td>
							<td>${data.section}</td>
							<td>${data.classe}</td>
                            <td>${data.matricule ? data.matricule : ''}</td>
							<td style="text-align:center"><a href="${url}"><i class="fa fa-eye"></i> Détail</a></td>
						</tr>
						`;
                    })
                    table.DataTable().destroy()
                    table.children('tbody').html(str)
                    table.DataTable(opt).draw()
                    $('select').attr('disabled', false);
                })
            }

            $('#section').change(function() {
                $('select').attr('disabled', true);
                $.getJSON("<?= site_url('ajax/options-ecole') ?>", {
                    section: $(this).val(),
                    type: 'ecole'
                }, function(res) {
                    var str = '<option value="">Option</option>';
                    $(res).each(function(i, d) {
                        var url = '<?= site_url('ecole/classe/') ?>' + d.id;
                        str += `
                        <option value="${d.id}">${d.option} (${d.section})</option>`;
                    })
                    $('select[name=option]').html(str);
                    $('select[name=classe]').html('<option value="">Classe</option>');
                    data();
                })


            })

            $('#option').change(function() {
                $('select').attr('disabled', true);
                $.getJSON("<?= site_url('ajax/classes-ecole') ?>", {
                    option: $(this).val(),
                    type: 'ecole'
                }, function(res) {
                    var str = '<option value="">Classe</option>';
                    $(res).each(function(i, d) {
                        var url = '<?= site_url('ecole/classe/') ?>' + d.id;
                        str += `
                        <option value="${d.idclasse}">${d.classe} (${d.option})</option>`;
                    })
                    $('select[name=classe]').html(str);
                    data();
                })
            })

            $('#classe').change(function() {
                $('select').attr('disabled', true);
                data();
            })



        })
    </script>
</body>

</html>