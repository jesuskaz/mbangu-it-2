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
            </div>
        </div>

        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header">
                                    <h4>Ajouter une annonce</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p id="rep"></p>
                                            <small>Taille max pour l'image: 100 Ko (Dimensions max : 1000x500)</small>
                                            <form id="f-add" method="post" class="form-inline">
                                                <div class="form-group m-2 d-block">
                                                    <span>Annonce</span> <br>
                                                    <input maxlength="128" name="titre" type="text" class="form-control" placeholder="Titre de l'annonce" required>
                                                </div>
                                                <div class="form-group m-2 d-block">
                                                    <span>Date limite</span> <br>
                                                    <input name="date" type="text" class="form-control datepicker" placeholder="" required>
                                                </div>
                                                <div class="form-group m-2 d-block">
                                                    <span>Image de l'annonce</span> <br>
                                                    <div class="custom-file">
                                                        <input required accept=".png,.gif,.jpg, jpeg" type="file" class="custom-file-input" id="customFile" name="file">
                                                        <label class="custom-file-label" for="customFile">image</label>
                                                    </div>
                                                </div>
                                                <div class="form-group m-2 d-block">
                                                    <br>
                                                    <button class="btn btn-warning" type="submit">Ajouter</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header">
                                    <h4>Nos annonces</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="data"></div>
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

    <?php include("footer.php"); ?>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 id="d-msg"></h5>
                </div>
                <form id="f-del" method="post">
                    <div class="modal-footer">
                        <input type="hidden" name="annonce" value="">
                        <input type="hidden" name="type" value="ecole">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/js/daterangepicker/moment.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/daterangepicker/daterangepicker.js') ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/daterangepicker/daterangepicker.css') ?>" />

    <script>
        $(function() {

            $('.datepicker').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                },
                singleDatePicker: true,
                showDropdowns: true,
                minDate: "<?= date('Y-m-d') ?>"
            });

            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            modal = $('#modal');

            annonce()

            function annonce() {
                $.getJSON("<?= site_url('ajax/annonce') ?>", "type=ecole", function(f) {
                    var str = '';
                    var url = "<?= base_url('/') ?>";
                    var today = moment('<?= date('Y-m-d') ?>', 'YYYY-M-D');

                    $(f).each(function(i, a) {
                        var b = moment(a.dateexpiration, 'YYYY-M-D');
                        diffDays = b.diff(today, 'days');

                        if (diffDays == 0) {
                            em = "Expire ajourd'hui";
                            cl = 'warning';
                        } else if (diffDays == 1) {
                            em = "Expire demain.";
                            cl = 'success';
                        } else if (diffDays > 1) {
                            em = `Expire dans ${diffDays} jours`;
                            cl = 'success';
                        } else {
                            em = "Annonce expir??e.";
                            cl = 'danger';
                        }

                        str += `
                        <div class="col-md-4">
                            <div class="card" style="width: 100%">
                                <img class="card-img-top" src="${url+a.image}" alt="image" height=250>
                                <div class="card-body">
                                    <p class="card-text">${a.titre}</p>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <button value='${a.idannonce}' class='btn btn-link delete' ><i class='fa fa-trash text-danger' ></i></button>
                                    <a href='${url}ecole/annonce-e/${a.idannonce}' class='btn btn-link' ><i class='fa fa-edit' ></i></a>
                                    <b class='text-${cl}' >${em}</b>
                                </div>
                            </div>
                        </div>
                        `;
                    });
                    $('#data').html(str);
                    del();

                })
            }

            $('#f-add').submit(function(e) {
                e.preventDefault();
                var spin = `
                <div class="spinner-border spinner-border-sm text-white" role="status"></div>`;
                var m = $('#rep');
                m.html('');
                var f = $(this);
                var d = new FormData(this);
                d.append('type', 'ecole');
                $(':input', f).attr('disabled', true);
                var btn = $(':submit', f);
                text = btn.text();
                btn.html(spin);

                $.ajax({
                    url: '<?= site_url('ajax/annonce_a') ?>',
                    type: 'POST',
                    data: d,
                    timeout: 0,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        res = $.parseJSON(res);
                        if (res.status) {
                            f.get(0).reset();
                            annonce();
                            m.removeClass().addClass('text-success').html(res.message);
                            $('.datepicker').off('daterangepicker').daterangepicker({
                                locale: {
                                    format: 'YYYY-MM-DD',
                                },
                                singleDatePicker: true,
                                showDropdowns: true,
                                minDate: "<?= date('Y-m-d') ?>"
                            });
                        } else {
                            m.removeClass().addClass('text-danger').html(res.message);
                        }
                        $(':input', f).attr('disabled', false);
                        btn.html(text);
                    },
                    error: function() {
                        m.removeClass().addClass('text-danger').html("Une erreur s'est produite.");
                        $(':input', f).attr('disabled', false);
                        btn.html(text);
                    }
                })
            })

            fdel = $('#f-del');

            function del() {
                $('.delete').off('click').click(function() {
                    $('input[name=annonce]', fdel).val($(this).val())
                    $('#d-msg').html('Proc??der ?? la suppression ?');
                    modal.modal()
                })
            }

            fdel.submit(function(e) {
                e.preventDefault();

                var btn = $(':submit', fdel);
                var txt = btn.text();
                btn.attr('disabled', true);
                var spin = `
                <div class="spinner-border spinner-border-sm text-white" role="status"></div>`;
                btn.html(spin);

                $.post("<?= site_url('ajax/annonce_d') ?>", fdel.serialize(), function(d) {
                    d = JSON.parse(d);

                    if (d.status == true) {
                        annonce();
                        setTimeout(() => {
                            modal.modal('hide')
                        }, 2000);
                    }
                    $('#d-msg').html(d.message);
                    btn.attr('disabled', false);
                    btn.html(txt);
                })
            })


        })
    </script>
</body>

</html>