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
                                    <h4 style="cursor: pointer;" title="<?= $article->description ?>"><?= "$article->titre ($article->prix $article->nomDevise)" ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header d-flex justify-content-between">
                                    <h4>Images</h4>
                                    <button class="btn btn-success float-right rounded-0" onclick="history.back()">
                                        <i class="fa fa-arrow-left"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-md-5">
                                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                                <ol class="carousel-indicators">
                                                    <?php $active = 'active';
                                                    $n = 0;
                                                    foreach (explode(',', $article->image) as $img) {
                                                        $img = trim($img);
                                                        if (!empty($img)) { ?>
                                                            <li data-target="#carouselExampleIndicators" data-slide-to="<?= $n++ ?>" class="<?= $active ?>"></li>
                                                    <?php $active = '';
                                                        }
                                                    } ?>
                                                </ol>
                                                <div class="carousel-inner">
                                                    <?php $active = 'active';
                                                    foreach (explode(',', $article->image) as $img) {
                                                        $img = trim($img);
                                                        if (!empty($img)) { ?>
                                                            <div class="carousel-item <?= $active ?>">
                                                                <img width="600" height="400" class="d-block w-100" src="<?= base_url($img) ?>" alt="image article">
                                                            </div>
                                                    <?php $active = '';
                                                        }
                                                    } ?>
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                            <p>
                                                <?= $article->description  ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header">
                                    <h4>Modifer l'article</h4>
                                </div>
                                <form id="f-add" method="post">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p id="rep"></p>
                                                <p id="rep2"></p>
                                                <small>Taille max pour l'image: 100 Ko (Dimensions max : 1000x500)</small>
                                                <input name="id" value="<?= $article->idarticle ?>" type="hidden">
                                                <div class="form-inline">
                                                    <div class="form-group m-2 d-block">
                                                        <span>Titre</span> <br>
                                                        <input maxlength="45" name="titre" value="<?= $article->titre ?>" type="text" class="form-control" placeholder="Titre de l'article" required>
                                                    </div>
                                                    <div class="form-group m-2 d-block">
                                                        <span>Description</span> <br>
                                                        <input name="description" type="text" value="<?= $article->description ?>" class="form-control" placeholder="Description de l'article" required>
                                                    </div>
                                                    <div class="form-group m-2 d-block">
                                                        <span>Prix</span> <br>
                                                        <input name="prix" type="number" min='1' value="<?= $article->prix ?>" class="form-control" placeholder="Prix" required>
                                                    </div>
                                                    <div class="form-group m-2 d-block">
                                                        <span>Devise</span> <br>
                                                        <select name="devise" id="" class="custom-select">
                                                            <?php foreach ($devises as $dev) { ?>
                                                                <option <?= $article->iddevise == $dev->iddevise ? 'selected' : '' ?> value="<?= $dev->iddevise ?>"><?= $dev->nomDevise ?></option>
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
                                                            <input accept=".png,.gif,.jpg, jpeg" type="file" class="custom-file-input" id="customFile" name="file[]">
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
                                                    <button class="btn btn-warning" type="submit">Modifer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
                d.append('type', 'univ');
                $(':input', f).attr('disabled', true);
                var btn = $(':submit', f);
                text = btn.text();
                btn.html(spin);

                $.ajax({
                    url: '<?= site_url('ajax/article_u') ?>',
                    type: 'POST',
                    data: d,
                    timeout: 0,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        res = $.parseJSON(res);
                        if (res.status) {
                            f.get(0).reset();
                            m.removeClass().addClass('text-success').html(res.message);
                            setTimeout(() => {
                                location.reload();
                            }, 1500);

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
            });

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