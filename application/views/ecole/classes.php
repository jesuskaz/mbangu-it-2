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
            <div class="main-content" style="min-height: 675px;">
                <section class="section">
                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header justify-content-between">
                                        <h4>Ajouter une classe</h4>
                                    </div>
                                    <form class="p-3" method="POST" id="f-add">
                                        <div class="form-inline">
                                            <div class="form-group-sm">
                                                <select name="section2" id="" class="custom-select change2 select">
                                                    <option value="">Section</option>
                                                    <?php foreach ($sections as $sec) { ?>
                                                        <option value="<?= $sec->idsection ?>"><?= $sec->intitulesection ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group-sm ml-3">
                                                <select name="option2" class="custom-select select"></select>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="classe" placeholder="Nom de la classe" class="form-control name_list m-3" required="" />
                                            </div>
                                        </div>
                                        <div class="form-group ml-3 p-0 m-0">
                                            <b msg1></b> <br>
                                            <b msg2></b>
                                        </div>
                                        <p class="ml-3 text-muted"><i class="fa fa-info-cirlce text-danger"></i>Vous pouvez ajouter plusieurs classes en les séparant par une virgule : Ex. classe1, classe2, classe3, ...</p>
                                        <div class="form-group ml-3">
                                            <button type="submit" class="btn btn-warning" value="Submit">Ajouter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <form id="f-data" class="p-3" method="POST">
                                        <div class="form-inline">
                                            <div class="form-group-sm">
                                                <select name="section" id="" class="custom-select change">
                                                    <option value="">Toutes les sections</option>
                                                    <?php foreach ($sections as $sec) { ?>
                                                        <option value="<?= $sec->idsection ?>"><?= $sec->intitulesection ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group-sm ml-3">
                                                <select name="option" id="" class="custom-select change">
                                                    <option value="">Toutes les options</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Liste de classe</h4>
                                    </div>
                                    <div class="col-12 text-center mb-3">
                                        <b class="text-<?= $this->session->classe; ?>"><?= $this->session->message; ?></b>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="t-data" class="table table-striped table-hover" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Classe</th>
                                                        <th>Option</th>
                                                        <th></th>
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
            <?php include("footer.php"); ?>
        </div>
    </div>
    <script>
        $(function() {
            opt = {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            };

            table = $('#t-data');
            form = $('#f-data');
            select = $('.change');
            table.DataTable().destroy()
            table.DataTable(opt);
            select.change(function() {
                var s = $(this).attr('name');
                if (s == 'section') {
                    getoptions();
                } else {
                    getclasse();
                }
            });

            $('.change2').change(function() {
                $('.select').attr('disabled', true);
                $.getJSON("<?= site_url('ajax/options-ecole') ?>", {
                    section: $(this).val(),
                    type: 'ecole'
                }, function(data) {
                    var str = '<option value="">Aucune option</option>';
                    $(data).each(function(i, data) {
                        var url = '<?= site_url('ecole/classe/') ?>' + data.id;
                        str += `
                        <option value="${data.id}">${data.option} (${data.section})</option>`;
                    })
                    $('select[name=option2]').html(str);
                    $('.select').attr('disabled', false);
                })
            })

            $('#f-add').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var btn = $(':submit', form);
                btn.attr('disabled', true);
                btn.html('<i class="fa fa-spinner fa-spin" ></i>');
                $.post("<?= site_url('ajax/add_classe') ?>", form.serialize(), function(r) {
                    r = JSON.parse(r);

                    if (r.status == true) {
                        form.get(0).reset();
                        $('select[name=option2]').html('');
                    }
                    $('b[msg1]').removeClass().addClass(`text-${r.classe}`).html(r.message);
                    $('b[msg2]').removeClass().addClass(`text-${r.classe1}`).html(r.message1);
                    setTimeout(() => {
                        $('b[msg1],b[msg2]').html('');
                    }, 10000);
                    btn.attr('disabled', false).html('Ajouter');
                    getclasse()
                })
            })


            function getoptions() {
                var val = select.val();
                // $('select').attr('disabled', true);
                $.getJSON("<?= site_url('ajax/options-ecole') ?>", {
                    section: val,
                    type: 'ecole'
                }, function(data) {

                    var str = '<option value="">Toutes les options</option>';
                    $(data).each(function(i, data) {
                        var url = '<?= site_url('ecole/classe/') ?>' + data.id;
                        str += `
                        <option value="${data.id}">${data.option} (${data.section})</option>`;
                    })
                    $('select[name=option]').html(str)


                })
            }

            getclasse()

            function getclasse() {
                var val = select.val();

                $('select').attr('disabled', true);
                $.getJSON("<?= site_url('ajax/classes-ecole') ?>", {
                    option: $('select[name=option]').val(),
                    type: 'ecole'
                }, function(data) {

                    var str = '';
                    $(data).each(function(i, data) {
                        var url = '<?= site_url('ecole/delete-c/') ?>' + data.idclasse;
                        str += `
						<tr>
							<td> ${i+1}</td>
							<td>${data.classe}</td>
							<td>${data.option ? data.option : '-'}</td>
							<td><a class='btn btn-link text-danger' href="${url}"><i class="fa fa-trash"></i> Supprimer</a></td>
						</tr>
						`;
                    })
                    table.DataTable().destroy()
                    table.children('tbody').html(str)
                    table.DataTable(opt).draw()
                    $('select').attr('disabled', false);
                })
            }

        })
    </script>
</body>

</html>