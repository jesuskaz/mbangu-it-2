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

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informations supplémentaires</h4>
                            </div>
                            <form class="composeForm" name="add_name" method="POST" action="<?= site_url('ecole/option_a') ?>">
                                <div class="">
                                    <div class="">
                                        <div class="card-header">
                                            <a class="btn btn-warning" style="border-radius: 5px;" href="<?php echo site_url('ecole/classes') ?>">Ajouter une classe</a>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card shadow-secondary p-3">
                                                    <div class="form-inline" style="min-height: 150px;">
                                                        <?php
                                                        foreach ($classes as $classe) {
                                                        ?>
                                                            <div class="">
                                                                <div class="pretty p-default m-2">
                                                                    <input id="n-<?php echo  $classe["idclasse"] ?>" type="checkbox" name="classe[]" value="<?php echo $classe["idclasse"]; ?>" />
                                                                    <div class="state p-primary">
                                                                        <label for="n-<?php echo  $classe["idclasse"] ?>"><?php echo  $classe["intituleclasse"] ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card shadow-secondary p-3">
                                                    <div class="" style="min-height: 150px;">
                                                        <div class="form-inline">
                                                            <div class="form-group m-2">
                                                                <select type="text" name="section" class="custom-select custom-select-sm" required>
                                                                    <option value="">Choisissez une section</option>
                                                                    <?php foreach ($sections as $section) {
                                                                    ?>
                                                                        <option value="<?php echo $section["idsection"]; ?>"><?php echo $section["intitulesection"]; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group m-2">
                                                                <input type="text" name="option" placeholder="Entrer l'option" class="form-control " />
                                                            </div>
                                                            <div class="form-group m-2">
                                                                <button type="submit" class="btn btn-warning" value="Submit">Créer</button>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <p class="ml-3 text-muted"><i class="fa fa-info-cirlce text-danger"></i>Vous pouvez ajouter plusieurs options en les séparant par une virgule : Ex. option1, option2, option3, ...</p>
                                                            <p><b class="text-<?= $this->session->classe3; ?>"><?= $this->session->message3; ?></b></p>
                                                            <p><b class="text-<?= $this->session->classe; ?>"><?= $this->session->message; ?></b></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
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

</body>

</html>