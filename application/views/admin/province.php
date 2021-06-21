<!DOCTYPE html>
<html lang="en">
<title>Ajouter Province</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php include("heade.php");?>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li>
                            <form class="form-inline mr-auto">
                                <div class="search-element">
                                    <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                        data-width="200" style="width: 200px;">
                                    <button class="btn" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link nav-link-lg message-toggle"><svg xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-mail">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <span class="badge headerBadge1">
                                6 </span> </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Messages
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link notification-toggle nav-link-lg"><svg xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-bell bell">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Notifications
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="main-sidebar sidebar-style-2">
                <?php include("sidebar.php");?>
            </div>
            <!-- Main Content -->
            <div class="main-content">
                <div class="card">
                    <div class="boxs mail_listing">
                        <div class="inbox-center table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="1">
                                            <div class="inbox-header">
                                                Provinces
                                                <center><b><?php if(isset($success)) echo $success;?></b></center>
                                                <center><b><?php if(isset($error)) echo $error; ?></b></center>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <form class="composeForm" name="add_name" method="POST" action="<?=site_url('Province/addProvince'); ?>">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dynamic_field">
                                                <tr>
                                                    <td><input type="text" name="province[][nomProvince]"
                                                            placeholder="Entrer la Province"
                                                            class="form-control name_list" required="" /></td>
                                                    <td><button type="button" name="province" id="province"
                                                            class="btn btn-success">Ajouter un champs</button></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="m-l-25 m-b-20">
                                                <button type="submit" name="submit" id="submit" class="btn btn-info"
                                                    value="Submit">Créer</button>
                                                <button type="button"
                                                    class="btn btn-danger btn-border-radius waves-effect">Annuler</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
                                                <input type="radio" name="value" value="1"
                                                    class="selectgroup-input-radio select-layout" checked>
                                                <span class="selectgroup-button">Light</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="value" value="2"
                                                    class="selectgroup-input-radio select-layout">
                                                <span class="selectgroup-button">Dark</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="p-15 border-bottom">
                                        <h6 class="font-medium m-b-10">Sidebar Color</h6>
                                        <div class="selectgroup selectgroup-pills sidebar-color">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="icon-input" value="1"
                                                    class="selectgroup-input select-sidebar">
                                                <span class="selectgroup-button selectgroup-button-icon"
                                                    data-toggle="tooltip" data-original-title="Light Sidebar"><i
                                                        class="fas fa-sun"></i></span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="icon-input" value="2"
                                                    class="selectgroup-input select-sidebar" checked>
                                                <span class="selectgroup-button selectgroup-button-icon"
                                                    data-toggle="tooltip" data-original-title="Dark Sidebar"><i
                                                        class="fas fa-moon"></i></span>
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
                                                <input type="checkbox" name="custom-switch-checkbox"
                                                    class="custom-switch-input" id="mini_sidebar_setting">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="control-label p-l-10">Mini Sidebar</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="p-15 border-bottom">
                                        <div class="theme-setting-options">
                                            <label class="m-b-0">
                                                <input type="checkbox" name="custom-switch-checkbox"
                                                    class="custom-switch-input" id="sticky_header_setting">
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
            <script type="text/javascript">
            $(document).ready(function() {
                var i = 1;
                $('#province').click(function() {
                    i++;
                    $('#dynamic_field').append('<tr id="row' + i +
                        '" class="dynamic-added"><td><input type="text" name="province[][nomProvince]" placeholder="Entrez la province" class="form-control name_list" required /></td><td><button type="button" name="remove" id="' +
                        i + '" class="btn btn-danger btn_remove">X Supprimer</button></td></tr>');
                });
                $(document).on('click', '.btn_remove', function() {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });

            });
            </script>
            <?php include("footer.php"); ?>
</body>
<!-- widget-chart.html  21 Nov 2019 03:50:03 GMT -->
</html>