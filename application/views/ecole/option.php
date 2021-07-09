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
                                        <h4>Ajouter une option</h4>
                                    </div>
                                    <form class="p-3" method="POST" action="<?= site_url('ecole/option_a') ?>">
                                        <div class="form-inline">
                                            <div class="form-group-sm">
                                                <select name="section" id="" class="custom-select">
                                                    <?php foreach ($sections as $sec) { ?>
                                                        <option value="<?= $sec->idsection ?>"><?= $sec->intitulesection ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="option" placeholder="Nom de l'option" class="form-control name_list m-3" required="" />
                                            </div>
                                        </div>
                                        <div class="form-group ml-3 p-0 m-0">
                                            <b class="text-<?= $this->session->classe; ?>"><?= $this->session->message; ?></b> <br>
                                            <b class="text-<?= $this->session->classe3; ?>"><?= $this->session->message3; ?></b>
                                        </div>
                                        <p class="ml-3 text-muted"><i class="fa fa-info-cirlce text-danger"></i>Vous pouvez ajouter plusieurs options en les séparant par une virgule : Ex. option1, option2, option3, ...</p>
                                        <div class="form-group ml-3">
                                            <button type="submit" name="submit" id="submit" class="btn btn-warning" value="Submit">Ajouter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Options</h4>
                                        <div class="card-header-action">
                                            <div class="form-group-sm">
                                                <select name="section" id="s-section" class="custom-select">
                                                    <option value="">Section</option>
                                                    <?php foreach ($sections as $sec) { ?>
                                                        <option value="<?= $sec->idsection ?>"><?= $sec->intitulesection ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center mb-3">
                                        <b class="text-<?= $this->session->classe2; ?>"><?= $this->session->message2; ?></b>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="t-option" class="table table-striped table-hover" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Nom de l'option</th>
                                                        <th>Section</th>
                                                        <th>Classe</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>

                                                <!-- <tr>
                                                        <td><?php echo  $i; ?></td>
                                                        <td><?php echo $sec->intitulesection; ?></td>
                                                        <td><?php echo $sec->intitulesection; ?></td>
                                                        <td class="text-center">
                                                            <a class="btn-link ml-2 text-danger" href="<?= site_url('ecole/delete-s/' . $sec->idsection) ?>"> <i class="fa fa-trash"></i> Supprimer </a>
                                                        </td>
                                                    </tr> -->
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

            table = $('#t-option');
            select = $('#s-section');
            table.DataTable().destroy()
            table.DataTable(opt);
            select.change(function() {
                getoptions();
            })

            getoptions()

            function getoptions() {
                var val = select.val();
                $('select').attr('disabled', true);
                $.getJSON("<?= site_url('ajax/options-ecole') ?>", {
                    section: val,
                    type: 'ecole'
                }, function(data) {

                    var str = '';
                    $(data).each(function(i, data) {
                        var url = '<?= site_url('ecole/classe/') ?>' + data.id;
                        str += `
						<tr>
							<td> ${i+1}</td>
							<td>${data.option}</td>
							<td>${data.section}</td>
							<td><a class='btn btn-link' href="${url}">Afficher les classes</a></td>
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