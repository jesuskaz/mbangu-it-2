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
                                    <h4>Ajouter un article</h4>
                                </div>
                                <form id="f-add" method="post">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p id="rep"></p>
                                                <p id="rep2"></p>
                                                <small>Taille max pour l'image: 100 Ko (Dimensions max : 1000x500)</small>
                                                <div class="form-inline">
                                                    <div class="form-group m-2 d-block">
                                                        <span>Titre</span> <br>
                                                        <input maxlength="45" name="titre" type="text" class="form-control" placeholder="Titre de l'article" required>
                                                    </div>
                                                    <div class="form-group m-2 d-block">
                                                        <span>Description</span> <br>
                                                        <input name="description" type="text" class="form-control" placeholder="Description de l'article" required>
                                                    </div>
                                                    <div class="form-group m-2 d-block">
                                                        <span>Prix</span> <br>
                                                        <input name="prix" type="number" min='1' class="form-control" placeholder="Prix" required>
                                                    </div>
                                                    <div class="form-group m-2 d-block">
                                                        <span>Devise</span> <br>
                                                        <select name="devise" id="" class="custom-select">
                                                            <?php foreach ($devises as $dev) { ?>
                                                                <option value="<?= $dev->iddevise ?>"><?= $dev->nomDevise ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-inline">
                                                    <div class="form-group m-2 d-block">
                                                        <span>Image principale de l'article</span> <br>
                                                        <div class="custom-file">
                                                            <input required accept=".png,.gif,.jpg, jpeg" type="file" class="custom-file-input" id="customFile" name="file[]">
                                                            <label class="custom-file-label" for="customFile">image</label>
                                                        </div>
                                                    </div>
                                                    <div class="m-2">
                                                        <br>
                                                        <button type="button" class="btn btn-warning add"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="m-image">

                                                </div>
                                                <div class="form-group m-2 d-block">
                                                    <br>
                                                    <button class="btn btn-warning" type="submit">Ajouter</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header">
                                    <h4>Nos articles</h4>
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
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="type" value="ecole">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(function() {

            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            modal = $('#modal');

            annonce()

            function annonce() {
                $.getJSON("<?= site_url('ajax/article') ?>", "type=ecole", function(f) {
                    var str = '';
                    var url = "<?= base_url('/') ?>";
                    var url2 = "<?= site_url('ecole/detail-achat/') ?>";

                    $(f).each(function(i, a) {
                        im = a.image.split(',');
                        im = im[0];
                        str += `
                        <div class="col-md-4">
                            <div class="card" style="width: 100%">
                                <a href="<?= site_url('ecole/detail-article/') ?>${a.idarticle}"><img class="card-img-top" src="${url+im}" alt="image" height=250>
                                </a>
                                <div class="card-body" style='height:200px; overflow:auto;'>
                                    <p class="card-text">${a.titre ?? ''}</p>
                                    <p class="card-text">${a.description ?? ''}</p>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <button value='${a.idarticle}' class='btn btn-link delete' ><i class='fa fa-trash text-danger' ></i></button>
                                    <b>${a.prix } ${a.nomDevise}</b>
                                    <a href='${url2+a.idarticle}'> <i class='fa fa-eye'></i> Details achat</a>
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
                var m2 = $('#rep2');
                m.html('');
                m2.html('');
                var f = $(this);
                var d = new FormData(this);
                d.append('type', 'ecole');
                $(':input', f).attr('disabled', true);
                var btn = $(':submit', f);
                text = btn.text();
                btn.html(spin);

                $.ajax({
                    url: '<?= site_url('ajax/article_a') ?>',
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

                        } else {
                            m.removeClass().addClass('text-danger').html(res.message);
                        }
                        m2.removeClass().addClass('text-danger').html(res.message2);
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
                    $('input[name=id]', fdel).val($(this).val())
                    $('#d-msg').html('Procéder à la suppression ?');
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

                $.post("<?= site_url('ajax/article_d') ?>", fdel.serialize(), function(d) {
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

            $('.add').click(function() {
                var div = $('.m-image');
                n = div.children().length
                var input = `<div class="form-inline" id="d-${n}">
                                <div class="form-group m-2 d-block">
                                    <span>Image de galerie de l'article</span> <br>
                                    <div class="custom-file">
                                        <input required accept=".png,.gif,.jpg, jpeg" type="file" class="custom-file-input" id="customFile" name="file[]">
                                        <label class="custom-file-label" for="customFile">image</label>
                                    </div>
                                </div>
                                <div class="m-2">
                                    <br>
                                    <button value="${n}" type="button" class="btn btn-danger close-i"><i class="fa fa-times"></i></button>
                                </div>
                            </div>`;
                div.append(input);
                n = div.children().length
                closeDiv();
            })

            function closeDiv() {
                $('.close-i').off('click').click(function() {
                    var id = this.value;
                    $('#d-' + id).remove();
                })
            }

        })
    </script>
</body>

</html>