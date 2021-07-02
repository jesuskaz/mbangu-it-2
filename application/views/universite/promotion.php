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
        <div class="card">
          <div class="card-header">
            <thead>
              <tr>
                <th colspan="1">
                  <div class="inbox-header">
                    <h4>Informations supplémentaires</h4>
                    <center><b><?php if (isset($success)) echo $success; ?></b></center>
                    <center><b><?php if (isset($error)) echo $error; ?></b></center>
                  </div>
                </th>
              </tr>
            </thead>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <form class="composeForm" name="add_name" method="POST" action="addPromo">
                <div class="form-group">
                  <div class="table-responsive">
                    <table class="" id="dynamic_field">
                      <tr>
                        <td><input type="text" name="addmore[][intitulePromotion]" placeholder="Entrer la promotion" class=" m-3 form-control name_list" required="" /></td>
                        <td><button type="button" name="add" id="add" class=" m-3 btn btn-success">Ajouter Promotion</button></td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-lg-12">
                    <div class="m-l-25 m-b-20">
                      <button type="submit" name="submit" id="submit" class="btn btn-warning" value="Submit">Créer</button>
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

    <script type="text/javascript">
      $(document).ready(function() {
        var i = 1;

        $('#add').click(function() {
          i++;
          $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><input type="text" name="addmore[][intitulePromotion]" placeholder="Entrer la promotion" class="form-control m-3 name_list" required /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger m-3 btn_remove">X Supprimer</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function() {
          var button_id = $(this).attr("id");
          $('#row' + button_id + '').remove();
        });

      });
    </script>
</body>

</html>